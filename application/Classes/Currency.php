<?php

namespace JetApplication;

use Jet\Locale;

class Currency
{
	public static function getCurrencyCode( Locale $locale ) : string
	{
		return Application_Shop::getBase()->getLocalizedData($locale)->getParameter('currency');
	}
}