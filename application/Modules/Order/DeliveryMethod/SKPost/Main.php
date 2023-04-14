<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Order\DeliveryMethod\SKPost;

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
			'cs_CZ' => false,
			'sk_sk' => true,
			default => false,
		};
	}
	
	public function getTitle(): string
	{
		return $this->_('Slovenská pošta');
	}
	
	public function getPrice(): float
	{
		return match ($this->order->getLocale()->toString()) {
			'cs_CZ' => 9999,
			'sk_sk' => 4,
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