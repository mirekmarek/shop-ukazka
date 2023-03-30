<?php

namespace JetApplication;

use Jet\Application_Modules;
use Jet\BaseObject;
use Jet\Locale;
use Jet\Session;

class ShoppingCart extends BaseObject
{
	const CART_MODULE_NAME = 'ShoppingCart';
	
	/**
	 * @var ShoppingCart_Item[]
	 */
	protected array $items = [];
	
	protected static ?ShoppingCart $cart = null;
	
	public static function get() : static
	{
		if(!static::$cart) {
			$session = new Session('shopping_cart_'.Locale::getCurrentLocale());
			
			static::$cart = $session->getValue('cart');
			if(!static::$cart) {
				static::$cart = new static();
				$session->setValue('cart', static::$cart);
			} else {
				static::$cart->validate();
			}
		}
		
		return static::$cart;
	}
	
	public function validate() : void
	{
		foreach($this->items as $product_id=>$item) {
			if(!$item->getProduct()) {
				unset($this->items[ $product_id ]);
			}
		}
	}
	
	public function add( int $product_id, int $qty=1 ) : ShoppingCart_Item
	{
		if(isset($this->items[$product_id])) {
			$this->items[$product_id]->setQty( $this->items[$product_id]->getQty()+$qty );
		} else {
			$this->items[$product_id] = new ShoppingCart_Item();
			$this->items[$product_id]->setProductId( $product_id );
			$this->items[$product_id]->setQty( $qty );
		}
		
		
		return $this->items[$product_id];
	}
	
	public function delete( int $product_id ) : void
	{
		if(isset($this->items[$product_id])) {
			unset( $this->items[$product_id] );
		}
	}
	
	public function getQty() : int
	{
		$qty = 0;
		foreach($this->items as $item) {
			$qty += $item->getQty();
		}
		
		return $qty;
	}
	
	public function getValue() : float
	{
		$value = 0.0;
		foreach($this->items as $item) {
			$value += $item->getQty()*$item->getProduct()->getLocalized()->getPrice();
		}
		
		return $value;
	}
	
	public static function renderAddButton( Product $product ) : string
	{
		$module = Application_Modules::moduleInstance('ShoppingCart');
		
		return $module->renderAddButton( $product );
	}
	
}