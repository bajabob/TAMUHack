<?php

class RegisterController extends Zend_Controller_Action
{


    public function init()
    {
    	$this->_helper->layout()->setLayout("index");
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
				
				
				$th->createNewUser($name_first, $name_last, $email, $pass);
				
				$activation = $sha->getSaltedHash($email, time());
				
				$thActivate = new Application_Model_TH_MembersActivate();
				$thActivate->createNewActivation($email, $activation);
				
				// create view object
				$html = new Zend_View();
				$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
				
				// assign valeues
				$html->assign('email', $email);
				$html->assign('activation', $activation);
				
				// create mail object
				$mail = new Zend_Mail('utf-8');
				
				// render view
				$bodyText = $html->render('activation.phtml');
				
				// configure base stuff
				$mail->addTo($email);
				$mail->setSubject('Activate your tamuHack account');
				$mail->setFrom('noreply@tamuhack.com','tamuHack');
				$mail->setBodyHtml($bodyText);
				$mail->send();
				
				return $this->_redirect('/register/success/name/'.$name_first);
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
    		$lookup = stripos($email, "@tamu.edu");
    		if($lookup === false)
    		{
    			$hasError = true;
    			$fields["email_error"] = "Not a valid email. Must be \"@tamu.edu\"!";
    		}
    		
    		$th = new Application_Model_TH_Members();
    		
    		if(!$th->exists($email))
    		{
    			// email is NOT already in system
    			$hasError = true;
    			$fields["email_error"] = "Email not found in system. Are you sure you registered?";
    		}
    		
    		if($hasError)
    		{
    			$this->view->fields = $fields;
    		}else
    		{
    			echo "email found, sending email...";
    		}
    	}
    }
    
    public function emailexistsAction()
    {
    	$this->view->email = $this->_getParam('email');
	}
	
	public function successAction()
	{
		$this->view->name = $this->_getParam('name');
	}

}
