<?php
declare(strict_types = 1);

namespace Crimson\AdvancedTableView\Api;

/**
 * Backoffice settings data
 */
interface ConfigurationDataInterface
{
    /**
     * @var string IMAGE_VALUE
     */
    const IMAGE_VALUE = 'image';
    /**
     * @var string IMAGE_LABEL
     */
    const IMAGE_LABEL = 'Image';

    /**
     * @var string NAME_VALUE
     */
    const NAME_VALUE = 'name';
    /**
     * @var string NAME_LABEL
     */
    const NAME_LABEL = 'Name';

    /**
     * @var string DESCRIPTION_VALUE
     */
    const DESCRIPTION_VALUE = 'description';
    /**
     * @var string DESCRIPTION_LABEL
     */
    const DESCRIPTION_LABEL = 'Description';

    /**
     * @var string SKU_VALUE
     */
    const SKU_VALUE = 'sku';
    /**
     * @var string SKU_LABEL
     */
    const SKU_LABEL = 'SKU';

    /**
     * @var string REVIEWS_VALUE
     */
    const REVIEWS_VALUE = 'reviews';
    /**
     * @var string REVIEWS_LABEL
     */
    const REVIEWS_LABEL = 'Reviews';

    /**
     * @var string PRICE_VALUE
     */
    const PRICE_VALUE = 'price';
    /**
     * @var string PRICE_LABEL
     */
    const PRICE_LABEL = 'Price';

    /**
     * @var string QTY_VALUE
     */
    const QTY_VALUE = 'qty';
    /**
     * @var string QTY_LABEL
     */
    const QTY_LABEL = 'Quantity';

    /**
     * @var string ACTIONS_VALUE
     */
    const ACTIONS_VALUE = 'actions';
    /**
     * @var string ACTIONS_LABEL
     */
    const ACTIONS_LABEL = 'Actions';

    /**
     * @var string ACTIONS_SECONDARY_VALUE
     */
    const ACTIONS_SECONDARY_VALUE = 'actionsSecondary';
    /**
     * @var string ACTIONS_SECONDARY_LABEL
     */
    const ACTIONS_SECONDARY_LABEL = 'Secondary Actions';

    /**
     * @var string MASS_SELECT_VALUE
     */
    const MASS_SELECT_VALUE = 'massSelect';
    /**
     * @var string MASS_SELECT_LABEL
     */
    const MASS_SELECT_LABEL = 'Mass Select feature';
}
