<?php

class Application_Model_OrnSaveManager
	extends Zend_Db_Table_Abstract
{
	protected $_name = 'orn_save_transfers';	

	
	
	/**
	 * 
	 * @param string $name
	 * @param bytearray $data
	 */
	public function add($name, $data){
		$data = array(
			'name' 			=> strtoupper($name),				
			'timestamp'		=> time(),
			'data'			=> $data
		);

		$this->insert($data);
		
		// delete saves older than 24 hours
		$this->delete($this->getAdapter()->quoteInto('timestamp <= ?', (time() - 86400000)));
	}
	
	public function get($name){
		$row = $this->fetchRow(
			$this->select()
				->where('name = ?', strtoupper($name))
		);
		if($row != null){
			return $row->data;
		}return null;
	}
	
	
}