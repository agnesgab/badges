<?php

namespace Agnese\ProductBadges\Controller\Adminhtml\Index;

use Agnese\ProductBadges\Model\ResourceModel\Badge as BadgeResource;
use Agnese\ProductBadges\Model\BadgeFactory;
use Agnese\ProductBadges\Model\ResourceModel\Badge\CollectionFactory as BadgeCollection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    protected $resultPageFactory = false;
    /**
     * @var BadgeFactory
     */
    private $badgeFactory;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var BadgeResource
     */
    private $badgeResource;
    /**
     * @var BadgeCollection
     */
    private $badgeCollectionFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BadgeFactory $badgeFactory
     * @param BadgeResource $badgeResource
     * @param BadgeCollection $badgeCollection
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BadgeFactory $badgeFactory,
        BadgeResource $badgeResource,
        BadgeCollection $badgeCollection
    ) {
        parent::__construct($context);
        $this->context = $context;
        $this->resultPageFactory = $resultPageFactory;
        $this->badgeFactory = $badgeFactory;
        $this->badgeResource = $badgeResource;
        $this->badgeCollectionFactory = $badgeCollection;
    }

    public function execute()
    {
        $badgeIds = $this->getRequest()->getParam('selected');;

        if (isset($badgeIds)) {
            $badgesToDelete = $this->badgeCollectionFactory->create()
                ->addFieldToFilter('id', ['in' => $badgeIds]);

            foreach ($badgesToDelete as $badge) {
                $this->badgeResource->delete($badge);
            }
        }

        return $this->_redirect('badges_grid/index/index/');
    }
}
