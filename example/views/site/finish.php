<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
?>
<h1>We are done : Thanks ! </h1>
<hr/>
<p><?= Html::a('One more time ...',['index','nav'=>'start']) ?></p>
<div class="row">
	<div class="col-lg-12">
		<h3>Summary</h3>
		<hr/>		
		<?php
			foreach($path as $step){
				echo $step->summary().'<br/>';
			} 
		?>			
	</div>
</div>
