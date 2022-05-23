<?php

namespace Agnese\ProductBadges\Controller\Adminhtml\Index;

use Agnese\ProductBadges\Model\BadgeFactory;
use Agnese\ProductBadges\Model\ImageUploader;
use Agnese\ProductBadges\Model\ResourceModel\Badge as BadgeResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\File\UploaderFactory;
use Agnese\ProductBadges\Model\ResourceModel\Badge\CollectionFactory as BadgeCollectionFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var BadgeFactory
     */
    private $badgeFactory;
    /**
     * @var BadgeResource
     */
    private $badgeResource;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;
    /**
     * @var ImageUploader
     */
    private $imageUploader;
    /**
     * @var BadgeCollectionFactory
     */
    private $badgeCollectionFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BadgeFactory $badgeFactory
     * @param BadgeResource $badgeResource
     * @param ManagerInterface $messageManager
     * @param Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param ImageUploader $imageUploader
     * @param BadgeCollectionFactory $badgeCollectionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BadgeFactory $badgeFactory,
        BadgeResource $badgeResource,
        ManagerInterface $messageManager,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        ImageUploader $imageUploader,
        BadgeCollectionFactory $badgeCollectionFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->badgeFactory = $badgeFactory;
        $this->badgeResource = $badgeResource;
        $this->messageManager = $messageManager;
        $this->filesystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->imageUploader = $imageUploader;
        $this->badgeCollectionFactory = $badgeCollectionFactory;
    }

    /**
     * @throws FileSystemException
     * @throws LocalizedException
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();

        if ($data['id'] !== '') {
            $badge = $this->badgeCollectionFactory->create()
                ->addFieldToFilter('id', $data['id'])
                ->getFirstItem();

            $badge->setTitle($data['title']);

            if (isset($data['image'][0]['url'])) {
                $badge->setImageUrl($data['image'][0]['url']);
            }
        } else {
            $badge = $this->badgeFactory->create();
            $badge->setTitle($data['title']);
            $badge->setImageUrl($data['image'][0]['url']);
        }

        try {
            $this->badgeResource->save($badge);
            $this->messageManager->addSuccessMessage(__('Badge successfully saved.'));
        } catch (AlreadyExistsException|\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error saving badge.'));
        }

        return $this->_redirect('badges_grid/index/index/');
    }

}
