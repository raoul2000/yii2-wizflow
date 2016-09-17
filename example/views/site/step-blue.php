<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\wizflow\BlueForm */
/* @var $form ActiveForm */
?>
<div class="wizflow-step-blue">

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
			<div class="alert alert-info">
				Yes, blue is a nice color. Can you name the most beautiful thing you have ever seen with a blue color in it ?
			</div>
			
		    <?php $form = ActiveForm::begin([
		    	'action' => ['','nav'=>'next']
		    ]); ?>

		        <?= $form->field($model, 'blueStuff') ?>

		        <div class="form-group">
		        	<hr/>
		        	<?= Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Prev',['','nav'=> 'prev'],['class'=> 'btn  btn-primary', 'role'=> 'button'])?>&nbsp;
		            <?= Html::submitButton('Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['class' => 'btn btn-primary']) ?>
		        </div>
		    <?php ActiveForm::end(); ?>
		</div>
	</div>

</div><!-- wizflow-step-blue -->
