<?php

namespace App\Helper;

use App\Config;
use \Swift_MailTransport;
use \Swift_Signers_DKIMSigner;
use \Swift_Message;
use \Swift_Mailer;

class Mail
{

    private $transport;
    private $signer;
    private $from;
    private $mailer;

    public function __construct() {
        $this->transport = Swift_MailTransport::newInstance();
        $private = file_get_contents(__DIR__.'/../key/dkim.private.key');
        $this->signer =  new Swift_Signers_DKIMSigner($private, Config::$DOMAIN, 'default');
        $this->from = Config::$FROM;
        $this->mailer = Swift_Mailer::newInstance($this->transport);
    }

    public function sendMessage($to, $subjet, $body){
        $message = Swift_Message::newInstance();
        $message->setFrom($this->from, Config::$FROM_NAME);
        $message->setTo($to);
        $message->setSubject($subjet);
        $message->attachSigner($this->signer);
        $message->setBody($body[0], 'text/plain');
        $message->addPart($body[1], 'text/html');

        if($this->mailer->send($message) > 0)
            return true;
        return false;
    }
}