<?php
namespace raoul2000\wizflow;

use Yii;
use raoul2000\workflow\base\Status;
use yii\base\Exception;
use yii\base\InvalidConfigException;

/**
 * Implement the Wizard UI design pattern using yii2-workflow.
 */
class WizflowManager extends \yii\base\Object
{
	/**
	 * @var array SimpleWorkflowBehavior configuration array attached to all wizard steps
	 */
	public $workflowBehavior = [
		'class' => '\raoul2000\workflow\base\SimpleWorkflowBehavior',
		'defaultWorkflowId' => 'Wizflow'
	];
	/**
	 * @var string name of the workflow behavior that is attached to all wizards steps
	 */
	public $workflowBehaviorName = 'wizflowBehavior';
	/**
	 * @var string Name of the workflow source component to use
	 */
	public $workflowSourceName = 'workflowSource';
	/**
	 * @var IWorkflowSource the workflow source instance
	 */
	private $_ws;
	/**
	 * @var string session key name used to store steps
	 */
	public $skeyName = '_wiz';
	/**
	 * This array stores the wizards state :
	 * - the current step (key = 'current')
	 * - a list of all steps that have been performed so far (key = 'path')
	 *
	 * Example :
	 * <pre>
	 * [
	 * 		'current' => [
	 * 			'attrib1' => 'value1',
	 * 			//...
	 * 			'status'     => 'Wizflow/step',
	 * 		],
	 * 		'path' => [
	 * 			'Wizflow/step' => [
	 * 				'attrib1' => 'value1',
	 * 				//...
	 * 				'status'     => 'Wizflow/step',
	 * 			],
	 * 			//etc ...
	 * 		]
	 * ]
	 *</pre>
	 */
	private $_wiz = [
		'current' => null,
		'path'    => []
	];
	/**
	 * Loads existing wizard data if available.
	 *
	 * @see \yii\base\Object::init()
	 */
	public function init()
	{
		if( empty($this->skeyName) || ! is_string($this->skeyName)) {
			throw new InvalidConfigException('Parameter "skeyName" must be a non-empty string');
		}

		if( empty($this->workflowSourceName) || ! is_string($this->workflowSourceName)) {
			throw new InvalidConfigException('Parameter "workflowSourceName" must be a non-empty string');
		}

		$this->_ws = Yii::$app->get($this->getWorkflowSourceName());

		$wiz =  Yii::$app->session->get($this->skeyName,null);
		if($wiz !== null) {
			$this->_wiz = $wiz;
		}
	}
	/**
	 * Returns the name workflow source component to use.
	 * Note that the component must be available and registred in the Yii::$app container.
	 *
	 * @return string The name of the workflow source component
	 */
	public function getWorkflowSourceName()
	{
		return $this->workflowSourceName;
	}

	/**
	 * Returns the workflow source component used by the manager
	 * @return IWorkflowSource the workflow source component instance
	 */
	public function getWorkflowSource()
	{
		return $this->_ws;
	}
	/**
	 * Creates and returns the form model instance for the status attribute.
	 * Note that the attribute array passed as argument must include the status value.
	 *
	 * The instance is created using the 'model' metadata value associated with the 'status'
	 * attribute value. The metadata 'model' must be an array suitable to invoke Yii::createObject().
	 *
	 * Once created, the SimpleWorkflowBehavior is attached to the model.
	 *
	 * @param array $attributes list of attributes
	 * @throws Exception
	 * @return Model
	 */
	private function createInstance($attributes)
	{
		if( isset($attributes['status']) == false ) {
			throw new Exception('missing attribute "status"');
		}

		$status = $this->workflowSource->getStatus($attributes['status']);
		$config = array_merge(
			$status->getMetadata('model'),
			$attributes
		);
		$instance = Yii::createObject($config);
		$instance->attachBehavior(
			$this->workflowBehaviorName,
			$this->workflowBehavior
		);

		return $instance;
	}
	/**
	 * Save the wizard data into the current session
	 */
	public function save()
	{
		Yii::$app->session->set($this->skeyName,$this->_wiz);
	}
	/**
	 * @return boolean TRUE if the wizard process as started (i.e. a current step is available)
	 * FALSE otherwise.
	 */
	public function hasCurrentStep()
	{
		return $this->_wiz['current'] != null;
	}
	/**
	 * Updates the current step with the model passed as argument.
	 *
	 * @param Model $model
	 * @throws Exception
	 */
	public function updateCurrentStep($model)
	{
		if( $this->hasCurrentStep() == false ) {
			throw new Exception('wizard has no current step');
		}
		$this->_wiz['current'] = $model->getAttributes();
	}
	/**
	 * Returns the model associated with the current wizard step.
	 *
	 * @return Model|null the current stemp model instance or NULL if no current step is defined.
	 */
	public function getCurrentStep()
	{
		$currentStep = null;
		if( $this->hasCurrentStep() ) {
			$currentStep = $this->createInstance($this->_wiz['current']);
		}
		return $currentStep;
	}

	/**
	 * Returns an array containing all steps models that have been done until now.
	 * The current step is not included in the returned array.
	 *
	 * @return array list of steps that have been performed until now
	 */
	public function getPath()
	{
		$path = [];
		foreach ($this->_wiz['path'] as $stepConfig) {
			$stepModel = $this->createInstance($stepConfig);
			$path[] = $stepModel;
		}
		return $path;
	}
	/**
	 * Add the current step to the path and creates the next step form which becomes the new current step.
	 *
	 * @return Model the new current step
	 */
	public function getNextStep()
	{
		$nextStep = null;
		if ( $this->hasCurrentStep()) {
			// add current step to the path

			$currentStep = $this->getCurrentStep();
			$this->_wiz['path'][$currentStep->getWorkflowStatus()->getId()] = $this->_wiz['current'];
			$this->_wiz['current'] = null;

			// find the next step

			$nextStatuses = $currentStep->getNextStatuses(true, true);
			$nextStep = null;
			if( count($nextStatuses) != 0) {
				foreach($nextStatuses as $info) {
					if( $info['isValid']) {
						// create the next step Form instance
						$nextStep = $this->createInstance(['status' => $info['status']->getId()]);

						// save it as the current step
						$this->_wiz['current'] = $nextStep->getAttributes();

						break;
					}
				}
			}
		}
		return $nextStep;
	}
	/**
	 * Replace the current step, with the last step of the path and returns it.
	 *
	 * @return Model the new current step
	 */
	public function getPreviousStep()
	{
		$prevStep = null;
		if( count($this->_wiz['path']) != 0) {

			$config = array_pop($this->_wiz['path']);

			// replace current step
			$this->_wiz['current'] = $config;

			// create instance
			$prevStep = $this->createInstance($config);
		}
		return $prevStep;
	}
	/**
	 * Initiate the wizard.
	 * This method reset the existing wizard path and returns the model for the first step.
	 *
	 * @return Model the model for the first step
	 */
	public function start()
	{
		$workflow = $this->workflowSource->getWorkflow('Wizflow');

		$status = $workflow->getInitialStatus();
		$config = $status->getMetadata('model');
		$config['status'] =  $status->getId();

		$firstStep = $this->createInstance($config);

		$this->_wiz['current'] =  $firstStep->getAttributes();
		$this->_wiz['path'] = [];

		return $firstStep;
	}
	/**
	 * Clean up session data that may have been stored by this wizard.
	 */
	public function destroy()
	{
		Yii::$app->session->remove($this->skeyName);
	}
}
