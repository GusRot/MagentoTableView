<?php
declare(strict_types=1);

namespace Crimson\AdvancedTableView\ViewModel;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Crimson\AdvancedTableView\Model\Source\Config;
use Crimson\AdvancedTableView\Api\ConfigurationDataInterface;

class ProductColumns implements ArgumentInterface
{
    private array $columns = [];

    /**
     * @throws NoSuchEntityException
     */
    public function __construct(
        private readonly Config $config
    ) {
        $this->initializeProperties();
    }

    /**
     * @throws NoSuchEntityException
     */
    private function initializeProperties(): void
    {
        $hiddenProperties = $this->config->getHiddenColumns();

        $this->columns = $this->getColumns();
        foreach ($hiddenProperties as $property) {
            $this->columns[$property] = false;
        }
    }

    /**
     * @param string $column
     * @return bool
     */
    public function isColumnVisible(string $column): bool
    {
        return $this->columns[$column];
    }

    private function getColumns(): array
    {
        $columns = [];
        foreach ($this->config->getColumns() as $column) {
            $columns = array_merge($columns, [$column['value'] => true]);
        }
        return $columns;
    }
}
