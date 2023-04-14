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
			static::$session = new Session('order_'.Locale::getCurrentLocale());
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
			} else {
				static::$current_order->initOrderProcess();
			}
		}
		
		return static::$current_order;
		
	}
	
	public static function getLastOrder() : ?Order
	{
		$session = static::getSession();
		
		$last_order = $session->getValue('last_order');
		if(!$last_order instanceof Order) {
			return null;
		}
		
		return $last_order;
	}
	
	public static function setLastOrder( Order $order ) : void
	{
		$session = static::getSession();
		$session->setValue( 'last_order', $order );
	}
}