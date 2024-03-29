<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Order\PaymentMethod\COD;

use Jet\Application_Module;
use JetApplication\Order_PaymentMethod_Interface;
use JetApplication\Order_PaymentMethod_Trait;

/**
 *
 */
class Main extends Application_Module implements Order_PaymentMethod_Interface
{
	use Order_PaymentMethod_Trait;
	
	
	public function isActive(): bool
	{
		return true;
	}
	
	public function getTitle(): string
	{
		return $this->_('Dobírka');
	}
	
	public function getPrice(): float
	{
		return match ($this->order->getLocale()->toString()) {
			'cs_CZ' => 30,
			'sk_SK' => 1.5,
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