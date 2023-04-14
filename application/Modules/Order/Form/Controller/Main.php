<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Order\Form;

use Jet\AJAX;
use Jet\Http_Headers;
use Jet\Http_Request;
use Jet\MVC_Controller_Default;
use JetApplication\Application_Shop;
use JetApplication\Order_Process;
use JetApplication\ShoppingCart;

/**
 *
 */
class Controller_Main extends MVC_Controller_Default
{

	protected function check() : void
	{
		if(!ShoppingCart::get()->getQty()) {
			Http_Headers::movedTemporary( Application_Shop::getCartPage()->getURL() );
		}
	}
	
	/**
	 *
	 */
	public function delivery_and_payment_Action() : void
	{
		$this->check();
		
		$GET = Http_Request::GET();
		$order = Order_Process::getCurrentOrder();
		
		if( ($code=$GET->getString(
			key: 'select_payment_method',
			valid_values: $order->getActivePaymentMethodCodes()
		)) ) {
			$order->setPaymentMethodCode( $code );
			$order->initOrderProcess();
			
			AJAX::commonResponse([
				'delivery-end-payment' => $this->view->render('delivery_and_payment/select'),
				'order-status' =>  $this->view->render('status/info'),
			]);
		}
		
		if( ($code=$GET->getString(
			key: 'select_delivery_method',
			valid_values: $order->getActiveDeliveryMethodCodes()
		)) ) {
			$order->setDeliveryMethodCode( $code );
			$order->initOrderProcess();
			
			AJAX::commonResponse([
				'delivery-end-payment' => $this->view->render('delivery_and_payment/select'),
				'order-status' =>  $this->view->render('status/info'),
			]);
		}
		
		
		$this->output('delivery_and_payment');
	}
	
	/**
	 *
	 */
	public function contact_Action() : void
	{
		$this->check();
		
		$order = Order_Process::getCurrentOrder();
		
		if($order->catchContactForm()) {
			Http_Headers::movedTemporary( Application_Shop::getOrderRecapitulationPage()->getURL() );
		}
		
		$this->output('contact');
	}
	
	
	/**
	 *
	 */
	public function recapitulation_Action() : void
	{
		$this->check();
		
		$order = Order_Process::getCurrentOrder();
		
		if( !$order->isReady() ) {
			Http_Headers::movedTemporary( Application_Shop::getOrderContactPage()->getURL() );
		}
		
		if(Http_Request::GET()->exists('finish')) {
			$order->finish();
			
			Http_Headers::movedTemporary( Application_Shop::getOrderFinishPage()->getURL() );
		}
		
		
		$this->output('recapitulation');
	}
	
	/**
	 *
	 */
	public function finish_Action() : void
	{
		$last_order = Order_Process::getLastOrder();
		if(!$last_order) {
			Http_Headers::movedTemporary( Application_Shop::getCatalogPage()->getURL() );
		}
		
		$this->output('finish');
	}
	
	public function status_Action() : void
	{
		$this->output('status');
	}
	
}