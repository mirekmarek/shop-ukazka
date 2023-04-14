<?php
namespace JetApplication\Order\Traits;

use Jet\Application_Modules;
use JetApplication\Order_DeliveryMethod_Interface;

trait Order_Traits_DeliveryMethods {
	const DELIVERY_MODULE_NAME_PREFIX = 'Order.DeliveryMethod.';
	
	/**
	 * @var Order_DeliveryMethod_Interface[]
	 */
	protected ?array $_all_delivery_methods = null;
	
	/**
	 * @var Order_DeliveryMethod_Interface[]
	 */
	protected ?array $_active_delivery_methods;
	
	protected function getDeliveryMethods() : void
	{
		
		if(!$this->_all_delivery_methods) {
			$this->_all_delivery_methods = [];
			$this->_active_delivery_methods = [];
			
			foreach( Application_Modules::activatedModulesList() as $module_manifest ) {
				
				if(str_starts_with($module_manifest->getName(), static::DELIVERY_MODULE_NAME_PREFIX)) {
					/**
					 * @var Order_DeliveryMethod_Interface $module
					 */
					$module = Application_Modules::moduleInstance( $module_manifest->getName() );
					$module->setOrder( $this );
					
					$this->_all_delivery_methods[$module->getCode()] = $module;
					
					if($module->isActive()) {
						$this->_active_delivery_methods[$module->getCode()] = $module;
					}
				}
			}
			
			$sorter = function( Order_DeliveryMethod_Interface $a, Order_DeliveryMethod_Interface $b ) : int
			{
				if($a->getPriority()<$b->getPriority()) {
					return -1;
				}
				if($a->getPriority()>$b->getPriority()) {
					return 1;
				}
				
				return 0;
			};
			
			uasort( $this->_all_delivery_methods, $sorter );
			uasort( $this->_active_delivery_methods, $sorter );
		}
	}
	
	/**
	 * @return Order_DeliveryMethod_Interface[]
	 */
	public function getAllDeliveryMethods() : array
	{
		$this->getDeliveryMethods();
		return $this->_all_delivery_methods;
	}
	
	/**
	 * @return Order_DeliveryMethod_Interface[]
	 */
	public function getActiveDeliveryMethods() : array
	{
		$this->getDeliveryMethods();
		return $this->_active_delivery_methods;
	}
	
	public function getActiveDeliveryMethodCodes() : array
	{
		$this->getDeliveryMethods();
		return array_keys($this->_active_delivery_methods);
	}
	
	
	public function getDeliveryMethod( string $code='' ) : ?Order_DeliveryMethod_Interface
	{
		$this->getDeliveryMethods();
		if(!$code) {
			$code = $this->getDeliveryMethodCode();
		}
		
		return $this->_all_delivery_methods[$code]??null;
	}
	
	public function getDefaultDeliveryMethod() : ?Order_DeliveryMethod_Interface
	{
		foreach($this->getActiveDeliveryMethods() as $method) {
			if($method->isDefault()) {
				return $method;
			}
		}
		
		return null;
	}
	
}