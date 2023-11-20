<?php
declare(strict_types=1);

namespace Crimson\AdvancedTableView\Setup\Patch\Data;

use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Crimson\AdvancedTableView\Model\Category\Attribute\Backend\Group;
use Crimson\AdvancedTableView\Model\Category\Attribute\Backend\Columns;
use Crimson\AdvancedTableView\Model\Category\Attribute\Source\CustomerGroup;
use Crimson\AdvancedTableView\Model\Category\Attribute\Source\ColumnsGroup;
use Psr\Log\LoggerInterface;


class AddCategoryConfigOptions implements DataPatchInterface
{
    public const TABLE_VIEW_ATTRIBUTE = 'table_view_category_enabled';
    public const TABLE_VIEW_DEFAULT_ATTRIBUTE = 'table_view_category_default';

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly CategorySetupFactory $categorySetupFactory,
        private readonly LoggerInterface $logger
    ) {
    }
    /**
     * {@inheritdoc}
     */
    public function apply(): void
    {
        $categoryTableSetup = $this->categorySetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);
        $categoryTableSetup->removeAttribute(
            \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_ATTRIBUTE );
        try {
            $categoryTableSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_ATTRIBUTE, [
                    'type' => 'int',
                    'label' => 'Use Table View Default Configs',
                    'input' => 'boolean',
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'source' => Boolean::class,
                    'default' => Boolean::VALUE_NO,
                    'visible' => true,
                    'user_defined' => true,
                    'sort_order' => 300,
                    'required' => false,
                    'group' => 'Custom Design',
                ]
            );
        } catch (LocalizedException|\Zend_Validate_Exception $e) {
            $this->logger->error('Error applying' . self::TABLE_VIEW_ATTRIBUTE . 'data patch: ' . $e->getMessage());
        }

        $categoryTableDefault = $this->categorySetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);
        $categoryTableDefault->removeAttribute(
            \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_DEFAULT_ATTRIBUTE );
        try {
            $categoryTableDefault->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_DEFAULT_ATTRIBUTE, [
                    'type' => 'int',
                    'label' => 'Use Table View as Default View',
                    'input' => 'boolean',
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'source' => Boolean::class,
                    'default' => Boolean::VALUE_NO,
                    'visible' => true,
                    'user_defined' => true,
                    'sort_order' => 304,
                    'required' => false,
                    'group' => 'Custom Design',
                ]
            );
        } catch (LocalizedException|\Zend_Validate_Exception $e) {
            $this->logger->error('Error applying' . self::TABLE_VIEW_DEFAULT_ATTRIBUTE . 'data patch: ' . $e->getMessage());
        }

        $categoryTableGroup = $this->categorySetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);
        $categoryTableGroup->removeAttribute(
            \Magento\Catalog\Model\Category::ENTITY, Group::TABLE_VIEW_GROUP_ATTRIBUTE );
        try {
            $categoryTableGroup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, Group::TABLE_VIEW_GROUP_ATTRIBUTE, [
                    'type' => 'varchar',
                    'label' => 'Allow Customer Groups',
                    'input' => 'multiselect',
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'source' => CustomerGroup::class,
                    'backend' => Group::class,
                    'visible' => true,
                    'user_defined' => true,
                    'sort_order' => 307,
                    'required' => false,
                    'group' => 'Custom Design',
                ]
            );
        } catch (LocalizedException|\Zend_Validate_Exception $e) {
            $this->logger->error('Error applying' . Group::TABLE_VIEW_GROUP_ATTRIBUTE . 'data patch: ' . $e->getMessage());
        }

        $categoryTableColumn = $this->categorySetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);
        $categoryTableColumn->removeAttribute(
            \Magento\Catalog\Model\Category::ENTITY, Columns::TABLE_VIEW_COLUMNS_ATTRIBUTE );
        try {
            $categoryTableColumn->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, Columns::TABLE_VIEW_COLUMNS_ATTRIBUTE, [
                    'type' => 'varchar',
                    'label' => 'Hide Table Columns',
                    'input' => 'multiselect',
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'source' => ColumnsGroup::class,
                    'backend' => Columns::class,
                    'visible' => true,
                    'user_defined' => true,
                    'sort_order' => 309,
                    'required' => false,
                    'group' => 'Custom Design',
                ]
            );
        } catch (LocalizedException|\Zend_Validate_Exception $e) {
            $this->logger->error('Error applying' . Columns::TABLE_VIEW_COLUMNS_ATTRIBUTE . 'data patch: ' . $e->getMessage());
        }
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
