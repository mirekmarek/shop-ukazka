<?php
namespace JetApplication;

use Jet\Application_Modules;

trait Order_PaymentMethods {
	const PAYMENT_MODULE_NAME_PREFIX = 'Order.PaymentMethod.';
	
	/**
	 * @var Order_PaymentMethod_Interface[]
	 */
	protected ?array $all_delivery_methods;
	
	/**
	 * @var Order_PaymentMethod_Interface[]
	 */
	protected ?array $active_delivery_methods;
	
	protected function getPaymentMethods() : void
	{
		if($this->all_delivery_methods===null) {
			$this->all_delivery_methods = [];
			$this->active_delivery_methods = [];
			
			foreach( Application_Modules::activatedModulesList() as $module_manifest ) {
				if(str_starts_with($module_manifest->getName(), static::PAYMENT_MODULE_NAME_PREFIX)) {
					/**
					 * @var Order_PaymentMethod_Interface $module
					 */
					$module = Application_Modules::moduleInstance( $module_manifest->getName() );
					$module->setOrder( $this );
					
					$this->all_delivery_methods[$module->getCode()] = $module;
					
					if($module->isActive()) {
						$this->active_delivery_methods[$module->getCode()] = $module;
					}
				}
			}
		}
	}
	
	public function getAllPaymentMethods() : array
	{
		$this->getPaymentMethods();
		return $this->all_delivery_methods;
	}
	
	public function getActivePaymentMethods() : array
	{
		$this->getPaymentMethods();
		return $this->active_delivery_methods;
	}
	
	public function getPaymentMethod( string $code ) : Order_PaymentMethod_Interface
	{
		$this->getPaymentMethods();
		if(!$code) {
			$code = $this->getPaymentMethodCode();
		}
		
		return $this->all_delivery_methods[$code];
	}
	
}