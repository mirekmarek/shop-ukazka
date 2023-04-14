<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Order\DeliveryMethod\Geis;

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
			'sk_sk' => true,
			default => true,
		};
	}
	
	public function getTitle(): string
	{
		return $this->_('Geis');
	}
	
	public function getPrice(): float
	{
		return match ($this->order->getLocale()->toString()) {
			'cs_CZ' => 99,
			'sk_sk' => 4,
			default => 9999,
		};
		
	}
	
}