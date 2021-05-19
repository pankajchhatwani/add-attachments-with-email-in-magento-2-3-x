<?php
namespace Globalgarner\EmailAttachments\Mail\Template;

class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    public function addAttachment($fileString,$filename)
    {
        $arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ]
        ];
        /* if $fileString is url of file */
        $this->message->setBodyAttachment(file_get_contents($fileString, false, stream_context_create($arrContextOptions)), $filename);

        /* if $fileString is string data */
        $this->message->setBodyAttachment($fileString, $filename);
        return $this;
    }

    protected function prepareMessage()
    {
        parent::prepareMessage();
        $this->message->setPartsToBody();
        return $this;
    }
}