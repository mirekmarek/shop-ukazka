<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Order\DeliveryMethod\PPL;

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
			'sk_sk' => false,
			default => false,
		};
	}
	
	public function getTitle(): string
	{
		return $this->_('PPL');
	}
	
	public function getPrice(): float
	{
		return match ($this->order->getLocale()->toString()) {
			'cs_CZ' => 199,
			'sk_sk' => 9999,
			default => 9999,
		};
		
	}
	
	
	public function getPriority(): int
	{
		return 999;
	}
	
	public function isDefault(): bool
	{
		return false;
	}
	
}