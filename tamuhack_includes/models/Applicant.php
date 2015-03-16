<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "Applicants".
 *
 * @property integer $UserID
 * @property string $FullName
 * @property string $Email
 * @property string $Password
 * @property string $ZipCode
 * @property string $School
 * @property string $HackathonExperience
 * @property string $GradYear
 * @property string $AuthKey
 * @property string $PasswordResetToken
 */
class Applicant extends \yii\db\ActiveRecord {


	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'Applicants';
	}


	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
			[ 
				[ 
					'FullName',
					'Email',
					'Password',
					'ZipCode',
					'School',
					'HackathonExperience',
					'GradYear' 
				],
				'required' 
			],
			[ 
				[ 
					'FullName' 
				],
				'string',
				'max' => 100 
			],
			[ 
				[ 
					'Email',
					'School' 
				],
				'string',
				'max' => 250 
			],
			[ 
				[ 
					'Password',
					'AuthKey' 
				],
				'string',
				'max' => 60 
			],
			[ 
				[ 
					'ZipCode' 
				],
				'string',
				'max' => 5 
			],
			[ 
				[ 
					'HackathonExperience' 
				],
				'string',
				'max' => 1000 
			],
			[ 
				[ 
					'GradYear' 
				],
				'string',
				'max' => 4 
			],
			[ 
				[ 
					'PasswordResetToken' 
				],
				'string',
				'max' => 50 
			],
			[ 
				[ 
					'Email' 
				],
				'unique' 
			],
			[ 
				'Email',
				'filter',
				'filter' => 'strtolower' 
			] 
		];
	}


	/**
	 * Attempt to create a new application in DB
	 * 
	 * @param unknown $fullname        	
	 * @param unknown $email        	
	 * @param unknown $password        	
	 * @param unknown $hackExperience        	
	 * @param unknown $school        	
	 * @param unknown $gradYear        	
	 * @param unknown $zip        	
	 * @return boolean
	 */
	public static function create($fullname, $email, $password, $hackExperience, $school, $gradYear, $zip) {
		$user = new Applicant ();
		$user->FullName = $fullname;
		$user->Email = $email;
		$user->Password = Yii::$app->security->generatePasswordHash ( $password );
		$user->HackathonExperience = $hackExperience;
		$user->School = $school;
		$user->GradYear = $gradYear;
		$user->ZipCode = $zip;
		return $user->save ();
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::findOne ( [
			'UserID' => $id
		] );
	}
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		return static::findOne ( [
			'AuthKey' => $token
		] );
	}
	
	/**
	 * Finds user by email
	 *
	 * @param string $email
	 * @return \app\models\Applicant
	 */
	public static function findByEmail($email) {
		return static::findOne ( [
			'Email' => strtolower($email)
		] );
	}
	
	/**
	 * Finds user by password reset token
	 *
	 * @param string $token
	 *        	password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token) {
		if (! static::isPasswordResetTokenValid ( $token )) {
			return null;
		}
	
		return static::findOne ( [
			'PasswordResetToken' => $token
		] );
	}
	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token
	 *        	password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token) {
		if (empty ( $token )) {
			return false;
		}
		$expire = Yii::$app->params ['user.passwordResetTokenExpire'];
		$parts = explode ( '_', $token );
		$timestamp = ( int ) end ( $parts );
		return $timestamp + $expire >= time ();
	}
	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey() {
		$this->AuthKey = Yii::$app->security->generateRandomString ();
	}
	
	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken() {
		$this->PasswordResetToken = Yii::$app->security->generateRandomString () . '_' . time ();
	}
	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->getPrimaryKey ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->AuthKey;
	}
	
	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey () === $authKey;
	}
	
	/**
	 * Validates password
	 *
	 * @param string $password
	 *        	password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword ( $password, $this->Password );
	}
	
	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->Password = Yii::$app->security->generatePasswordHash ( $password );
	}
	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken() {
		$this->PasswordResetToken = null;
	}
	
	
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [ 
			'UserID' => 'User ID',
			'FullName' => 'Full Name',
			'Email' => 'Email',
			'Password' => 'Password',
			'ZipCode' => 'Zip Code',
			'School' => 'School',
			'HackathonExperience' => 'Hackathon Experience',
			'GradYear' => 'Grad Year',
			'AuthKey' => 'Auth Key',
			'PasswordResetToken' => 'Password Reset Token' 
		];
	}
}
