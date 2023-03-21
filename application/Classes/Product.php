<?php
/**
 * 
 */

namespace JetApplication;

use Jet\DataModel;
use Jet\DataModel_Definition;
use Jet\DataModel_Fetch_Instances;
use Jet\DataModel_IDController_AutoIncrement;
use Jet\Form;
use Jet\Form_Field_File_UploadedFile;
use Jet\Locale;
use Jet\Form_Field;
use Jet\Form_Definition;

/**
 *
 */
#[DataModel_Definition(
	name: 'product',
	database_table_name: 'product',
	id_controller_class: DataModel_IDController_AutoIncrement::class,
	id_controller_options: [
		'id_property_name' => 'id'
	]
)]
class Product extends DataModel
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
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte'
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
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Interní kód:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $internal_code = '';

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 30
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'EAN:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $EAN = '';

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Dodavatelský kód:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $supplier_code = '';

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_FILE_IMAGE,
		label: 'Hlavní obrázek:',
		is_required: false,
		maximal_width: 1600,
		maximal_height: 1200,
		allow_multiple_upload: false,
		error_messages: [
			Form_Field::ERROR_CODE_FILE_IS_TOO_LARGE => 'Obrázek je příliš velký',
			Form_Field::ERROR_CODE_DISALLOWED_FILE_TYPE => 'Nepodporovaný typ obrázku'
		]
	)]
	protected string $image_main = '';
	
	/**
	 * @var Product_Localized[]
	 */
	#[DataModel_Definition(
		type: DataModel::TYPE_DATA_MODEL,
		data_model_class: Product_Localized::class
	)]
	#[Form_Definition(
		is_sub_forms: true
	)]
	protected array $localized = [];

	/**
	 * @var array
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_DATA_MODEL,
		data_model_class: Product_Category::class
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_MULTI_SELECT,
		label: 'Kategorie:',
		is_required: false,
		select_options_creator: [
			'JetApplication\\Category',
			'getTree'
		],
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte',
			Form_Field::ERROR_CODE_INVALID_VALUE => 'Prosím zadejte'
		]
	)]
	protected array $categories = [];
	
	
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
				$localized = new Product_Localized();
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
	 * @param string $value
	 */
	public function setInternalCode( string $value ) : void
	{
		$this->internal_code = $value;
	}

	/**
	 * @return string
	 */
	public function getInternalCode() : string
	{
		return $this->internal_code;
	}

	/**
	 * @param string $value
	 */
	public function setEan( string $value ) : void
	{
		$this->EAN = $value;
	}

	/**
	 * @return string
	 */
	public function getEan() : string
	{
		return $this->EAN;
	}

	/**
	 * @param string $value
	 */
	public function setSupplierCode( string $value ) : void
	{
		$this->supplier_code = $value;
	}

	/**
	 * @return string
	 */
	public function getSupplierCode() : string
	{
		return $this->supplier_code;
	}
	
	/**
	 */
	public function getLocalized( ?Locale $locale = null ) : Product_Localized
	{
		if( !$locale ) {
			$locale = Locale::getCurrentLocale();
		}
		
		return $this->localized[$locale->toString()];
	}

	/**
	 * @param Form_Field_File_UploadedFile[] $images
	 */
	public function setImageMain( array $images ) : void
	{
		foreach( $images as $image ) {
			$this->image_main = Images::uploadImageAndReturnURI('product', $this->id, 'main', $image);
			break;
		}
	}

	/**
	 * @return string
	 */
	public function getImageMain() : string
	{
		return $this->image_main;
	}
	
	public function getImageMainThb( int $max_w, int $max_h ) : string
	{
		if(!$this->image_main) {
			return '';
		}
		
		return Images::createThumbnailAndReturnURI( $this->image_main, $max_w, $max_h );
	}

	/**
	 */
	public function setCategories( array $category_id ) : void
	{
		foreach( $category_id as $id ) {
			if(!isset($this->categories[$id])) {
				$this->categories[$id] = new Product_Category();
				$this->categories[$id]->setCategoryId( $id );
			}
		}
		
		foreach( array_keys($this->categories) as $id ) {
			if(!in_array($id, $category_id)) {
				$this->categories[$id]->delete();
			}
		}
		
	}

	/**
	 */
	public function getCategoryIDs() : array
	{
		return array_keys( $this->categories );
	}
	
	public static function getActive( int $id, ?Locale $locale=null ) : ?Product
	{
		if(!$locale) {
			$locale = Locale::getCurrentLocale();
		}
		
		$products = static::fetch([
			'product' => [
				'id' => $id
			],
			'product_localized' => [
				'locale' => $locale,
				'AND',
				'is_active' => true
			]
		]);
		
		if(!$products) {
			return null;
		}
		
		return $products[0];
	}
}
