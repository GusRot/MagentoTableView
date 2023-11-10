<?php
namespace Crimson\AdvancedTableView\Plugin\Helper\Product;

use Magento\Catalog\Helper\Product\ProductList;
use Crimson\AdvancedTableView\Model\Source\Config;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductListPlugin
{
    public function __construct(
        private readonly Config $config
    ) {
    }

    /**
     * @throws NoSuchEntityException
     */
    public function afterGetAvailableViewMode(
    ProductList $subject,
    null|array $result
    ): ?array
    {
        if(!$this->config->isVisible()) {
            return $result;
        }

        if(empty($result)) {
            return array('table'=> __('Table'));
        }

        if($this->config->isDefault()) {
            return array_merge(array('table'=> __('Table')), $result);
        }

        return array_merge($result, array('table'=> __('Table')));
    }
}
