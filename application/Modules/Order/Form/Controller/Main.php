<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Order\Form;

use Jet\MVC_Controller_Default;

/**
 *
 */
class Controller_Main extends MVC_Controller_Default
{

	/**
	 *
	 */
	public function delivery_and_payment_Action() : void
	{
		$this->output('delivery_and_payment');
	}
	
	/**
	 *
	 */
	public function contact_Action() : void
	{
		$this->output('contact');
	}
	
	
	/**
	 *
	 */
	public function recapitulation_Action() : void
	{
		$this->output('recapitulation');
	}
	
	/**
	 *
	 */
	public function finish_Action() : void
	{
		$this->output('finish');
	}
	
}