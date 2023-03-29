<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\ShoppingCart;

use Jet\Application_Module;
use Jet\MVC_View;
use JetApplication\Product;

/**
 *
 */
class Main extends Application_Module
{
	public function renderAddButton( Product $product ) : string
	{
		$view = new MVC_View( $this->getViewsDir() );
		$view->setVar('product', $product);
		
		return $view->render( 'add_button' );
	}
}