<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\ShoppingCart;

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
			ShoppingCart::get()->add( $cart_add );
			Http_Headers::reload( unset_GET_params: ['cart_add'] );
		}
		
		$this->output('default');
	}
}