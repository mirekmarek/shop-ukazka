<?php
namespace JetApplication\Order\Traits;

use Jet\Application_Modules;
use JetApplication\Order_PaymentMethod_Interface;

trait Order_Traits_PaymentMethods {
	const PAYMENT_MODULE_NAME_PREFIX = 'Order.PaymentMethod.';
	
	/**
	 * @var Order_PaymentMethod_Interface[]
	 */
	protected ?array $all_payment_methods;
	
	/**
	 * @var Order_PaymentMethod_Interface[]
	 */
	protected ?array $active_payment_methods;
	
	protected function getPaymentMethods() : void
	{
		if($this->all_payment_methods===null) {
			$this->all_payment_methods = [];
			$this->active_payment_methods = [];
			
			foreach( Application_Modules::activatedModulesList() as $module_manifest ) {
				if(str_starts_with($module_manifest->getName(), static::PAYMENT_MODULE_NAME_PREFIX)) {
					/**
					 * @var Order_PaymentMethod_Interface $module
					 */
					$module = Application_Modules::moduleInstance( $module_manifest->getName() );
					$module->setOrder( $this );
					
					$this->all_payment_methods[$module->getCode()] = $module;
					
					if($module->isActive()) {
						$this->active_payment_methods[$module->getCode()] = $module;
					}
				}
			}
			
			$sorter = function( Order_PaymentMethod_Interface $a, Order_PaymentMethod_Interface $b ) : int
			{
				if($a->getPriority()<$b->getPriority()) {
					return -1;
				}
				if($a->getPriority()>$b->getPriority()) {
					return 1;
				}
				
				return 0;
			};
			
			uasort( $this->all_payment_methods, $sorter );
			uasort( $this->active_payment_methods, $sorter );}
	}
	
	/**
	 * @return Order_PaymentMethod_Interface[]
	 */
	public function getAllPaymentMethods() : array
	{
		$this->getPaymentMethods();
		return $this->all_payment_methods;
	}
	
	/**
	 * @return Order_PaymentMethod_Interface[]
	 */
	public function getActivePaymentMethods() : array
	{
		$this->getPaymentMethods();
		return $this->active_payment_methods;
	}
	
	public function getPaymentMethod( string $code='' ) : Order_PaymentMethod_Interface
	{
		$this->getPaymentMethods();
		if(!$code) {
			$code = $this->getPaymentMethodCode();
		}
		
		return $this->all_payment_methods[$code];
	}
	
	public function getDefaultPaymentMethod() : ?Order_PaymentMethod_Interface
	{
		foreach($this->getActivePaymentMethods() as $method) {
			if($method->isDefault()) {
				return $method;
			}
		}
		
		return null;
	}
	
}