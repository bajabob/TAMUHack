<?php

require_once "Zend/Mailchimp.php";

class RegisterController extends Zend_Controller_Action
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


    public function indexAction()
    {
    	$request = $this->getRequest();
    	$fields = array("name_first" => "", "name_last" => "", "email" => "");


    	/**
    	 * a post action has occured, validate data
    	 */
    	if($request->isPost())
    	{
    		$hasError = false;

    		$validator = new Zend_Validate_Alpha(array('allowWhiteSpace' => true));

    		$name_first = trim($request->getPost('name_first', ""));
    		$fields["name_first"] = $name_first;
    		if(!$validator->isValid($name_first) || $name_first == "")
    		{
    			$hasError = true;
    			$fields["name_first_error"] = "Not a valid name!";
    		}

    		$name_last = trim($request->getPost('name_last', ""));
    		$fields["name_last"] = $name_last;
    		if(!$validator->isValid($name_last) || $name_last == "")
    		{
    			$hasError = true;
    			$fields["name_last_error"] = "Not a valid name!";
    		}

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

    		$th = new Application_Model_TH_Members();
    		
    		if($th->exists($email))
    		{
    			// email is already in system
    			return $this->_redirect('/register/emailexists/email/'.$email);
    		}
    		else if($hasError)
    		{
				$this->view->fields = $fields;
    		}
    		else
    		{
				// create account and generate email
				$sha = new Application_Model_TH_NanoSha256();
				$pass = $sha->getSaltedHash($email, $password);
				
				$th->createNewUser($name_first, $name_last, $email, $pass, 10);
				
				//$this->generateActivationEmail($email, $name_first, $name_last, $sha);
				
				$mc = new Mailchimp("398f08e6e69a3fa86638a205cba2ca95-us9");
				$mc->call("/lists/subscribe", array(
						"id" => "47a0fc88db",
						"send_welcome" => false,
						"double_optin" => false,
						"email" => array("email" => $email)
				));
				
				return $this->_redirect('rsvp');
    		}
    	}    	
    }
    
    public function recoverAction()
    {
    	$request = $this->getRequest();
    	$fields = array("email" => "");
    	
    	
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
    			$fields["email_error"] = "Not a valid email";
    		}
    		
    		$th = new Application_Model_TH_Members();
    		//s$thExt = new Application_Model_Hack_Members();
    		
    		if(!$th->exists($email))
    		{
    			// email is NOT already in system
    			$hasError = true;
    			$fields["email_error"] = "Email not found in system. Are you sure you registered?";
    		}
    		
    		if($hasError)
    		{
    			$this->view->fields = $fields;
    		}
    		else
    		{
    			$sha = new Application_Model_TH_NanoSha256();
    			$activation = $sha->getSaltedHash($email, time());
    			 
    			$thActivate = new Application_Model_TH_MembersRecover();
    			$thActivate->createNewRecovery($email, $activation);
    			 
    			// create view object
    			$html = new Zend_View();
    			$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
    			 
    			// assign valeues
    			$html->assign('email', $email);
    			$html->assign('activation', $activation);
    			 
    			// render view
    			$bodyText = $html->render('recoverpassword.phtml');
    			 
    			$mail = new Zend_Mail('utf-8');
    			$mail->setBodyHtml($bodyText);
    			$mail->setFrom('noreply@tamuhack.com', 'No-Reply: tamuHack');
    			$mail->addTo($email, $name_first." ".$name_last);
    			$mail->setSubject('Recover your TAMUHack account password');
    			$mail->send();
    			
     			return $this->_redirect('/register/recoverysent/email/'.$email);
				
    		}
    	}
    }
    
    public function newactivationemailAction()
    {
    	/**
    	 * todo
    	 * create a link for generating a new activation link
    	 */
    }
    
    
    private function generateActivationEmail($email, $name_first, $name_last, $sha)
    {
    	$activation = $sha->getSaltedHash($email, time());
    	
    	$thActivate = new Application_Model_TH_MembersActivate();
    	$thActivate->createNewActivation($email, $activation);
    	
    	
    	// create view object
    	$html = new Zend_View();
    	$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
    	
    	// assign valeues
    	$html->assign('name', $name_first);
    	$html->assign('email', $email);
    	$html->assign('activation', $activation);
    	
    	// render view
    	$bodyText = $html->render('activation.phtml');
    	
    	$mail = new Zend_Mail('utf-8');
    	$mail->setBodyHtml($bodyText);
    	$mail->setFrom('noreply@tamuhack.com', 'No-Reply: TAMUHack');
    	$mail->addTo($email, $name_first." ".$name_last);
    	$mail->setSubject('Activate your TAMUHack account');
    	$mail->send();
    }
    
    
    public function setpassAction()
    {
    	$request = $this->getRequest();
    	$email = $request->getParam('email', "");
    	$this->view->email = $email;
    	$activation = $request->getParam('activation', "");
		$this->view->activation = $activation;
		
    	$thRec = new Application_Model_TH_MembersRecover();
    	 
    	$this->view->showform = false;
    	
    	// activation exists
    	if($thRec->exists($email, $activation))
    	{
			// allow user to reset password
    		$this->view->showform = true;
    		
    		/**
    		 * a post action has occured, validate data
    		 */
    		if($request->isPost())
    		{
    			$hasError = false;
    			
    			$password = $request->getPost('password', "");
    			$fields["password"] = "";
    			if(strlen($password) < 8)
    			{
    				$hasError = true;
    				$fields["password_error"] = "Password must be at least 8 characters!";
    			}
    			
    			if($hasError)
    			{
    				$this->view->fields = $fields;
    			}
    			else
    			{
    				$thRec->deleteEntry($email);
    				$members = new Application_Model_TH_Members();
    				$membersExt = new Application_Model_Hack_Members();
    				
    				$sha = new Application_Model_TH_NanoSha256();
    				$pass = $sha->getSaltedHash(strtolower($email), $password);
    				
    				if($members->exists($email)){
    					$members->editUser($email, array('pass' => $pass));
    				}
    				if($membersExt->exists($email)){
    					$membersExt->editUser($email, array('pass' => $pass));
    				}
    				
    				return $this->_redirect('/register/passwordset');
    			}
    		}
    	}
    }
    
    
    public function passwordsetAction()
    {
    }
    
    
    public function activateAction()
    {
    	$request = $this->getRequest();
    	$email = $request->getParam('email', "");
    	$activation = $request->getParam('activation', "");
    	
    	$thActivate = new Application_Model_TH_MembersActivate();
    	
    	// activation exists
    	if($thActivate->exists($email, $activation))
    	{
    		$thActivate->deleteEntry($email);
    		
    		$members = new Application_Model_TH_Members();
    		
    		$members->editUser($email, array('email_verified' => 1));
    		
    		return $this->_redirect('/register/accountactivated/email/'.$email);
    	}
    	// activation doesn't exist
    	else
    	{
    		echo "Activation link invalid. If this issue continues, please contact support@tamuhack.com.";
    	}
    }
    
    public function accountactivatedAction()
    {
    	$request = $this->getRequest();
    	$this->view->email = $request->getParam('email');
    }
    
    public function emailexistsAction()
    {
    	$this->view->email = $this->_getParam('email');
	}
	
	public function activationsentAction()
	{
		$this->view->name = $this->_getParam('name');
	}
	
	public function recoverysentAction()
	{
		$this->view->email = $this->_getParam('email');
	}

}
