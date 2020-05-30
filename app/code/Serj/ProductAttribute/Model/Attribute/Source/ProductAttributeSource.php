<?php

namespace Serj\ProductAttribute\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class ProductAttributeSource extends AbstractSource
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->options=[
                ['label' => 'Yes', 'value' => 1],
                ['label' => 'No', 'value' => 0],
            ];
        }
        return $this->options;
    }
}
