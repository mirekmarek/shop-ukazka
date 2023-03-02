<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */
namespace JetApplicationModule\Catalog\Admin\Categories;

use JetApplication\Category as Category;

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
		'internal_name'   => ['title' => 'Category'],
	];

	/**
	 *
	 */
	protected function initFilters(): void
	{
		$this->filters['search'] = new Listing_Filter_Search($this);
	}

	/**
	 * @return Category[]|DataModel_Fetch_Instances
	 */
	protected function getList() : DataModel_Fetch_Instances
	{
		return Category::getList();
	}

}