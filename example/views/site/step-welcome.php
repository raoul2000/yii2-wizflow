<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\wizflow\WelcomeForm */
/* @var $form ActiveForm */
?>
<div class="wizflow-step-welcome">

	<div class="row">
		<div class="col-lg-2">
			<h3>Summary</h3>
			<hr/>
		</div>
		<div class="col-lg-10">
		    <?php $form = ActiveForm::begin([
		    	'action' => ['index','nav'=>'next']
		    ]); ?>
		
		        <?= $form->field($model, 'name') ?>
		        <?= $form->field($model, 'email') ?>
		    
		        <div class="form-group">
		        	<hr/>
		            <?= Html::submitButton('Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['class' => 'btn btn-primary']) ?>
		        </div>
		        
		    <?php ActiveForm::end(); ?>
		</div>
	</div>

</div><!-- wizflow-step-welcome -->
