<?php
class ContactFormDb 
{
    private $dbc;

    public function __construct(\PDO $pdo)
    {
        $this->dbc = $pdo;
    }

    public function insertContactFormDb(ContactFormValidation $contactFormValidation, UserId $userId)
    {   
        $this->senderName = $contactFormValidation->senderName;
        $this->senderEmail = $contactFormValidation->senderEmail;
        $this->msg = $contactFormValidation->msg;
        $this->userId = $userId->userId;

        $stmt = $this->dbc->prepare('INSERT INTO contactForm(userId, senderName, senderEmail, msg)
            VALUES (:userId, :senderName, :senderEmail, :msg)');
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':senderName', $this->senderName);
        $stmt->bindParam(':senderEmail', $this->senderEmail);
        $stmt->bindParam(':msg', $this->msg);
        $stmt->execute();
        $stmt = $this->dbc = null;
    }
}
    