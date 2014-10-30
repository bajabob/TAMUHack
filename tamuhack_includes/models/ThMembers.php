<?php

namespace app\models;

use Yii;
use yii\base\Security;

/**
 * This is the model class for table "th_members".
 *
 * @property integer $id
 * @property integer $account_type
 * @property string $name_first
 * @property string $name_last
 * @property string $email
 * @property string $pass
 * @property integer $rep
 * @property integer $email_verified
 */
class ThMembers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'th_members';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_type', 'name_first', 'name_last', 'email', 'pass', 'rep', 'email_verified'], 'required'],
            [['account_type', 'rep', 'email_verified'], 'integer'],
            [['name_first', 'name_last', 'email'], 'string', 'max' => 100],
            [['pass'], 'string', 'max' => 64],
        	['email', 'filter', 'filter'=>'strtolower'],
        	['email', 'unique']
        ];
    }
    
    /**
     * get the specified user by thier email
     * @param string $email
     */
    public function getUser($email)
    {
    	return ThMembers::find()
    		->where(['email' => trim(strtolower($email))])
    		->one();
    }
    
    
    /**
     * does the specified user exist in the DB?
     * @param string $email
     * @return boolean
     */
    public function doesUserExist($email)
    {
    	if($this->getUser($email) !== null)
    		return true;
    	return false;
    }
    
    /**
     * generate a password based on a given email and plaintext password
     * @param string $email
     * @param string $plainTextPassword
     * @return string
     */
    public function generatePassword($email, $plainTextPassword)
    {
    	return hash('sha256', $plainTextPassword . 
    							strtolower($email) . 
    							strrev($plainTextPassword) . 
    							strrev($plainTextPassword));
    }
    
    
    /**
     * does the specified plaintest password match the stored one in the database?
     * @param string $email
     * @param string $plainTextPassword
     * @return boolean
     */
    public function verifyPassword($email, $plainTextPassword)
    {
    	$result = $this->getUser($email);
    	if($result !== null)
    	{
    		if($result->pass == $this->generatePassword($email, $plainTextPassword))
    		{
    			return true;
    		}
    	}
    	return false;
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_type' => 'Account Type',
            'name_first' => 'Name First',
            'name_last' => 'Name Last',
            'email' => 'Email',
            'pass' => 'Password',
            'rep' => 'Reputation',
            'email_verified' => 'Email Verified',
        ];
    }
}
