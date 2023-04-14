<?php
namespace JetApplication;

use Jet\Locale;
use Jet\Session;

class Order_Process {
	
	protected static ?Session $session = null;
	
	protected static ?Order $current_order=  null;
	
	protected static function getSession() : Session
	{
		if(!static::$session) {
			static::$session = new Session('order_process_'.Locale::getCurrentLocale());
		}
		
		return static::$session;
	}
	
	public static function getCurrentOrder() : Order
	{
		if(!static::$current_order) {
			$session = static::getSession();
			
			static::$current_order = $session->getValue('current_order');
			if(!static::$current_order) {
				static::$current_order = new Order();
				$session->setValue('current_order', static::$current_order);
			}
			
			static::$current_order->initOrderProcess();
		}
		
		return static::$current_order;
		
	}
	
	public static function getLastOrder() : ?Order
	{
		$session = static::getSession();
		
		$last_order_id = $session->getValue('last_order_id');
		
		if(
			!$last_order_id ||
			!($last_order = Order::get( $last_order_id ))
		) {
			return null;
		}
		
		return $last_order;
	}
	
	public static function setLastOrder( Order $order ) : void
	{
		$session = static::getSession();
		$session->setValue( 'last_order_id', $order->getId() );
		$session->unsetValue('current_order');
	}
}