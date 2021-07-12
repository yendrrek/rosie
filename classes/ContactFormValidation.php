<?php
class ContactFormValidation
{
	public $generalNotification;
	public $msg;
	public $msgError;
	public $msgValidatedWillBeSubmited;
	public $senderEmail;
	public $senderEmailError;
	public $senderName;
	public $senderNameError;
	private $userInput;

	public function validateContactForm()
	{    
		if (!empty($_POST['tokenCsrf'])) {
		    if (hash_equals($_SESSION['tokenCsrf'], $_POST['tokenCsrf'])) {
			    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		            $this->validateSenderName();
		            $this->validateSenderEmailAddress();
		            $this->validateMsg();
		            $this->supplyResultOfValidation();
			    }
			} else {
		  	    error_log('Token not validated in contact form at rosiepiontek.com', 1, 'yendrrek@gmail.com');
		    }
		}	
	}

	private function validateSenderName()
	{
		if (!empty($_POST['senderName'])) {
        	$this->senderName = $this->sanitize($_POST['senderName']);
        	if (!preg_match("/^[A-Za-z .,'-]+$/", $this->senderName)) { /* https://gist.github.com/patotoma/8860726 */
        		$this->senderNameError = 'Invalid characters found.';
        	}
        } else {
        	$this->senderNameError = 'Name is required.';
        }
	}

	private function validateSenderEmailAddress()
	{
		if (!empty($_POST['senderEmail'])) {
	    	$this->senderEmail = filter_var($_POST['senderEmail'], FILTER_SANITIZE_EMAIL);
	    	if (filter_var($this->senderEmail, FILTER_VALIDATE_EMAIL)) {
	    		$this->senderEmailError = false;
	    	} else {
	    		$this->senderEmailError = 'Enter a valid e-mail address.';
	    	}
	    } else {
	        $this->senderEmailError = 'E-mail address is required.';
	    }
	}

	private function validateMsg() 
	{
		if (!empty($_POST['msg'])) {
            $this->msg = $this->sanitize($_POST['msg']);
            if (!preg_match("/^[A-Za-z0-9_ .,!?@'+()-]+$/m", $this->msg)) {
            	$this->msgError = 'Invalid characters found.';
            }
        } else {
            $this->msgError = 'Message is required.';
        }
	}

	private function supplyResultOfValidation()
	{
		$failedToSendMsg = '';

        $failedToSendMsg = (
        	empty($_POST['senderName']) ||
            empty($_POST['senderEmail']) || 
        	empty($_POST['msg']) ||
            $this->senderNameError === 'Invalid characters found.' ||
            $this->senderEmailError === 'Enter a valid e-mail address.' ||
            $this->msgError === 'Invalid characters found.'
        );

        if ($failedToSendMsg) {
            $this->generalNotification = 'Message not sent, please see below.';
        } else {
    	    $this->msgValidatedWillBeSubmited = true;
        }
	}

	private function sanitize($userInput) /* https://www.w3schools.com/php/php_form_validation.asp */
	{
	    $this->userInput = trim($userInput);
	    $this->userInput = stripslashes($userInput);
	    $this->userInput = htmlspecialchars($userInput);
	  
	    return $this->userInput;
	}
}