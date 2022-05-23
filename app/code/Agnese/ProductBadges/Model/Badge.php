<?php

namespace Agnese\ProductBadges\Model;

use Magento\Framework\Model\AbstractModel;

class Badge extends AbstractModel {

    protected function _construct()
    {
        $this->_init(\Agnese\ProductBadges\Model\ResourceModel\Badge::class);
    }
}

