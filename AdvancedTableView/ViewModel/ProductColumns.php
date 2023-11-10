<?php
declare(strict_types=1);

namespace Crimson\AdvancedTableView\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Crimson\AdvancedTableView\Model\Source\Config;

class ProductColumns implements ArgumentInterface
{
    public function __construct(
        private readonly Config $config
    ) {
        $this->initializeProperties();
    }

    private bool $image = true;
    private bool $name = true;
    private bool $sku = true;
    private bool $reviews = false;
    private bool $description = false;
    private bool $price = true;
    private bool $qty = true;
    private bool $actionsSecondary = true;
    private bool $actions = true;
    private bool $massSelect = true;

    private function initializeProperties(): void
    {
        $hiddenProperties = $this->config->getHiddenColumns();

        foreach ($hiddenProperties as $property) {
            $setterMethodName = 'set' . ucfirst($property) . 'Visible';

            if (method_exists($this, $setterMethodName)) {
                $this->{$setterMethodName}(false);
            }
        }
    }

    /**
     * @return bool
     */
    public function isImageVisible(): bool
    {
        return $this->image;
    }

    /**
     * @param bool $image
     */
    protected function setImageVisible(bool $image): void
    {
        $this->image = $image;
    }

    /**
     * @return bool
     */
    public function isNameVisible(): bool
    {
        return $this->name;
    }

    /**
     * @param bool $name
     */
    protected function setNameVisible(bool $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isSKUVisible(): bool
    {
        return $this->sku;
    }

    /**
     * @param bool $sku
     */
    protected function setSKUVisible(bool $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return bool
     */
    public function isReviewsVisible(): bool
    {
        return $this->reviews;
    }

    /**
     * @param bool $reviews
     */
    protected function setReviewsVisible(bool $reviews): void
    {
        $this->reviews = $reviews;
    }

    /**
     * @return bool
     */
    public function isDescriptionVisible(): bool
    {
        return $this->description;
    }

    /**
     * @param bool $description
     */
    protected function setDescriptionVisible(bool $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isPriceVisible(): bool
    {
        return $this->price;
    }

    /**
     * @param bool $price
     */
    protected function setPriceVisible(bool $price): void
    {
        $this->price = $price;
    }

    /**
     * @return bool
     */
    public function isQtyVisible(): bool
    {
        return $this->qty;
    }

    /**
     * @param bool $qty
     */
    protected function setQtyVisible(bool $qty): void
    {
        $this->qty = $qty;
    }

    /**
     * @return bool
     */
    public function isActionsSecondaryVisible(): bool
    {
        return $this->actionsSecondary;
    }

    /**
     * @param bool $actionsSecondary
     */
    protected function setActionsSecondaryVisible(bool $actionsSecondary): void
    {
        $this->actionsSecondary = $actionsSecondary;
    }

    /**
     * @return bool
     */
    public function isActionsVisible(): bool
    {
        return $this->actions;
    }

    /**
     * @param bool $actions
     */
    protected function setActionsVisible(bool $actions): void
    {
        $this->actions = $actions;
    }

    /**
     * @return bool
     */
    public function isMassSelectVisible(): bool
    {
        return $this->massSelect;
    }

    /**
     * @param bool $massSelect
     */
    protected function setMassSelectVisible(bool $massSelect): void
    {
        $this->massSelect = $massSelect;
    }
}
