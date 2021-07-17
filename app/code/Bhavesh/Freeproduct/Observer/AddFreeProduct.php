<?php
namespace Bhavesh\Freeproduct\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class AddFreeProduct implements ObserverInterface
{
    protected $_product;
    protected $_cart;

    protected $formKey;

    public function __construct(
        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\Cart $cart
    ){
        $this->_product = $product;
        $this->formKey = $formKey;
        $this->_cart = $cart;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        /*$product = $observer->getEvent()->getData('product');*/

        //$total = $this->_cart->getQuote()->getGrandTotal();
        $items = $this->_cart->getQuote()->getAllVisibleItems();
        $isFreeItem = 0;
        $isXItem = 0;
        foreach($items as $item) {
            // X is product id
            //if($item->getProductId()=="164"){
                //$isXItem = 1;
            //}
            // Y is free product id
            if($item->getProductId()=="10"){
                $isFreeItem = 1;
            }
        }

        if(!$isFreeItem) {
            if ($this->_cart->getQuote()->getGrandTotal() >= 200) {
                $params = array(
                    'form_key' => $this->formKey->getFormKey(),
                    'product_id' => 10, //product Id
                    'qty'   => 1 //quantity of product                
                );
                $_product = $this->_product->create()->load(10);       
                $this->_cart->addProduct($_product, $params);
                $this->_cart->save();
            }
        }
        
    }
}