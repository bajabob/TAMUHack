<?php

class Application_Model_OrnAccountsManager
	extends Zend_Db_Table_Abstract
{
	protected $_name = 'orn_portal_accounts';	
	

	/**
	 * does the specified user exist in the DB? If it does, fetch it.
	 * @param string $username
	 * @return $row | null
	 */
	public function getByUsername($username){

		$row = $this->fetchRow(
	   		$this->select()
			      ->where('username = ?', strtolower($username))
		);
		if($row != null){
			return $row;
		}
		return null;
	}
	
}