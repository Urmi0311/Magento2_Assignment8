<?php declare(strict_types=1);

namespace Urmi\Form\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Urmi_Form::faq';


    /**
     * @var PageFactory
     */

    protected $pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */

    public function __construct(
        Context     $context,
        PageFactory $pageFactory
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;

    }

    /**
     * @return Page
     */

    public function execute(): Page
    {
        $page = $this->pageFactory->create();
        $page->setActiveMenu('Urmi_Form::faq');
        $page->getConfig()->getTitle()->prepend(__('FAQs'));

        return $page;
    }

}






















