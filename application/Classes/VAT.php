<?php
namespace JetApplication;

use Jet\Locale;

class VAT
{
	public static function getVATRates( Locale $locale ) : array
	{
		return explode(
			',',
			Application_Shop::getBase()->getLocalizedData( $locale )->getParameter('vat_rates', '')
		);
	}
}