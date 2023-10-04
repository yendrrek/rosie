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
        $mailtrapTestToEmail = EnvironmentVariables::$mailtrapTestToEmail;
        $host = EnvironmentVariables::$emailHost;
        $environment = EnvironmentVariables::$environment;
        $rosieEmail = EnvironmentVariables::$emailUserName;

        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'TLS';
            $mail->Port = 587;
            $mail->Username = $rosieEmail;
            $mail->Password = EnvironmentVariables::$emailPassword;
            $mail->Subject = 'rosiepiontek.com contact form. Sender: ' . $senderName . ', ' . $senderEmailAddress;
            if ($environment === 'production') {
                $mail->addAddress($rosieEmail, 'Rosie');
            } elseif ($environment === 'sandbox') {
                $mail->addAddress($mailtrapTestToEmail, 'Rosie');
            }
            $mail->Body = $message;
            $mail->isHTML(false);

            if ($mail->send()) {
                $this->generalNotification = 'Message sent. Thank you';
                $this->logging->logMessage('info', 'Message sent');
                return true;
            } else {
                $this->logging->logMessage('alert', 'Failed sending message from contact form. ' . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            $this->logging->logMessage('alert', 'Exception thrown when sending message from contact form. ' . $e->errorMessage());
            return false;
        }
        return false;
    }
}
