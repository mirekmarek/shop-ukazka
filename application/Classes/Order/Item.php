<?php
namespace JetApplication;

use Jet\DataModel;
use Jet\DataModel_Definition;
use Jet\DataModel_Related_1toN;
use Jet\DataModel_IDController_AutoIncrement;


#[DataModel_Definition(
	name: 'order_item',
	database_table_name: 'orders_items',
	id_controller_class: DataModel_IDController_AutoIncrement::class,
	id_controller_options: ['id_property_name'=>'id'],
	parent_model_class: Order::class
)]
class Order_Item extends DataModel_Related_1toN
{
	
	const ITEM_TYPE_PRODUCT = 'product';
	const ITEM_TYPE_PAYMENT = 'payment';
	const ITEM_TYPE_DELIVERY = 'delivery';
	
	
	#[DataModel_Definition(
		type: DataModel::TYPE_INT,
		is_id: true,
		related_to: 'main.id',
	)]
	protected int $order_id = 0;
	
	protected ?Order $__order = null;
	
	#[DataModel_Definition(
		type: DataModel::TYPE_ID_AUTOINCREMENT,
		is_id: true,
	)]
	protected int $id = 0;
	
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 100,
		is_key: true,
	)]
	protected string $type = '';
	
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 100,
		is_key: true,
	)]
	protected string $code = '';
	
	#[DataModel_Definition(
		type: DataModel::TYPE_INT,
		is_key: true,
	)]
	protected int $product_id = 0;
	
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	protected string $title = '';
	
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 65536
	)]
	protected string $description = '';
	
	#[DataModel_Definition(
		type: DataModel::TYPE_INT
	)]
	protected int $qty = 0;
	
	#[DataModel_Definition(
		type: DataModel::TYPE_FLOAT
	)]
	protected float $item_price = 0.0;
	
	#[DataModel_Definition(
		type: DataModel::TYPE_FLOAT
	)]
	protected float $vat_rate = 0.0;
	
	
	public function getArrayKeyValue(): string
	{
		return $this->id;
	}
	
	public function getOrder(): Order
	{
		return $this->__order;
	}
	
	public function setOrder( Order $_order ): void
	{
		$this->__order = $_order;
	}
	
	
	public function getType(): string
	{
		return $this->type;
	}
	
	public function setType( string $type ): void
	{
		$this->type = $type;
	}
	
	public function getCode(): string
	{
		return $this->code;
	}
	
	public function setCode( string $code ): void
	{
		$this->code = $code;
	}
	
	public function getProductId(): string
	{
		return $this->product_id;
	}
	
	public function setProductId( string $product_id ): void
	{
		$this->product_id = $product_id;
	}
	
	public function getTitle(): string
	{
		return $this->title;
	}
	
	public function setTitle( string $title ): void
	{
		$this->title = $title;
	}
	
	public function getDescription(): string
	{
		return $this->description;
	}
	
	public function setDescription( string $description ): void
	{
		$this->description = $description;
	}
	
	public function getQty(): int
	{
		return $this->qty;
	}
	
	public function setQty( int $qty ): void
	{
		$this->qty = $qty;
	}
	
	public function getItemPrice(): float
	{
		return $this->item_price;
	}
	
	public function setItemPrice( float $item_price ): void
	{
		$this->item_price = $item_price;
	}
	
	public function getTotalPrice(): float
	{
		return $this->item_price * $this->qty;
	}
	
	public function getVatRate(): float
	{
		return $this->vat_rate;
	}
	
	public function setVatRate( float $vat_rate ): void
	{
		$this->vat_rate = $vat_rate;
	}
	
	public static function createByCartItem( ShoppingCart_Item $cart_item ): static
	{
		$order_item = new static();
		
		$product = $cart_item->getProduct();
		$product_localized = $product->getLocalized();
		
		$order_item->type = static::ITEM_TYPE_PRODUCT;
		
		$order_item->product_id = $product->getId();
		$order_item->qty = $cart_item->getQty();
		$order_item->code = $product->getInternalCode();
		
		$order_item->title = $product_localized->getName();
		$order_item->item_price = $product_localized->getPrice();
		$order_item->vat_rate = $product_localized->getVatRate();
		
		return $order_item;
	}
	
	public static function createByDeliveryMethod( Order_DeliveryMethod_Interface $method ): static
	{
		$order_item = new static();
		
		$order_item->type = static::ITEM_TYPE_DELIVERY;
		
		$order_item->qty = 1;
		$order_item->code = $method->getCode();
		
		$order_item->title = $method->getTitle();
		$order_item->item_price = $method->getPrice();
		$order_item->vat_rate = $method->getVATRate();
		
		return $order_item;
	}
	
	public static function createByPaymentMethod( Order_PaymentMethod_Interface $method ): static
	{
		$order_item = new static();
		
		$order_item->type = static::ITEM_TYPE_PAYMENT;
		
		$order_item->qty = 1;
		$order_item->code = $method->getCode();
		
		$order_item->title = $method->getTitle();
		$order_item->item_price = $method->getPrice();
		$order_item->vat_rate = $method->getVATRate();
		
		return $order_item;
	}
}