<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Catalog\Admin\Categories;

use JetApplication\Category as Category;

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
	 * @var ?Category
	 */
	protected ?Category $category = null;

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
					return (bool)($this->category = Category::get($id));
				},
				[
					'listing'=> Main::ACTION_GET_CATEGORY,
					'view'   => Main::ACTION_GET_CATEGORY,
					'add'    => Main::ACTION_ADD_CATEGORY,
					'edit'   => Main::ACTION_UPDATE_CATEGORY,
					'delete' => Main::ACTION_DELETE_CATEGORY,
				]
			);
		}

		return $this->router;
	}
	
	/**
	 * @return Category|null
	 */
	public function getCategory(): ?Category
	{
		return $this->category;
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
		Navigation_Breadcrumb::addURL( Tr::_( 'Vytvořit novou kategorii' ) );

		$category = new Category();


		$form = $category->getAddForm();

		if( $category->catchAddForm() ) {
			$category->save();

			Logger::success(
				event: 'category_created',
				event_message: 'Category created',
				context_object_id: $category->getId(),
				context_object_name: $category->getInternalName(),
				context_object_data: $category
			);


			UI_messages::success(
				Tr::_( 'Category <b>%ITEM_NAME%</b> has been created', [ 'ITEM_NAME' => $category->getInternalName() ] )
			);

			Http_Headers::reload( ['id'=>$category->getId()], ['action'] );
		}

		$this->view->setVar( 'form', $form );
		$this->view->setVar( 'category', $category );

		$this->output( 'edit' );

	}

	/**
	 *
	 */
	public function edit_Action() : void
	{
		$category = $this->category;

		Navigation_Breadcrumb::addURL( Tr::_( 'Edit category <b>%ITEM_NAME%</b>', [ 'ITEM_NAME' => $category->getInternalName() ] ) );

		$form = $category->getEditForm();

		if( $category->catchEditForm() ) {

			$category->save();

			Logger::success(
				event: 'category_updated',
				event_message: 'Category updated',
				context_object_id: $category->getId(),
				context_object_name: $category->getInternalName(),
				context_object_data: $category
			);

			UI_messages::success(
				Tr::_( 'Category <b>%ITEM_NAME%</b> has been updated', [ 'ITEM_NAME' => $category->getInternalName() ] )
			);

			Http_Headers::reload();
		}

		$this->view->setVar( 'form', $form );
		$this->view->setVar( 'category', $category );

		$this->output( 'edit' );

	}

	/**
	 *
	 */
	public function view_Action() : void
	{
		$category = $this->category;

		Navigation_Breadcrumb::addURL(
			Tr::_( 'Category detail <b>%ITEM_NAME%</b>', [ 'ITEM_NAME' => $category->getInternalName() ] )
		);

		$form = $category->getEditForm();

		$form->setIsReadonly();

		$this->view->setVar( 'form', $form );
		$this->view->setVar( 'category', $category );

		$this->output( 'edit' );

	}

	/**
	 *
	 */
	public function delete_Action() : void
	{
		$category = $this->category;

		Navigation_Breadcrumb::addURL(
			Tr::_( 'Delete category  <b>%ITEM_NAME%</b>', [ 'ITEM_NAME' => $category->getInternalName() ] )
		);

		if( Http_Request::POST()->getString( 'delete' )=='yes' ) {
			$category->delete();

			Logger::success(
				event: 'category_deleted',
				event_message: 'Category deleted',
				context_object_id: $category->getId(),
				context_object_name: $category->getInternalName(),
				context_object_data: $category
			);

			UI_messages::info(
				Tr::_( 'Category <b>%ITEM_NAME%</b> has been deleted', [ 'ITEM_NAME' => $category->getInternalName() ] )
			);

			Http_Headers::reload([], ['action', 'id']);
		}


		$this->view->setVar( 'category', $category );

		$this->output( 'delete-confirm' );
	}

}