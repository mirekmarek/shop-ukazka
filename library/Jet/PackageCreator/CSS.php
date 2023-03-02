<?php
/**
 *
 * @copyright Copyright (c) Miroslav Marek <mirek.marek@web-jet.cz>
 * @license http://www.php-jet.net/license/license.txt
 * @author Miroslav Marek <mirek.marek@web-jet.cz>
 */

namespace Jet;

/**
 *
 */
abstract class PackageCreator_CSS extends PackageCreator
{
	/**
	 * @param string $media
	 * @param array $URIs
	 */
	abstract public function __construct( string $media, array $URIs );
}