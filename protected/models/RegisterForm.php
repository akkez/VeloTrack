<?php

/**
 * Created by PhpStorm.
 * Date: 09.05.14
 * Time: 18:47
 */
class RegisterForm extends CFormModel
{
	public $username;
	public $email;
	public $password;

	public function rules()
	{
		return array(
			array('username, email, password', 'required'),
			array('email', 'email'),
			array('username', 'length', 'min' => 2, 'max' => 20),
			array('password', 'length', 'min' => 6),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Имя',
			'email'    => 'Email',
			'password' => 'Пароль',
		);
	}

	public function register()
	{
		$user = new User;

		$user->email     = $this->email;
		$user->username  = $this->username;
		$user->password  = $this->password;
		$user->created   = DateHelper::getCurrentDate();
		$user->lastvisit = DateHelper::getCurrentDate();
		$user->ip        = $_SERVER['REMOTE_ADDR'];
		if (!$user->save())
		{
			$this->addError('', 'Ошибка при регистрации');
			$this->addErrors($user->getErrors());

			return false;
		}

		return true;
	}

}