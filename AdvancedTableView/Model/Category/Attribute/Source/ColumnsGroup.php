<?php
namespace Crimson\AdvancedTableView\Model\Category\Attribute\Source;

use Crimson\AdvancedTableView\Model\Config\Source\Table\Columns;

class ColumnsGroup extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    private ?array $options = null;

    public function __construct(
        private readonly Columns $columns,
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getAllOptions(): ?array
    {
        if (!$this->options) {
            $this->options = $this->columns->toOptionArray();
        }
        return $this->options;
    }
}
