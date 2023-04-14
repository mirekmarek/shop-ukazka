<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Order\PaymentMethod\OnlinePayment;

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
		return $this->_('Platba on-line');
	}
	
	public function getPrice(): float
	{
		return 0;
	}
	
}