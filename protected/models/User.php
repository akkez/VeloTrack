<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $ip
 * @property string $lastvisit
 * @property string $created
 * @property string $default_lat
 * @property string $default_lng
 * @property string $default_zoom
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username, email, password, ip, lastvisit, created', 'required'),
			array('username, email', 'length', 'max' => 25),
			array('username', 'unique', 'className' => 'User', 'attributeName' => 'username'),
			array('email', 'unique', 'className' => 'User', 'attributeName' => 'email'),
			array('password', 'length', 'max' => 50),
			array('id, username, email, password, ip, lastvisit, created', 'unsafe', 'on' => 'home'),
			array('default_lat, default_lng, default_zoom', 'numerical', 'on' => 'home'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'rides' => array(self::HAS_MANY, 'Ride', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'        => 'Номер',
			'username'  => 'Имя',
			'email'     => 'Email',
			'password'  => 'Пароль',
			'ip'        => 'IP регистрации',
			'lastvisit' => 'Последний вход',
			'created'   => 'Первый вход',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function checkPassword($password)
	{
		return sha1($password . Yii::app()->params['passwordSalt']) === $this->password;
	}

	private function hashPassword($password)
	{
		return sha1($password . Yii::app()->params['passwordSalt']);
	}

	public function beforeSave()
	{
		if ($this->getIsNewRecord())
		{
			$this->password = $this->hashPassword($this->password);
		}

		return parent::beforeSave();
	}
}
