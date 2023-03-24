<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Catalog\Browser;

use Jet\Http_Headers;
use Jet\Http_Request;
use Jet\MVC;
use Jet\MVC_Controller_Default;
use Jet\MVC_Controller_Router;
use Jet\MVC_Controller_Router_Interface;
use Jet\MVC_Layout;
use Jet\Navigation_Breadcrumb;
use JetApplication\Category;
use JetApplication\Product;
use JetApplication\Category_Localized;
use JetApplication\Category_MenuItem;

/**
 *
 */
class Controller_Main extends MVC_Controller_Default
{
	protected ?MVC_Controller_Router $router = null;
	
	protected static ?Category_Localized $category = null;
	protected static ?Product $product = null;
	
	public function getControllerRouter(): MVC_Controller_Router_Interface|null
	{
		if(!$this->router) {
			$this->router = new MVC_Controller_Router( $this );
			$main_router = MVC::getRouter();
			
			$this->router->addAction('category_detail')->setResolver( function() use ($main_router) : bool {
				$path = $main_router->getUrlPath();
				
				if(!$path) {
					return false;
				}
				
				if(!preg_match('/.*-c-([0-9]+)$/', $path, $m)) {
					return false;
				}
				
				$id = $m[1];
				
				$category = Category_Localized::getActive( $id );
				if(!$category) {
					return false;
				}
				
				static::$category = $category;
				
				if($category->getURLPath()!=$path) {
					$main_router->setIsRedirect(
						$category->getURL(),
						Http_Headers::CODE_301_MOVED_PERMANENTLY
					);
					
					return false;
				}
				
				$main_router->setUsedUrlPath( $path );
				
				
				return true;
			} );
			
			$this->router->addAction('product_detail')->setResolver( function() use ($main_router) : bool {
				$path = $main_router->getUrlPath();
				
				if(!$path) {
					return false;
				}
				
				if(!preg_match('/.*-p-([0-9]+)$/', $path, $m)) {
					return false;
				}
				
				$id = $m[1];
				
				$product = Product::getActive( $id );
				if(!$product) {
					return false;
				}
				
				static::$product = $product;
				
				if($product->getLocalized()->getURLPath()!=$path) {
					$main_router->setIsRedirect(
						$product->getLocalized()->getURL(),
						Http_Headers::CODE_301_MOVED_PERMANENTLY
					);
					
					return false;
				}
				
				$main_router->setUsedUrlPath( $path );
				
				$category_id = Http_Request::GET()->getInt('c');
				if($category_id) {
					static::$category = Category_Localized::getActive( $category_id );
				}
				
				return true;
			} );
			
		}
		
		return $this->router;
	}
	
	/**
	 * @return Category_Localized|null
	 */
	public function getCategory(): ?Category_Localized
	{
		return self::$category;
	}
	
	protected function initBn() : void
	{
		if(!static::$category) {
			return;
		}
		
		$tree = Category::getMenuTree();
		
		Navigation_Breadcrumb::reset();
		
		$current_node = $tree->getNode( $this->getCategory()->getCategoryId() );
		
		foreach($current_node->getPath() as $node) {
			/**
			 * @var Category_MenuItem $node
			 */
			Navigation_Breadcrumb::addURL( $node->getLabel(), $node->getURL() );
		}
		
	}
	
	public function product_detail_Action() : void
	{
		$this->view->setVar('product', static::$product);
		
		$this->initBn();
		
		$product_localized = static::$product->getLocalized();
		
		Navigation_Breadcrumb::addURL(
			$product_localized->getName(),
			$product_localized->getURL()
		);
		
		MVC_Layout::getCurrentLayout()->setVar( 'canonical', $product_localized->getURL() );
		
		$this->output( 'product/detail' );
	}
	
	
	public function category_detail_Action() : void
	{
		$this->view->setVar('category', static::$category);
		
		$this->initBn();

		$this->output( 'category/detail' );
	}
	
	public function main_menu_Action() : void
	{
		$this->output( 'menu' );
	}

	/**
	 *
	 */
	public function default_Action() : void
	{
		$this->output('default');
	}
}