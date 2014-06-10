<?php

class AdminController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout()->setLayout("index");
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	if(!isset($auth->id))
    	{
    		return $this->_forward('/portal/logout');
    	}else if($auth->account_type < 90)
    	{
    		return $this->_redirect('/portal/invalidcreds');
    	}
    	else{
    		$this->view->auth = $auth;
    	}
    }


    public function indexAction()
    {
    
    }
    
    public function mailoutAction()
    {
    	$request = $this->getRequest();
    	
    	/**
    	 * a post action has occured, validate data
    	*/
    	if($request->isPost())
    	{
    		$members = new Application_Model_TH_Members();
    		$people = $members->getAll();
    		foreach($people as $person)
    		{
	    		$mail = new Zend_Mail('utf-8');
	    		$mail->setBodyHtml($request->getPost("body"));
	    		$mail->setFrom('noreply@tamuhack.com', 'No-Reply: TAMUHack');
    			$mail->addTo($person->email, $person->name_first." ".$person->name_last);
	    		$mail->setSubject($request->getPost("subject"));
	    		$mail->send();
    		}
    	}
    }
    

	public function membersAction()
	{
		$members = new Application_Model_TH_Members();
		$this->view->members = $members->getAll();
	} 
 
}
