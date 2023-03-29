<?php

namespace JetApplication;

use Jet\BaseObject;

class ShoppingCart_Item extends BaseObject
{
	protected int $product_id = 0;
	
	protected Product|bool|null $_product = null;
	
	protected int $qty = 0;
	
	/**
	 * @return int
	 */
	public function getProductId(): int
	{
		return $this->product_id;
	}
	
	/**
	 * @param int $product_id
	 */
	public function setProductId( int $product_id ): void
	{
		$this->product_id = $product_id;
	}
	
	/**
	 * @return bool|Product
	 */
	public function getProduct(): Product|bool
	{
		if($this->_product===null) {
			$this->_product = Product::getActive($this->product_id);
			if(!$this->_product) {
				$this->_product = false;
			}
		}
		
		return $this->_product;
	}
	

	/**
	 * @return int
	 */
	public function getQty(): int
	{
		return $this->qty;
	}
	
	/**
	 * @param int $qty
	 */
	public function setQty( int $qty ): void
	{
		$this->qty = $qty;
	}
	
	
	
	
}