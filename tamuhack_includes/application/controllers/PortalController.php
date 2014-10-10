<?php

class PortalController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout()->setLayout("org");
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	if(!isset($auth->id))
    	{
    		return $this->_redirect('logout');
    	}else{
    		$this->view->auth = $auth;
    	}
    }


    public function indexAction()
    {
    	$this->view->tinymceHeight = 200;
    	$this->view->tinymceCharLimit = 500;
    	
    	$request = $this->getRequest();
    	$fields = array(
    			"grad_year"=> "",
    			"linkedin" => "",
    			"hack_xp" => ""
    	);
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	$applications = new Application_Model_TH_Applications();
    	
    	/**
    	 * a post action has occured, validate data
    	*/
    	if($request->isPost())
    	{
    		$hasError = false;
    	
    		$validator = new Zend_Validate_Alpha(array('allowWhiteSpace' => true));
    	
    		$grad_year = trim($request->getPost('grad_year', ""));
    		$fields["grad_year"] = $grad_year;
    	
    		$hackXp = trim($request->getPost('hack_xp', ""));
    		$fields["hack_xp"] = $hackXp;
    		if(strlen($hackXp) == 0)
    		{
    			$hasError = true;
    			$fields["hack_xp_error"] = "Please list some of your previous hackathon experiences!";
    		}
    	
    		$linkedin = trim($request->getPost('linkedin', ""));
    		$fields["linkedin"] = $linkedin;
    	
    		if($hasError)
    		{
    			$this->view->fields = $fields;
    		}
    		else
    		{
    			$applications->createNewApplication($auth->id, $grad_year, "TAMU", $linkedin, $hackXp, "$0.00");
    		}
    	}

    	$application = $applications->getApplicaiton($auth->id);
    	
    	$this->view->application = $application;
    }
    

    public function logoutAction()
    {
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	$auth->unsetAll();
    }
    
    public function invalidcredsAction(){}

}
