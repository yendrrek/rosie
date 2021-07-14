<?php
class ContactFormSubmition 
{   
    public $generalNotification;
    public $msgSentWillAmendDb;

    public function sendMsg(ContactFormValidation $contactFormValidation)
    {   
        EnvironmentVariablesValidation::validateContactFormAddressee();

        $this->senderName = $contactFormValidation->senderName;
        $this->senderEmail = $contactFormValidation->senderEmail;
        $this->msg = $contactFormValidation->msg;
        
        $this->toEmail = EnvironmentVariablesValidation::$contactFormAddressee; 
        $this->subject = 'Website contact form';
        $this->headers = 'From ' . $this->senderName . '<' . $this->senderEmail . '>';
        
        if (mail($this->toEmail, $this->subject, $this->msg, $this->headers)) {
            $this->generalNotification = 'Message sent. Thank you.';
            $this->msgSentWillAmendDb = true;
        }
    }
}