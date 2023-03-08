<?php
/**
 *
 * @copyright Copyright (c) Miroslav Marek <mirek.marek@web-jet.cz>
 * @license http://www.php-jet.net/license/license.txt
 * @author Miroslav Marek <mirek.marek@web-jet.cz>
 */

namespace JetApplication;

use Jet\Locale;
use Jet\Logger;

use Jet\MVC;
use Jet\MVC_Base_Interface;
use Jet\MVC_Page_Interface;
use Jet\MVC_Router;

use Jet\Auth;
use Jet\SysConf_Jet_ErrorPages;
use Jet\SysConf_Jet_Form;
use Jet\SysConf_Jet_UI;

/**
 *
 */
class Application_Shop
{
	const PAGE_CATALOG_ID = MVC::HOMEPAGE_ID;
	
	/**
	 * @return string
	 */
	public static function getBaseId(): string
	{
		return 'shop';
	}

	/**
	 * @return MVC_Base_Interface
	 */
	public static function getBase(): MVC_Base_Interface
	{
		return MVC::getBase( static::getBaseId() );
	}
	
	public static function getCatalogPage( ?Locale $locale=null ) : MVC_Page_Interface
	{
		if(!$locale) {
			$locale = Locale::getCurrentLocale();
		}
		
		return MVC::getPage( static::PAGE_CATALOG_ID, $locale, static::getBaseId() );
	}


	/**
	 * @param MVC_Router $router
	 */
	public static function init( MVC_Router $router ): void
	{
		Logger::setLogger( new Logger_Web() );
		Auth::setController( new Auth_Controller_Web() );

		SysConf_Jet_UI::setViewsDir( $router->getBase()->getViewsPath() . 'ui/' );
		SysConf_Jet_Form::setDefaultViewsDir( $router->getBase()->getViewsPath() . 'form/' );
		SysConf_Jet_ErrorPages::setErrorPagesDir( $router->getBase()->getPagesDataPath( $router->getLocale() ) );
	}

}