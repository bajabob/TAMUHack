<?php

class LoginController extends Zend_Controller_Action
{


    public function init()
    {
    	$this->_helper->layout()->setLayout("index");
    }


    public function indexAction(){
    	$request = $this->getRequest();

    	$fields = array("email" => $request->getParam('email', ""));
    	
    	
    	/**
    	 * a post action has occured, validate data
    	*/
    	if($request->isPost())
    	{
    		$hasError = false;
    	
    		$email = trim($request->getPost('email', ""));
    		$fields["email"] = $email;
    		$lookup = stripos($email, "@tamu.edu");
    		if($lookup === false)
    		{
    			$hasError = true;
    			$fields["email_error"] = "Not a valid email. Must be \"@tamu.edu\"!";
    		}
    	
    		$password = $request->getPost('password', "");
    		$fields["password"] = "";
    		if(strlen($password) < 8)
    		{
    			$hasError = true;
    			$fields["password_error"] = "Password must be at least 8 characters!";
    		}
    	
    		
    		if(!$hasError)
    		{
    			$member = new Application_Model_TH_Members();

    			if(!$member->hasVerifiedEmail($email))
    			{
    				$fields["error"] = "Email not verified! Please check your inbox for an activation link. 
    						If you need a new activation email please click the activation link below.";
    			}
    			else if ($member->checkCredentails($email, $password))
    			{
    				
    			}
    			else 
    			{
    				$fields["error"] = "Invalid email/password combination!";
    			}
    		}
    	}
    	$this->view->fields = $fields;
    }
}
