<?php
namespace core\forms\auth;


use yii\base\Model;
use core\entities\User;


class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

}
