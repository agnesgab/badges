<?php

namespace Agnese\ProductBadges\Model\ResourceModel\Badge;

use \Agnese\ProductBadges\Model\Badge;
use Agnese\ProductBadges\Model\ResourceModel\Badge as BadgeResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            Badge::class, BadgeResource::class
        );
    }
}
