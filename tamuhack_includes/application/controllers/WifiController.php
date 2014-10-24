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
    		 
    		$canSkip = false;
    		if(strpos($name, "123") !== FALSE){
    			$canSkip = true;
    		}
    		
    		$email = strtolower(trim($request->getPost('email', "")));
    		$fields["email"] = $email;
    		if(!$this->endsWith($email, ".edu") && !$canSkip)
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
    	$request = $this->getRequest();
    	$fields = array(
    			"key"=> ""
    	);
    	
    	$hasError = false;
    	$keyError = "Invalid key, please try again or generate a new code. You can only see your Wifi password once.";
    	
    	/**
    	 * a post action has occured, validate data
    	*/
    	if($request->isPost())
    	{
    		 
    		$key = trim($request->getPost('key', ""));
    		$fields["key"] = $key;
    		if(strlen($key) != 8)
    		{
    			$hasError = true;
    			$fields["key_error"] = $keyError;
    		}
    		 
    		else
    		{
    			$guests = new Application_Model_TH_GuestWifiUsers();
    			
    			if($guests->hasSeenCode($key) && $guests->codeExists($key))
    			{
    				$hasError = true;
    				$fields["key_error"] = $keyError;
    			}
    			else
    			{
    				$codes = new Application_Model_TH_GuestWifiCodes();
    				
    				$wifi = $codes->getNextCode();
    				
    				$codes->takeCode($wifi['id']);
    				
    				$guests->shownCode($key, $wifi['id']);
    				
    				$this->view->wifi = $wifi;
    			}
    		}
    		
    		if($hasError)
    		{
    			$this->view->fields = $fields;
    		}
    	}
    }
    
    function endsWith($haystack, $needle)
    {
    	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }
}
