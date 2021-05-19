<?php
namespace Globalgarner\EmailAttachments\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Email extends \Magento\Framework\App\Action\Action 
{

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Globalgarner\EmailAttachments\Helper\Data $helperData
    )
    {
        $this->_helperData =$helperData;
        parent::__construct($context);
    }

    public function execute()
    {

        $this->_helperData->generateTemplate();
        echo "dfdf"; exit;
    }
}