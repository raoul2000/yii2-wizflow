<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use raoul2000\workflow\validation\WorkflowScenario;

/**
 * ContactForm is the model behind the contact form.
 */
class GreenForm extends Model implements \raoul2000\wizflow\WizflowModelInterface
{
    public $greenStuff;
    public $status;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['greenStuff'], 'required'],
        ];
    }
    public function summary()
    {
    	return 'green like : '. Html::encode($this->greenStuff);
    }
}
