<?php

class LoginController extends Zend_Controller_Action
{


    public function init()
    {
    	$this->_helper->layout()->setLayout("org");
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	if(isset($auth->id))
    	{
    		$this->view->auth = $auth;
    	}
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
    		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    		{
    			$hasError = true;
    			$fields["email_error"] = "Not a valid email.";
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
    			$memberExt = new Application_Model_Hack_Members();

    			if($member->exists($email) || $memberExt->exists($email))
    			{
    				if($member->hasVerifiedEmail($email) || $member->hasVerifiedEmail($email))
    				{
    					if ($member->checkCredentails($email, $password))
    					{
    						$user = $member->getMember($email);
    						$authNamespace = new Zend_Session_Namespace('Zend_Auth');
    						$authNamespace->id = $user['id'];
    						$authNamespace->email = $user['email'];
    						$authNamespace->name_first = $user['name_first'];
    						$authNamespace->name_last = $user['name_last'];
    						$authNamespace->account_type = $user['account_type'];
    						$authNamespace->name = $user['name_first']." ".$user['name_last'];
    						return $this->_redirect('/portal');
    					}
    					else if($memberExt->checkCredentails($email, $password))
    					{
    						$user = $memberExt->getMember($email);
    						$authNamespace = new Zend_Session_Namespace('Zend_Auth');
    						$authNamespace->id = $user['id'];
    						$authNamespace->email = $user['email'];
    						$authNamespace->name_first = $user['name_first'];
    						$authNamespace->name_last = $user['name_last'];
    						$authNamespace->account_type = $user['account_type'];
    						$authNamespace->name = $user['name_first']." ".$user['name_last'];
    						return $this->_redirect('/portal');
    					}
    				}
    				else 
    				{
    					$fields["error"] = "Email not verified! Please check your inbox for an activation link.
    						If you need a new activation email please email us at support@tamuhack.com";
    				}	
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
