<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\wizflow\Step1Form */
/* @var $form ActiveForm */
?>
<div class="wizflow-step-1">

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
		    <?php $form = ActiveForm::begin([
		    	'action' => ['index','nav'=>'next']
		    ]); ?>
		
		        <?= $form->field($model, 'favoriteColor')->radioList([
		        	'green'=> 'I like green',
		        	'blue'=> 'I prefer blue'
		        ]) ?>
		    
		        <div class="form-group">
		        	<hr/>
		        	<?= Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Prev',['index','nav'=> 'prev'],['class'=> 'btn  btn-primary', 'role'=> 'button'])?>&nbsp;
		            <?= Html::submitButton('Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['class' => 'btn btn-primary']) ?>
		        </div>
		        
		    <?php ActiveForm::end(); ?>		
		</div>
	</div>

</div><!-- wizflow-step-1 -->
