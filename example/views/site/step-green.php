<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\wizflow\GreenForm */
/* @var $form ActiveForm */
?>
<div class="wizflow-step-green">

	<div class="row">
		<div class="col-lg-2">
			<h3>Summary</h3>
			<hr/>
			<?php
				foreach($path as $step){
					echo $step->summary().'<br/>';
				}
			?>
		</div>
		<div class="col-lg-10">
			<div class="alert alert-success">
				All right, green then. Do you have something green in mind ? 
			</div>

		    <?php $form = ActiveForm::begin([
		    	'action' => ['','nav'=>'next']
		    ]); ?>

		        <?= $form->field($model, 'greenStuff') ?>

		        <div class="form-group">
		        	<hr/>
		        	<?= Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Prev',['','nav'=> 'prev'],['class'=> 'btn  btn-primary', 'role'=> 'button'])?>&nbsp;
		            <?= Html::submitButton('Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['class' => 'btn btn-primary']) ?>
		        </div>
		    <?php ActiveForm::end(); ?>
		</div>
	</div>


</div><!-- wizflow-step-green -->
