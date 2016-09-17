<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;


/**
 * ContactForm is the model behind the contact form.
 */
class WelcomeForm extends  Model implements \raoul2000\wizflow\WizflowModelInterface
{
    public $name;
    public $email;
    public $status;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
    public function summary()
    {
    	return 'Hello <b>'. Html::encode($this->name) . '</b>';
    }
}
