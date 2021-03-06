<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $role
 * @property string $password
 */
class User extends CActiveRecord
{
	public $password;
	public $password_repeat;
	public $is_authenticated = false;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	public function save()
	{
		if ($this->password != $this->password_repeat) { return false; }
		if ($this->password != '')
		{
			$bcrypt = new Bcrypt(8);
			$this->password_hash = $bcrypt->hash($this->password);
			$this->password = '';
			$this->password_repeat = '';
		}
		elseif ($this->password_hash == null)
		{
			return false;
		}
		return parent::save();
	}

	public function authenticate($password)
	{
		$bcrypt = new Bcrypt(2);
		$this->is_authenticated =  $bcrypt->verify($password, $this->password_hash);
		return $this->is_authenticated;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'length', 'max'=>100),
			array('role', 'length', 'max'=>10),
			array('password', 'length', 'max'=>60),
			array('password_repeat', 'compare', 'compareAttribute' => 'password'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, role', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'role' => 'Role',
			'password' => 'Password',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('role',$this->role,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
