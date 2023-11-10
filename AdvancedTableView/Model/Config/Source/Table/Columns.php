<?php

namespace Crimson\AdvancedTableView\Model\Config\Source\Table;

use Crimson\AdvancedTableView\Api\ConfigurationDataInterface as Config;

class Columns implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Image'),
                'value' => Config::IMAGE
            ],
            [
                'label' => __('Name'),
                'value' => Config::NAME
            ],
            [
                'label' => __('SKU'),
                'value' => Config::SKU
            ],
            [
                'label' => __('Price'),
                'value' => Config::PRICE
            ],
            [
                'label' => __('Qty'),
                'value' => Config::QTY
            ],
            [
                'label' => __('Actions'),
                'value' => Config::ACTIONS
            ],
            [
                'label' => __('Secondary Actions'),
                'value' => Config::ACTIONS_SECONDARY
            ],
            [
                'label' => __('Mass Select'),
                'value' => Config::MASS_SELECT
            ]
        ];
    }
}
