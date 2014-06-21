<?php

class RegisterextController extends Zend_Controller_Action
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
    	$this->view->tinymceHeight = 200;
    	$this->view->tinymceCharLimit = 500;
    	
    	$request = $this->getRequest();
    	$fields = array(
    			"name_first" => "", 
    			"name_last" => "", 
    			"email" => "",
    			"grad_year"=> "",
    			"school" => "",
    			"linkedin" => "",
    			"travel_costs" => "",
    			"hack_xp" => ""
    	);


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
    		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    		{
    			$hasError = true;
    			$fields["email_error"] = "Not a valid email!";
    		}
    		
    		$password = $request->getPost('password', "");
    		$fields["password"] = "";
    		if(strlen($password) < 8)
    		{
    			$hasError = true;
    			$fields["password_error"] = "Password must be at least 8 characters!";
    		}
    		
    		$grad_year = trim($request->getPost('grad_year', ""));
    		$fields["grad_year"] = $grad_year;
    		
    		$school = trim($request->getPost('school', ""));
    		$fields["school"] = $school;
    		if(strlen($school) == 0)
    		{
    			$hasError = true;
    			$fields["school_error"] = "Please enter your current school!";
    		}
    		
    		$hackXp = trim($request->getPost('hack_xp', ""));
    		$fields["hack_xp"] = $hackXp;
    		if(strlen($hackXp) == 0)
    		{
    			$hasError = true;
    			$fields["hack_xp_error"] = "Please list some of your previous hackathon experiences!";
    		}
    		
    		$linkedin = trim($request->getPost('linkedin', ""));
    		$fields["linkedin"] = $linkedin;

    		$travelCosts = trim($request->getPost('travel_costs', ""));
    		$fields["travel_costs"] = $linkedin;
    		
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
				$id = $th->createNewUser($name_first, $name_last, $email, $pass, 0);
				
				$application = new Application_Model_TH_Applications();
				$application->createNewApplication($id, $grad_year, $school, $linkedin, $hackXp, $travelCosts);
				
				$this->generateActivationEmail($email, $name_first, $name_last, $sha);
				
				return $this->_redirect('/registerext/activationsent/name/'.$name_first);
    		}
    	}    	
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
    	$bodyText = $html->render('activation_ext.phtml');
    	
    	$mail = new Zend_Mail('utf-8');
    	$mail->setBodyHtml($bodyText);
    	$mail->setFrom('noreply@tamuhack.com', 'No-Reply: TAMUHack');
    	$mail->addTo($email, $name_first." ".$name_last);
    	$mail->setSubject('Activate your TAMUHack account');
    	$mail->send();
    }
	
	public function activationsentAction()
	{
		$this->view->name = $this->_getParam('name');
	}

}
