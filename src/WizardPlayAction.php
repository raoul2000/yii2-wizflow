<?php
namespace raoul2000\wizflow;

use Yii;

class WizardPlayAction extends \yii\base\Action
{
    public $wizardManagerName = 'wizflowManager';
    public $url = ['wizflow'];
    public $urlFinish = ['finish'];

    public function run($nav = 'start')
    {
      $wizard = Yii::$app->get($this->wizardManagerName);

    	if( $nav == 'prev' ) {
    		$model = $wizard->getPreviousStep();
    		if( $model == null) {
    			$this->controller->redirect(array_merge($this->url, ['nav'=>'start']));
    		}
    	} elseif($nav == 'start') {
    		$model = $wizard->start();
    	} else  {

    		$model = $wizard->getCurrentStep();
        if( $model == null) {
          	$this->controller->redirect($this->urlFinish);
        } else {

          if( $model->load(Yii::$app->request->post()) && $model->validate()) {
            // current step has been completed : save it and get next step
            $wizard->updateCurrentStep($model);
            $model = $wizard->getNextStep();
            if( $model == null) {
              //we reached the last step : save it and go tp the finish page
              $wizard->save();
              $this->controller->redirect($this->urlFinish);
            }
          }
        }
    	}
      if ($model != null ) {
        $viewname = $model->getWorkflowStatus()->getMetadata('view');
        $wizard->save();
        return $this->controller->render($viewname,[
          'model' => $model,
          'path'  => $wizard->getPath()
        ]);
      }
    }
}
