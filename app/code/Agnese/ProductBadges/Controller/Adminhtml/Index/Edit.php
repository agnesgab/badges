<?php

namespace Agnese\ProductBadges\Controller\Adminhtml\Index;

use Agnese\ProductBadges\Model\ResourceModel\Badge\CollectionFactory as BadgeCollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;
    /**
     * @var BadgeCollectionFactory
     */
    private $badgeCollectionFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BadgeCollectionFactory $badgeCollectionFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->badgeCollectionFactory = $badgeCollectionFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $id = $this->getRequest()->getParam('id');

        $badge = $this->badgeCollectionFactory->create()
            ->addFieldToFilter('id', $id)
            ->getFirstItem();

        if ($badge->getId()) {
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Badge: %1', $badge->getTitle()));
        } else {
            $this->messageManager->addErrorMessage(__('Badge does not exist.'));
            return $this->_redirect('badges_grid/index/index/');
        }

        return $resultPage;
    }

}
