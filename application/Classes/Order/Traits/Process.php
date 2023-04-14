<?php
namespace JetApplication\Order\Traits;

use Jet\Data_DateTime;
use Jet\Form;
use Jet\Form_Field;
use Jet\Form_Field_RadioButton;
use Jet\Http_Request;
use Jet\Locale;
use JetApplication\Order_Item;
use JetApplication\Order_Process;
use JetApplication\ShoppingCart;

trait Order_Traits_Process {
	
	protected ?Form $_select_delivery_ant_payment_form = null;
	
	protected ?Form $_contact_form = null;
	
	public function initOrderProcess() : void
	{
		$this->setLocale( Locale::getCurrentLocale() );
		$this->setDatePurchased( Data_DateTime::now() );
		$this->setIpAddress( Http_Request::clientIP() );
		
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
		if( !$this->_select_delivery_ant_payment_form ) {
			
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
			$delivery_input->setErrorMessages([
				Form_Field::ERROR_CODE_INVALID_VALUE => 'Prosím vyberte metodu dopravy'
			]);
			
			
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
			$payment_input->setErrorMessages([
				Form_Field::ERROR_CODE_INVALID_VALUE => 'Prosím vyberte metodu platby'
			]);
			
			$this->_select_delivery_ant_payment_form = new Form('select_delivery_ant_payment', [
				$delivery_input,
				$payment_input
			]);
		}
		
		return $this->_select_delivery_ant_payment_form;
	}
	
	public function getContactForm() : Form
	{
		if(!$this->_contact_form) {
			$this->_contact_form = $this->createForm(
				'order_contact_form',
				only_fields: [
					'email',
					'phone',
					
					'billing_company_name',
					'billing_company_id',
					'billing_company_vat_id',
					
					'billing_first_name',
					'billing_surname',
					'billing_address_street_no',
					'billing_address_town',
					'billing_address_zip',
					
					'different_delivery_address',
					
					'delivery_company_name',
					'delivery_first_name',
					'delivery_surname',
					'delivery_address_street_no',
					'delivery_address_town',
					'delivery_address_zip',
				]
			);
			
			$this->_contact_form->setNovalidate(true);
		}
		
		return $this->_contact_form;
	}
	
	public function catchContactForm() : bool
	{
		$form = $this->getContactForm();
		if($form->catchInput()) {
			$diff_delivery_address = $form->field('different_delivery_address')->getValue();
			
			$delivery_address_fields = [
				'delivery_first_name',
				'delivery_surname',
				'delivery_address_street_no',
				'delivery_address_town',
				'delivery_address_zip',
			];
			

			foreach($delivery_address_fields as $field_name) {
				$form->field($field_name)->setIsRequired( $diff_delivery_address );
			}

			if($form->validate()) {
				$form->catchFieldValues();
				
				if(!$diff_delivery_address) {
					$this->delivery_company_name = $this->billing_company_name;
					$this->delivery_first_name = $this->billing_first_name;
					$this->delivery_surname = $this->billing_surname;
					
					$this->delivery_address_street_no = $this->billing_address_street_no;
					$this->delivery_address_town = $this->billing_address_town;
					$this->delivery_address_zip = $this->billing_address_zip;
				}
				
				return true;
			}
		}
		
		
		return false;
	}
	
	public function isReady() : bool
	{
		if(
			!$this->getDeliveryMethodCode() ||
			!$this->getPaymentMethodCode()
		) {
			return false;
		}
		
		$form = $this->getContactForm();
		if(!$form->validate()) {
			return false;
		}
		
		return true;
	}
	
	public function finish() : void
	{
		$this->setIsNew();
		$this->save();
		
		ShoppingCart::get()->reset();
		
		Order_Process::setLastOrder( $this );
	}
	
}