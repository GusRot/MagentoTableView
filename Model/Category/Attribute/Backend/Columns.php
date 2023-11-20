<?php
namespace Crimson\AdvancedTableView\Model\Category\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\DataObject;

class Columns extends AbstractBackend
{
    public const TABLE_VIEW_COLUMNS_ATTRIBUTE = 'table_view_category_columns';

    public function __construct()
    {
    }

    /**
     * Before Attribute Save Process
     *
     * @param DataObject $object
     * @return $this
     */
    public function beforeSave($object)
    {
        $attributeCode = $this->getAttribute()->getName();
        if ($attributeCode == self::TABLE_VIEW_COLUMNS_ATTRIBUTE) {
            $data = $object->getData($attributeCode);
            if (!is_array($data)) {
                $data = [];
            }

            $object->setData($attributeCode, implode(',', $data) ?: null);
        }
        if (!$object->hasData($attributeCode)) {
            $object->setData($attributeCode, null);
        }
        return $this;
    }

    /**
     * After Load Attribute Process
     *
     * @param DataObject $object
     * @return $this
     */
    public function afterLoad($object)
    {
        $attributeCode = $this->getAttribute()->getName();
        if ($attributeCode == self::TABLE_VIEW_COLUMNS_ATTRIBUTE) {
            $data = $object->getData($attributeCode);

            if ($data) {
                if (!is_array($data)) {
                    $object->setData($attributeCode, explode(',', $data));
                } else {
                    $object->setData($attributeCode, $data);
                }

            }
        }
        return $this;
    }
}
