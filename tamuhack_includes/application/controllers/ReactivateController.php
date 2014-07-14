<?php

class ReactivateController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout()->setLayout("org");
    }


    public function indexAction()
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
    		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    		{
    			$hasError = true;
    			$fields["error"] = "Not a valid email!";
    		}
    		
    		$th = new Application_Model_TH_Members();
    		
    		
    		if($hasError)
    		{
    			$this->view->fields = $fields;
    		}
    		else if($th->exists($email)) // email is in system
    		{
    			$user = $th->getMember($email);
    			
    			$sha = new Application_Model_TH_NanoSha256();
    			$activation = $sha->getSaltedHash($email, time());
    	
		    	$thActivate = new Application_Model_TH_MembersActivate();
		    	$thActivate->createNewActivation($email, $activation);
		    	
		    	
		    	// create view object
		    	$html = new Zend_View();
		    	$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
		    	
		    	// assign valeues
		    	$html->assign('name', $user->name_first);
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
		    	
		    	return $this->_redirect('/register/activationsent/name/'.$user->name_first);
    		}else 
    		{
    			$fields["error"] = "Email not in system.";
    			$this->view->fields = $fields;
    		}
    	}
    }

}
