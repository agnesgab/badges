<?php

namespace Agnese\ProductBadges\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Badge extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('badges', 'id');
    }
}
