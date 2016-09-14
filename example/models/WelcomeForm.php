<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class WelcomeForm extends  Model
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
            // name, email, subject and body are required
            [['name', 'email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }
    public function summary()
    {
    	return 'Hi '.$this->name;
    }
}
