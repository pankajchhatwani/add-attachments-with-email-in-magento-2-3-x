<?php
namespace Globalgarner\EmailAttachments\Helper;

use Magento\Customer\Model\Session;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_EMAIL = 'agreement/vendoragreement/template';

    protected $inlineTranslation;
    protected $transportBuilder;
    protected $template;
    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Globalgarner\EmailAttachments\Model\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) 
    {
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function generateTemplate()
    {
        // path for attachment File
        $attachmentFile = 'http://localhost/ggmall/test.pdf';
        $fileName = 'email.pdf';

        $emailTemplateVariables['message'] = 'This is a test message by meetanshi.';
        //load your email tempate
        $this->template  = $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getStoreId()
        );
        $this->inlineTranslation->suspend();

//        print_r($this->template); exit;
        $this->transportBuilder->setTemplateIdentifier('agreement_vendoragreement_template')
        ->setTemplateOptions(
            [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $this->storeManager->getStore()->getId(),
            ]
        )
        ->setTemplateVars($emailTemplateVariables)
        ->setFrom([
            'name' => 'Test',
            'email' => 'postmaster@mg.globalgarner.in',
        ])
        ->addTo('pankaj.chhatwani@globalgarner.com', 'Demo Name')
        //        ->addAttachment($attachmentFile,$fileName); //Attachment goes here.
        ->addAttachment($attachmentFile, $fileName, 'application/pdf');

        try {
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            echo $e->getMessage(); die;
        }
    }
}