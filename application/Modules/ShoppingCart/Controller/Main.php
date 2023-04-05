<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\ShoppingCart;

use Jet\AJAX;
use Jet\Http_Headers;
use Jet\Http_Request;
use Jet\MVC_Controller_Default;
use JetApplication\ShoppingCart;

/**
 *
 */
class Controller_Main extends MVC_Controller_Default
{

	/**
	 *
	 */
	public function default_Action() : void
	{
		if( ($cart_add=Http_Request::GET()->getInt('cart_add')) ) {
			$new_item = ShoppingCart::get()->add( $cart_add );
			
			$this->view->setVar('new_item', $new_item);
			
			AJAX::commonResponse([
				'cart-icon' => $this->view->render('cart-icon'),
				'cart-new-item' => $this->view->render('cart-new-item')
			]);
		}
		
		$this->output('default');
	}

	public function detail_Action() : void
	{
		$this->output('detail');
	}
}