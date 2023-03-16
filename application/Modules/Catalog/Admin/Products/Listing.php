<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Catalog\Admin\Products;

use JetApplication\Product as Product;

use Jet\Data_Listing;
use Jet\DataModel_Fetch_Instances;

/**
 *
 */
class Listing extends Data_Listing {


	/**
	 * @var array
	 */
	protected array $grid_columns = [
		'_edit_'     => [
			'title'         => '',
			'disallow_sort' => true
		],
		'id'         => ['title' => 'ID'],
		'internal_name'   => ['title' => 'Product'],
	];

	/**
	 *
	 */
	protected function initFilters(): void
	{
		$this->filters['search'] = new Listing_Filter_Search($this);
	}

	/**
	 * @return Product[]|DataModel_Fetch_Instances
	 */
	protected function getList() : DataModel_Fetch_Instances
	{
		return Product::getList();
	}

}