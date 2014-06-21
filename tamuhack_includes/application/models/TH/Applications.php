<?php

class Application_Model_TH_Applications extends Zend_Db_Table_Abstract{

	
	protected $_name = 'th_applications';	

    
	/**
	* start the register process for a new user account
	*/
	public function createNewApplication($id, $grad_year, $school, $linkedin, $hackXp, $travelCosts){
	
		$arr = array(
				'id'			=> $id,
				'is_accepted'	=> 0,
				'grad_year'		=> $grad_year,
				'school'		=> $school,
				'linkedin'		=> $linkedin,
				'hack_xp'		=> $hackXp,
				'travel_costs'	=> $travelCosts
		);
	
		return $this->insert($arr);
	}
    
	
	/**
	 *
	 * @param string $email
	 * @return bool
	 */
	public function exists($id){
		$row = $this->fetchRow(
				$this->select()
				->where('id = ?', $id)
		);
		if($row !== null){
			return true;
		}
		return false;
	}	
	
	
	/**
	 * get the user's data row
	 * @param string $user
	 */
	public function getApplicaiton($id){
		$row = $this->fetchRow(
		$this->select()
			->where('id = ?', $id)
		);
		return $row;
	}
	
	
	public function getAll()
	{
		$rows = $this->fetchAll(
				$this->select()
		);
		return $rows;
	}
	
}