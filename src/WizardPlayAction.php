<?php
namespace raoul2000\wizflow;

use Yii;

class WizardPlayAction extends \yii\base\Action
{
    public $wizardManagerName = 'wizflowManager';

    public function run($nav = 'start')
    {
      $wizard = Yii::$app->get($this->wizardManagerName);

    	if( $nav == 'prev' ) {
    		$model = $wizard->getPreviousStep();
    		if( $model == null) {
    			$this->redirect(['index','nav'=>'start']);
    		}
    	} elseif($nav == 'start') {
    		$model = $wizard->start();
    	} else {

    		$model = $wizard->getCurrentStep();

	    	if( $model->load(Yii::$app->request->post()) && $model->validate()) {

	    		$wizard->updateCurrentStep($model);
	    		// current step has been completed : save it and get next step
	    		$model = $wizard->getNextStep();
	    		if( $model == null) {
	    			//we reached the last step
	    			$wizard->save();
	    			$this->redirect(['finish']);
	    		}
	    	}
    	}
    	$viewname = $model->getWorkflowStatus()->getMetadata('view');
    	$wizard->save();
      return $this->controller->render($viewname,[
      	'model' => $model,
      	'path'  => $wizard->getPath()
      ]);
    }
}
