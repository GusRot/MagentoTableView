<?php
declare(strict_types=1);

namespace Crimson\AdvancedTableView\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const CONFIG_PATH_ENABLED = "catalog/product_listing/enabled";
    const CONFIG_PATH_DEFAULT = "catalog/product_listing/default";
    const CONFIG_PATH_GROUPS = "catalog/product_listing/groups";
    const CONFIG_PATH_COLUMNS = "catalog/product_listing/columns";

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) { }

    public function isEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED, $scopeType, $scopeCode);
    }

    public function isDefault(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_DEFAULT, $scopeType, $scopeCode);
    }

    public function getCustomerGroups(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): mixed
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_GROUPS, $scopeType, $scopeCode);
    }

    public function getHiddenColumns(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        return (string) $this->scopeConfig->getValue(self::CONFIG_PATH_COLUMNS, $scopeType, $scopeCode);
    }
}
