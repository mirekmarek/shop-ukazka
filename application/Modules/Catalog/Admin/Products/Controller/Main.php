<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Catalog\Admin\Products;

use JetApplication\Product as Product;

use Jet\MVC_Controller_Router_AddEditDelete;
use Jet\MVC_Controller_Default;
use Jet\UI_messages;
use Jet\Http_Headers;
use Jet\Http_Request;
use Jet\Tr;
use Jet\Navigation_Breadcrumb;
use Jet\Logger;

/**
 *
 */
class Controller_Main extends MVC_Controller_Default
{

	/**
	 * @var ?MVC_Controller_Router_AddEditDelete
	 */
	protected ?MVC_Controller_Router_AddEditDelete $router = null;

	/**
	 * @var ?Product
	 */
	protected ?Product $product = null;

	/**
	 *
	 * @return MVC_Controller_Router_AddEditDelete
	 */
	public function getControllerRouter() : MVC_Controller_Router_AddEditDelete
	{
		if( !$this->router ) {
			$this->router = new MVC_Controller_Router_AddEditDelete(
				$this,
				function($id) {
					return (bool)($this->product = Product::get($id));
				},
				[
					'listing'=> Main::ACTION_GET_PRODUCT,
					'view'   => Main::ACTION_GET_PRODUCT,
					'add'    => Main::ACTION_ADD_PRODUCT,
					'edit'   => Main::ACTION_UPDATE_PRODUCT,
					'delete' => Main::ACTION_DELETE_PRODUCT,
				]
			);
		}

		return $this->router;
	}


	/**
	 *
	 */
	public function listing_Action() : void
	{
		$listing = new Listing();
		$listing->handle();

		$this->view->setVar( 'filter_form', $listing->getFilterForm());
		$this->view->setVar( 'grid', $listing->getGrid() );

		$this->output( 'list' );
	}

	/**
	 *
	 */
	public function add_Action() : void
	{
		Navigation_Breadcrumb::addURL( Tr::_( 'Create a new Product' ) );

		$product = new Product();


		$form = $product->getAddForm();

		if( $product->catchAddForm() ) {
			$product->save();

			Logger::success(
				event: 'product_created',
				event_message: 'Product created',
				context_object_id: $product->getId(),
				context_object_name: $product->getInternalName(),
				context_object_data: $product
			);


			UI_messages::success(
				Tr::_( 'Product <b>%ITEM_NAME%</b> has been created', [ 'ITEM_NAME' => $product->getInternalName() ] )
			);

			Http_Headers::reload( ['id'=>$product->getId()], ['action'] );
		}

		$this->view->setVar( 'form', $form );
		$this->view->setVar( 'product', $product );

		$this->output( 'edit' );

	}

	/**
	 *
	 */
	public function edit_Action() : void
	{
		$product = $this->product;

		Navigation_Breadcrumb::addURL( Tr::_( 'Edit product <b>%ITEM_NAME%</b>', [ 'ITEM_NAME' => $product->getInternalName() ] ) );

		$form = $product->getEditForm();

		if( $product->catchEditForm() ) {

			$product->save();

			Logger::success(
				event: 'product_updated',
				event_message: 'Product updated',
				context_object_id: $product->getId(),
				context_object_name: $product->getInternalName(),
				context_object_data: $product
			);

			UI_messages::success(
				Tr::_( 'Product <b>%ITEM_NAME%</b> has been updated', [ 'ITEM_NAME' => $product->getInternalName() ] )
			);

			Http_Headers::reload();
		}

		$this->view->setVar( 'form', $form );
		$this->view->setVar( 'product', $product );

		$this->output( 'edit' );

	}

	/**
	 *
	 */
	public function view_Action() : void
	{
		$product = $this->product;

		Navigation_Breadcrumb::addURL(
			Tr::_( 'Product detail <b>%ITEM_NAME%</b>', [ 'ITEM_NAME' => $product->getInternalName() ] )
		);

		$form = $product->getEditForm();

		$form->setIsReadonly();

		$this->view->setVar( 'form', $form );
		$this->view->setVar( 'product', $product );

		$this->output( 'edit' );

	}

	/**
	 *
	 */
	public function delete_Action() : void
	{
		$product = $this->product;

		Navigation_Breadcrumb::addURL(
			Tr::_( 'Delete product  <b>%ITEM_NAME%</b>', [ 'ITEM_NAME' => $product->getInternalName() ] )
		);

		if( Http_Request::POST()->getString( 'delete' )=='yes' ) {
			$product->delete();

			Logger::success(
				event: 'product_deleted',
				event_message: 'Product deleted',
				context_object_id: $product->getId(),
				context_object_name: $product->getInternalName(),
				context_object_data: $product
			);

			UI_messages::info(
				Tr::_( 'Product <b>%ITEM_NAME%</b> has been deleted', [ 'ITEM_NAME' => $product->getInternalName() ] )
			);

			Http_Headers::reload([], ['action', 'id']);
		}


		$this->view->setVar( 'product', $product );

		$this->output( 'delete-confirm' );
	}

}