<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Order\DeliveryMethod\CZPost;

use Jet\Application_Module;
use JetApplication\Order_DeliveryMethod_Interface;
use JetApplication\Order_DeliveryMethod_Trait;

/**
 *
 */
class Main extends Application_Module implements Order_DeliveryMethod_Interface
{
	use Order_DeliveryMethod_Trait;
	
	
	public function isActive(): bool
	{
		return match ($this->order->getLocale()->toString()) {
			'cs_CZ' => true,
			'sk_SK' => false,
			default => false,
		};
	}
	
	public function getTitle(): string
	{
		return $this->_('Česká pošta');
	}
	
	public function getPrice(): float
	{
		return match ($this->order->getLocale()->toString()) {
			'cs_CZ' => 149,
			'sk_SK' => 9999,
			default => 9999,
		};
		
	}
	
	public function getPriority(): int
	{
		return 99;
	}
	
	public function isDefault(): bool
	{
		return false;
	}
}