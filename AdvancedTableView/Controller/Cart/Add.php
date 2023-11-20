<?php

namespace Crimson\AdvancedTableView\Controller\Cart;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Controller for processing Mass Add to Cart Action.
 *
 */
class Add extends \Magento\Checkout\Controller\Cart implements HttpPostActionInterface
{
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param CustomerCart $cart
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        CustomerCart $cart
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart
        );
    }

    /**
     * Add product to shopping cart action
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        
        try {
            $products = $this->getRequest()->getParam('products');
            foreach ($products as $product) {
                $params['qty'] = $product['qty'];
                $this->cart->addProduct($product['ids'], $params);
            }
            $this->cart->save();

            if ($this->shouldRedirectToCart()) {
                $message = __(
                    'You added %1 items to your shopping cart.',
                    count($products)
                );
                $this->messageManager->addSuccessMessage($message);
            } else {
                $this->messageManager->addComplexSuccessMessage(
                    'addCartSuccessMessage',
                    [
                        'product_name' => count($products) . ' items',
                        'cart_url' => $this->getCartUrl(),
                    ]
                );
            }
            if ($this->cart->getQuote()->getHasError()) {
                $errors = $this->cart->getQuote()->getErrors();
                foreach ($errors as $error) {
                    $this->messageManager->addErrorMessage($error->getText());
                }
            }

            return $this->goBack();
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('We can\'t add this item to your shopping cart right now.')
            );
            $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
            return $this->goBack();
        }

        return $this->getResponse();
    }

    /**
     * Resolve response
     *
     * @param string $backUrl
     * @return ResponseInterface|ResultInterface
     */
    protected function goBack($backUrl = null)
    {
        if (!$this->getRequest()->isAjax()) {
            return parent::_goBack($backUrl);
        }

        $result = [];

        if ($backUrl || $backUrl = $this->getBackUrl()) {
            $result['backUrl'] = $backUrl;
        }

        $this->getResponse()->representJson(
            $this->_objectManager->get(\Magento\Framework\Json\Helper\Data::class)->jsonEncode($result)
        );

        return $this->getResponse();
    }

    /**
     * Returns cart url
     *
     * @return string
     */
    private function getCartUrl()
    {
        return $this->_url->getUrl('checkout/cart', ['_secure' => true]);
    }

    /**
     * Is redirect should be performed after the product was added to cart.
     *
     * @return bool
     */
    private function shouldRedirectToCart()
    {
        return $this->_scopeConfig->isSetFlag(
            'checkout/cart/redirect_to_cart',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
