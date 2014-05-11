<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_WRONG_LOGIN_OR_PASSWORD = 10001;

	private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array(
			'username' => $this->username
		));
		/* @var User $user */
		if ($user === null)
		{
			$this->errorCode = self::ERROR_WRONG_LOGIN_OR_PASSWORD;
		}
		else
		{
			if ($user->checkPassword($this->password))
			{
				$this->errorCode = self::ERROR_NONE;
				$this->_id       = $user->getPrimaryKey();

				$user->lastvisit = new CDbException('NOW()');
				$this->setState('isAdmin', $this->username === 'admin');
				$user->save();
			}
			else
			{
				$this->errorCode = self::ERROR_WRONG_LOGIN_OR_PASSWORD;
			}
		}

		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}