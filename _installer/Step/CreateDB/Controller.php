<?php
/**
 *
 * @copyright Copyright (c) Miroslav Marek <mirek.marek@web-jet.cz>
 * @license http://www.php-jet.net/license/license.txt
 * @author Miroslav Marek <mirek.marek@web-jet.cz>
 */

namespace JetApplication\Installer;

use Exception;
use Jet\DataModel_Helper;

use JetApplication\Auth_Administrator_Role;
use JetApplication\Auth_Administrator_Role_Privilege;
use JetApplication\Auth_Administrator_User;
use JetApplication\Auth_Administrator_User_Roles;

use JetApplication\Auth_Visitor_Role;
use JetApplication\Auth_Visitor_Role_Privilege;
use JetApplication\Auth_Visitor_User;
use JetApplication\Auth_Visitor_User_Roles;


use JetApplication\Logger_Admin_Event;
use JetApplication\Logger_Web_Event;

use JetApplication\Category;
use JetApplication\Category_Localized;
use JetApplication\Product;
use JetApplication\Product_Category;
use JetApplication\Product_Localized;

use JetApplication\Order;
use JetApplication\Order_Item;

/**
 *
 */
class Installer_Step_CreateDB_Controller extends Installer_Step_Controller
{
	protected string $icon = 'square-plus';

	/**
	 * @var string
	 */
	protected string $label = 'Create database';

	/**
	 * @return bool
	 */
	public function getIsAvailable(): bool
	{
		return !Installer_Step_CreateBases_Controller::basesCreated();
	}


	/**
	 *
	 */
	public function main(): void
	{
		$this->catchContinue();


		$classes = [
			Auth_Administrator_Role::class,
			Auth_Administrator_Role_Privilege::class,
			Auth_Administrator_User::class,
			Auth_Administrator_User_Roles::class,

			Auth_Visitor_Role::class,
			Auth_Visitor_Role_Privilege::class,
			Auth_Visitor_User::class,
			Auth_Visitor_User_Roles::class,
			
			Logger_Admin_Event::class,
			Logger_Web_Event::class,

			Category::class,
			Category_Localized::class,

			Product::class,
			Product_Localized::class,
			Product_Category::class,
			
			Order::class,
			Order_Item::class
		];

		$result = [];
		$OK = true;

		foreach( $classes as $class ) {
			$result[$class] = true;
			try {
				DataModel_Helper::create( $class );
			} catch( Exception $e ) {
				$result[$class] = $e->getMessage();
				$OK = false;
			}

		}

		$this->view->setVar( 'result', $result );
		$this->view->setVar( 'OK', $OK );

		$this->render( 'default' );
	}

}
