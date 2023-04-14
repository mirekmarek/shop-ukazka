<?php
namespace JetApplication\Order\Traits;

use Jet\Data_DateTime;
use Jet\Form;
use Jet\Form_Field_RadioButton;
use Jet\Http_Request;
use Jet\Locale;
use JetApplication\Order_Item;
use JetApplication\ShoppingCart;

trait Order_Traits_Process {
	
	protected ?Form $select_delivery_ant_payment_form = null;
	
	public function initOrderProcess() : void
	{
		if(!$this->getPaymentMethodCode()) {
			$this->setPaymentMethodCode(
				$this->getDefaultPaymentMethod()->getCode()
			);
		}
		
		if(!$this->getDeliveryMethodCode()) {
			$this->setDeliveryMethodCode(
				$this->getDefaultDeliveryMethod()->getCode()
			);
		}
		
		$this->setLocale( Locale::getCurrentLocale() );
		$this->setDatePurchased( Data_DateTime::now() );
		$this->setIpAddress( Http_Request::clientIP() );
		
		$this->items = [];
		
		foreach(ShoppingCart::get()->getItems() as $cart_item ) {
			$this->items[] = Order_Item::createByCartItem( $cart_item );
		}
		
		$this->items[] = Order_Item::createByDeliveryMethod(
			$this->getDeliveryMethod()
		);
		
		$this->items[] = Order_Item::createByPaymentMethod(
			$this->getPaymentMethod()
		);
		
	}
	
	/**
	 * @return Form|null
	 */
	public function getSelectDeliveryAntPaymentForm(): ?Form
	{
		if( !$this->select_delivery_ant_payment_form ) {
			
			$delivery_methods = [];
			foreach($this->getActiveDeliveryMethods() as $method) {
				$delivery_methods[$method->getCode()] = $method->getTitle();
			}
			$delivery_input = new Form_Field_RadioButton('delivery_method', '');
			$delivery_input->setSelectOptions( $delivery_methods );
			$delivery_input->setFieldValueCatcher(function() use ($delivery_input) {
				$this->setDeliveryMethodCode( $delivery_input->getValue() );
				$this->initOrderProcess();
			});
			
			
			$payment_methods = [];
			foreach($this->getActivePaymentMethods() as $method) {
				$payment_methods[$method->getCode()] = $method->getTitle();
			}
			$payment_input = new Form_Field_RadioButton('payment_method', '');
			$payment_input->setSelectOptions( $payment_methods );
			$payment_input->setFieldValueCatcher(function() use ($payment_input) {
				$this->setPaymentMethodCode( $payment_input->getValue() );
				$this->initOrderProcess();
			});
			
			$this->select_delivery_ant_payment_form = new Form('select_delivery_ant_payment', [
				$delivery_input,
				$payment_input
			]);
		}
		
		return $this->select_delivery_ant_payment_form;
	}
	
	
	
}