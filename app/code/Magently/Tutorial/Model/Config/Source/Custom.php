<?php

namespace Magently\Tutorial\Model\Config\Source;

class Custom implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            'value' => 'Badge',
            'another_value' => 'Another value',
        ];
    }
}
