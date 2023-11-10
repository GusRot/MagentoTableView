<?php
declare(strict_types = 1);

namespace Crimson\AdvancedTableView\Api;

/**
 * Backoffice settings data
 */
interface ConfigurationDataInterface
{
    /**
     * @var string IMAGE
     */
    const IMAGE = 'image';

    /**
     * @var string NAME
     */
    const NAME = 'name';

    /**
     * @var string SKU
     */
    const SKU = 'sku';
    
    /**
     * @var string PRICE
     */
    const PRICE = 'price';

    /**
     * @var string QTY
     */
    const QTY = 'qty';

    /**
     * @var string ACTIONS
     */
    const ACTIONS = 'actions';

    /**
     * @var string ACTIONS_SECONDARY
     */
    const ACTIONS_SECONDARY = 'actionsSecondary';

    /**
     * @var string MASS_SELECT
     */
    const MASS_SELECT = 'massSelect';
}
