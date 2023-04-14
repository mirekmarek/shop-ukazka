<?php
namespace JetApplication;

use Jet\Application_Modules;

trait Order_DeliveryMethods {
	const DELIVERY_MODULE_NAME_PREFIX = 'Order.DeliveryMethod.';
	
	/**
	 * @var Order_DeliveryMethod_Interface[]
	 */
	protected ?array $all_delivery_methods;
	
	/**
	 * @var Order_DeliveryMethod_Interface[]
	 */
	protected ?array $active_delivery_methods;
	
	protected function getDeliveryMethods() : void
	{
		if($this->all_delivery_methods===null) {
			$this->all_delivery_methods = [];
			$this->active_delivery_methods = [];
			
			foreach( Application_Modules::activatedModulesList() as $module_manifest ) {
				if(str_starts_with($module_manifest->getName(), static::DELIVERY_MODULE_NAME_PREFIX)) {
					/**
					 * @var Order_DeliveryMethod_Interface $module
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
	
	public function getAllDeliveryMethods() : array
	{
		$this->getDeliveryMethods();
		return $this->all_delivery_methods;
	}
	
	public function getActiveDeliveryMethods() : array
	{
		$this->getDeliveryMethods();
		return $this->active_delivery_methods;
	}
	
	public function getDeliveryMethod( string $code='' ) : Order_DeliveryMethod_Interface
	{
		$this->getDeliveryMethods();
		if(!$code) {
			$code = $this->getDeliveryMethodCode();
		}
		
		return $this->all_delivery_methods[$code];
	}
	
}