<?php

namespace JetApplication;

use Jet\Locale;

class Currency
{
	public static function getCurrencyCode( Locale $locale ) : string
	{
		return Application_Shop::getBase()->getLocalizedData($locale)->getParameter('currency');
	}
	
	
	public static function format( float $price, ?Locale $locale=null ) : string
	{
		if(!$locale) {
			$locale = Locale::getCurrentLocale();
		}
		
		return $locale->formatCurrency( $price, static::getCurrencyCode( $locale ) );
	}
}