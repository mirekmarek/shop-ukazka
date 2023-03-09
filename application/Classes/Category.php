<?php
/**
 * 
 */

namespace JetApplication;

use Jet\Data_Tree;
use Jet\DataModel;
use Jet\DataModel_Definition;
use Jet\DataModel_Fetch_Instances;
use Jet\DataModel_IDController_AutoIncrement;
use Jet\Form;
use Jet\Form_Field;
use Jet\Locale;
use Jet\Form_Definition;

/**
 *
 */
#[DataModel_Definition(
	name: 'category',
	database_table_name: 'category',
	id_controller_class: DataModel_IDController_AutoIncrement::class,
	id_controller_options: [
		'id_property_name' => 'id'
	]
)]
class Category extends DataModel
{

	/**
	 * @var int
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_ID_AUTOINCREMENT,
		is_id: true
	)]
	protected int $id = 0;

	/**
	 * @var ?Form
	 */ 
	protected ?Form $_form_edit = null;

	/**
	 * @var ?Form
	 */ 
	protected ?Form $_form_add = null;

	/**
	 * @var int
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_INT,
		is_key: true
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_SELECT,
		label: 'Nadřazená kategorie:',
		is_required: true,
		select_options_creator: [
			self::class,
			'getTree'
		],
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte',
			Form_Field::ERROR_CODE_INVALID_VALUE => 'Prosím zadejte'
		]
	)]
	protected int $parent_id = 0;

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Interní název:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte',
			Form_Field::ERROR_CODE_INVALID_FORMAT => 'Prosím zadejte'
		]
	)]
	protected string $internal_name = '';

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 65536
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_TEXTAREA,
		label: 'Interní poznámky:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $internal_notes = '';

	/**
	 * @var array
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_DATA_MODEL,
		data_model_class: Category_Localized::class
	)]
	#[Form_Definition(
		is_sub_forms: true
	)]
	protected array $localized = [];
	
	protected static ?Data_Tree $tree = null;
	
	protected static ?Data_Tree $menu_tree = null;
	
	
	public static function getTree() : Data_Tree
	{
		if(!static::$tree) {
			$data = static::dataFetchAll(
				select: [
					'id',
					'parent_id',
					'internal_name'
				],
				order_by: ['internal_name']
			);
			
			static::$tree = new Data_Tree();
			static::$tree->setLabelKey( 'internal_name' );
			
			static::$tree->getRootNode()->setId(0);
			static::$tree->getRootNode()->setLabel('Kategorie');
			
			static::$tree->setAdoptOrphans( true );
			
			static::$tree->setData( $data );
		}
		
		return static::$tree;
	}
	
	public static function getMenuTree() : Data_Tree
	{
		if(!static::$menu_tree) {
			$data = static::dataFetchAll(
				select: [
					'id',
					'parent_id',
					'category_localized.title'
				],
				where: [
					'category_localized.is_active' => true,
					'AND',
					'category_localized.locale' => Locale::getCurrentLocale()
				],
				order_by: ['category_localized.title']
			);
			
			static::$menu_tree = new Data_Tree();
			static::$menu_tree->setNodesClassName( Category_MenuItem::class );
			static::$menu_tree->setLabelKey( 'title' );
			
			static::$menu_tree->getRootNode()->setId(0);
			static::$menu_tree->getRootNode()->setLabel('');
			
			static::$menu_tree->setAdoptOrphans( true );
			
			static::$menu_tree->setData( $data );
		}
		
		return static::$menu_tree;
	}
	
	
	
	public function __construct()
	{
		$this->initLocales();
	}
	
	public function afterLoad(): void
	{
		$this->initLocales();
	}
	
	public function initLocales() : void
	{
		foreach( Application_Shop::getBase()->getLocales() as $locale_str=>$locale ) {
			if(!isset($this->localized[$locale_str])) {
				$localized = new Category_Localized();
				$localized->setLocale( $locale );
				
				$this->localized[$locale_str] = $localized;
			}
		}
	}

	/**
	 * @return Form
	 */
	public function getEditForm() : Form
	{
		if(!$this->_form_edit) {
			$this->_form_edit = $this->createForm('edit_form');
		}
		
		return $this->_form_edit;
	}

	/**
	 * @return bool
	 */
	public function catchEditForm() : bool
	{
		return $this->getEditForm()->catch();
	}

	/**
	 * @return Form
	 */
	public function getAddForm() : Form
	{
		if(!$this->_form_add) {
			$this->_form_add = $this->createForm('add_form');
		}
		
		return $this->_form_add;
	}

	/**
	 * @return bool
	 */
	public function catchAddForm() : bool
	{
		return $this->getAddForm()->catch();
	}

	/**
	 * @param int|string $id
	 * @return static|null
	 */
	public static function get( int|string $id ) : static|null
	{
		return static::load( $id );
	}

	/**
	 * @noinspection PhpDocSignatureInspection
	 * @return static[]|DataModel_Fetch_Instances
	 */
	public static function getList() : iterable
	{
		$where = [];
		
		return static::fetchInstances( $where );
	}

	/**
	 * @return int
	 */
	public function getId() : int
	{
		return $this->id;
	}

	/**
	 * @param int $value
	 */
	public function setParentId( int $value ) : void
	{
		$this->parent_id = $value;
	}

	/**
	 * @return int
	 */
	public function getParentId() : int
	{
		return $this->parent_id;
	}

	/**
	 * @param string $value
	 */
	public function setInternalName( string $value ) : void
	{
		$this->internal_name = $value;
	}

	/**
	 * @return string
	 */
	public function getInternalName() : string
	{
		return $this->internal_name;
	}

	/**
	 * @param string $value
	 */
	public function setInternalNotes( string $value ) : void
	{
		$this->internal_notes = $value;
	}

	/**
	 * @return string
	 */
	public function getInternalNotes() : string
	{
		return $this->internal_notes;
	}
	

	/**
	 */
	public function getLocalized( ?Locale $locale = null ) : Category_Localized
	{
		if( !$locale ) {
			$locale = Locale::getCurrentLocale();
		}
		
		return $this->localized[$locale->toString()];
	}
}
