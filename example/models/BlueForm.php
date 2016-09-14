<?php

namespace app\models;

use Yii;
use yii\base\Model;
use raoul2000\workflow\validation\WorkflowScenario;

/**
 * ContactForm is the model behind the contact form.
 */
class BlueForm extends Model
{
    public $blueStuff;
    public $status;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['blueStuff'], 'required'],
        ];
    }
    public function summary()
    {
    	return 'blue stuff : '.$this->blueStuff;
    }
}
