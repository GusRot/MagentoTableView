<?php
declare(strict_types=1);

namespace Crimson\AdvancedTableView\Model\Source;

use Magento\Catalog\Block\Category\View;
use Magento\Catalog\Model\Category;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Crimson\AdvancedTableView\Model\Config as ScopeConfig;

class Config
{

    public function __construct(
        private readonly View                  $view,
        private readonly Session               $customerSession,
        private readonly StoreManagerInterface $storeManager,
        private readonly ScopeConfig           $scopeConfig,
    ) { }

    /**
     * @throws NoSuchEntityException
     */
    public function isVisible(): bool
    {
        $storeId = $this->getStore();
        $isEnabled = $this->scopeConfig->isEnabled(ScopeInterface::SCOPE_STORE, $storeId);

        if(!$isEnabled) {
            return false;
        }

        $groups = $this->getCustomerGroups();
        if(empty($groups)) {
            return true;
        }

        $customerGroupId = $this->customerSession->isLoggedIn() ? $this->customerSession->getCustomer()->getGroupId() : 0;
        if(!in_array($customerGroupId, explode(',', $groups))) {
            return false;
        }

        return true;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function isDefault(): bool
    {
        $storeId = $this->getStore();
        $currentCategory = $this->getCategory();

        if($currentCategory->getData('table_view_category_enabled')) {
            return (bool) $currentCategory->getData('table_view_category_default');
        }

        return $this->scopeConfig->isDefault(ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getCustomerGroups(): mixed
    {
        $storeId = $this->getStore();
        //TODO check category config

        return $this->scopeConfig->getCustomerGroups(ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
        * @throws NoSuchEntityException
        */
    public function getHiddenColumns(): array
    {
        $storeId = $this->getStore();
        //TODO check category config

        $groups = $this->scopeConfig->getHiddenColumns(ScopeInterface::SCOPE_STORE, $storeId);

        if(empty($groups)) {
            return [];
        }

        return explode(',', $groups);
    }

    /**
     * @throws NoSuchEntityException
     */
    protected function getStore(): string
    {
        return $this->storeManager->getStore()->getCode();
    }

    protected function getCategory(): Category
    {
        return $this->view->getCurrentCategory();
    }

}
