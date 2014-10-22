<?php

class WifiController extends Zend_Controller_Action
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
    	
    }
    
    public function sendcodeAction()
    {
    	$request = $this->getRequest();
    	$fields = array(
    			"name"=> "",
    			"email" => ""
    	);
    	 
    	 
    	/**
    	 * a post action has occured, validate data
    	*/
    	if($request->isPost())
    	{
    		$hasError = false;
    		 
    		$validator = new Zend_Validate_Alpha(array('allowWhiteSpace' => true));
    		 
    		$name = trim($request->getPost('name', ""));
    		$fields["name"] = $name;
    		if(strlen($name) < 6)
    		{
    			$hasError = true;
    			$fields["name_error"] = "Please enter a longer name!";
    		}
    		 
    		$email = strtolower(trim($request->getPost('email', "")));
    		$fields["email"] = $email;
    		if(!$this->endsWith($email, ".edu"))
    		{
    			$hasError = true;
    			$fields["email_error"] = "Email must end with (.edu)!";
    		}
    		 
    		if($hasError)
    		{
    			$this->view->fields = $fields;
    		}
    		else
    		{
    			$sha = new Application_Model_TH_NanoSha256();
    			$code = substr($sha->getSaltedHash(time()."T2013", $name.$email."TAMHK"), 0, 8);
    			
    			$guests = new Application_Model_TH_GuestWifiUsers();
    			$guests->addUser($name, $email, $code);
    			
    			// create view object
    			$html = new Zend_View();
    			$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
    			 
    			// assign valeues
    			$html->assign('name', $name);
    			$html->assign('code', $code);
    			 
    			// render view
    			$bodyText = $html->render('guestwificode.phtml');
    			 
    			$mail = new Zend_Mail('utf-8');
    			$mail->setBodyHtml($bodyText);
    			$mail->setFrom('noreply@tamuhack.com', 'No-Reply: TAMUHack');
    			$mail->addTo($email, $name);
    			$mail->setSubject('Wifi Retrieval Code');
    			$mail->send();
    			
    			$this->view->success = true;
    		}
    	}
    }
    
    public function genwifiAction()
    {
    	
    }
    
    function endsWith($haystack, $needle)
    {
    	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }
}
