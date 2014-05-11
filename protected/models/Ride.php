<?php

/**
 * This is the model class for table "ride".
 *
 * The followings are the available columns in table 'ride':
 * @property integer $id
 * @property integer $user_id
 * @property string $created
 * @property string $comment
 * @property string $track
 * @property string $length
 */
class Ride extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ride';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('user_id, created, track', 'required'),
			array('user_id', 'numerical', 'integerOnly' => true),
			array('comment', 'safe', 'on' => 'update'),
			array('id, user_id, created, comment, track', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'      => 'Номер',
			'user_id' => 'Юзер',
			'created' => 'Дата поездки',
			'comment' => 'Пометка',
			'track'   => 'Координаты',
			'length'  => 'Длина',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ride the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
	{
		$this->length = GeoHelper::getLengthOfPath($this->track);

		return parent::beforeSave();
	}

}