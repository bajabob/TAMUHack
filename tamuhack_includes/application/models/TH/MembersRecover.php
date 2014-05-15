<?php

class Application_Model_TH_MembersRecover extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'th_members_recover';	

    
	/**
	* add registration hash to table
	*/
	public function createNewRecovery($email, $activation)
	{
	
		$arr = array(
				'email' 		=> strtolower($email),
				'activation'	=> $activation
		);
	
		return $this->insert($arr);
	}
    
	
	/**
	 *
	 * @param string $email
	 * @return bool
	 */
	public function exists($email, $activation)
	{
		$row = $this->fetchRow(
				$this->select()
				->where('email = ?', strtolower($email))
				->where('activation = ?', $activation)
		);
		if($row !== null){
			return true;
		}
		return false;
	}	
	
	
	/**
	 * delete a row by the user's email
	 * @see Zend_Db_Table_Abstract::delete()
	 */
	public function deleteEntry($email)
	{
		$where = $this->getAdapter()->quoteInto('email = ?', strtolower($email));
		$this->delete($where);
	}
	
}