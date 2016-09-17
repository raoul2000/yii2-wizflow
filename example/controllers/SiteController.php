<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'wizflow' => [
              'class' => '\raoul2000\wizflow\WizardPlayAction'
            ]
        ];
    }

    public function actionFinish()
    {
    	return $this->render('finish',[
    		'path' => Yii::$app->wizflowManager->getPath()
    	]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
