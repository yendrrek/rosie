<?php

namespace Rosie\Services\Contact;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Rosie\Utils\EnvironmentVariables;
use Rosie\Utils\Logging;

class ContactFormSubmission
{
    public string $generalNotification = '';

    public function __construct(
        private Logging $logging,
        private ContactFormFields $contactFormFields
    ) {
    }

    public function sendMessage(): bool
    {
        $senderName = $this->contactFormFields->getSenderName();
        $senderEmailAddress = $this->contactFormFields->getSenderEmailAddress();
        $message = $this->contactFormFields->getMessage();
        $subject = 'Website contact form';
        $toEmail = EnvironmentVariables::$rosieEmail;
        $host = EnvironmentVariables::$contactFormEmailHost;

        $phpmailer = new PHPMailer();

        try {
            $phpmailer->isSMTP();
            $phpmailer->Host = $host;
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = 'TLS';
            $phpmailer->Port = 587;
            $phpmailer->Username = EnvironmentVariables::$contactFormUserName;
            $phpmailer->Password = EnvironmentVariables::$contactFormPassword;
            $phpmailer->Subject = $subject;
            $phpmailer->addAddress($toEmail, 'Rosie');
            $phpmailer->setFrom($senderEmailAddress, $senderName);
            $phpmailer->Body = $message;
            $phpmailer->isHTML(false);

            if ($phpmailer->send()) {
                $this->generalNotification = 'Message sent. Thank you';
                $this->logging->logMessage('info', 'Message sent');
                return true;
            }
        } catch (Exception $e) {
            $this->logging->logMessage('alert', 'Failed sending message from contact form. ' . $e->errorMessage());
            return false;
        }
        return false;
    }
}
