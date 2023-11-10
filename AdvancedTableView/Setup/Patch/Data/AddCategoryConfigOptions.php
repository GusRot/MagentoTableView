<?php
declare(strict_types=1);

namespace Crimson\AdvancedTableView\Setup\Patch\Data;

use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCategoryConfigOptions implements DataPatchInterface
{
    public const TABLE_VIEW_ATTRIBUTE = 'table_view_category_enabled';
    public const TABLE_VIEW_DEFAULT_ATTRIBUTE = 'table_view_category_default';
    public const TABLE_VIEW_GROUP_ATTRIBUTE = 'table_view_category_group';
    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;
    /**
     * @var CategorySetupFactory
     */
    protected $categorySetupFactory;
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var CategorySetup $categorySetup */
        $categoryTableSetup = $this->categorySetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);
        $categoryTableSetup->removeAttribute(
            \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_ATTRIBUTE );
        $categoryTableSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_ATTRIBUTE, [
                'type' => 'int',
                'label' => 'Use Table View Default Configs',
                'input' => 'boolean',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'source'   => Boolean::class,
                'default' => Boolean::VALUE_NO,
                'visible'  => true,
                'user_defined' => true,
                'sort_order' => 300,
                'required' => false,
                'group' => 'Custom Design',
            ]
        );

        /** @var CategorySetup $categorySetup */
        $categoryTableGroup = $this->categorySetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);
        $categoryTableGroup->removeAttribute(
            \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_DEFAULT_ATTRIBUTE );
        $categoryTableGroup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_DEFAULT_ATTRIBUTE, [
                'type' => 'int',
                'label' => 'Use Table View as Default View',
                'input' => 'boolean',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'source'   => Boolean::class,
                'default' => Boolean::VALUE_NO,
                'visible'  => true,
                'user_defined' => true,
                'sort_order' => 304,
                'required' => false,
                'group' => 'Custom Design',
            ]
        );

        // /** @var CategorySetup $categorySetup */
        // $categoryTableDefault = $this->categorySetupFactory->create([
        //     'setup' => $this->moduleDataSetup
        // ]);
        // $categoryTableDefault->removeAttribute(
        //     \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_DEFAULT_ATTRIBUTE );
        // $categoryTableDefault->addAttribute(
        //     \Magento\Catalog\Model\Category::ENTITY, self::TABLE_VIEW_DEFAULT_ATTRIBUTE, [
        //         'type' => 'text',
        //         'label' => 'Choose Customer Groups to display Advanced Table',
        //         'input' => 'multiselect',
        //         'visible'  => true,
        //         'user_defined' => true,
        //         'sort_order' => 304,
        //         'required' => false,
        //         'global' => ScopedAttributeInterface::SCOPE_STORE,
        //         'backend' => SortbyBackendModel::class,
        //         'source' => Sortby::class,
        //         'input_renderer' => Available::class,
        //         'group' => 'Custom Design',
        //     ]
        // );
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
