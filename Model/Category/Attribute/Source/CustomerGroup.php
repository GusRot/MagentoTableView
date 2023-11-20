<?php
namespace Crimson\AdvancedTableView\Model\Category\Attribute\Source;

use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

class CustomerGroup extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    private ?array $options = null;

    public function __construct(
        private readonly CollectionFactory $groupCollectionFactory,
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getAllOptions(): ?array
    {
        if (!$this->options) {
            $this->options = $this->groupCollectionFactory->create()->loadData()->toOptionArray();
        }
        return $this->options;
    }
}
