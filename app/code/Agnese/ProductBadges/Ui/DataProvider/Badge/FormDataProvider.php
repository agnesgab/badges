<?php

namespace Agnese\ProductBadges\Ui\DataProvider\Badge;

use Agnese\ProductBadges\Model\ResourceModel\Badge\CollectionFactory as BadgeCollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class FormDataProvider extends AbstractDataProvider
{
    /**
     * @var BadgeCollectionFactory
     */
    private $badgeCollectionFactory;

    private $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        BadgeCollectionFactory $badgeCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->badgeCollectionFactory = $badgeCollectionFactory;
        $this->collection = $this->badgeCollectionFactory->create();
    }

    public function getData()
    {
        $badges = $this->collection->getItems();
        foreach($badges as $badge){
            $this->loadedData[$badge->getId()] = $badge->getData();
        }

        return $this->loadedData;
    }
}
