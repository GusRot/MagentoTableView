<?php
declare(strict_types=1);

namespace Crimson\AdvancedTableView\Model\Config\Source\Table;

use Crimson\AdvancedTableView\Model\Source\Config;

class Columns implements \Magento\Framework\Option\ArrayInterface
{
    public function __construct(
        private readonly Config $config
    )
    {
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $columns = [];
        foreach ($this->config->getColumns() as $column) {
            $columns[] = [
                'label' => __($column['label']),
                'value' => ($column['value'])
            ];
        }

        return $columns;
    }
}
