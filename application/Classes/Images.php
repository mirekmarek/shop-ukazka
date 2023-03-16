<?php

namespace JetApplication;

use Jet\Form_Field_File_UploadedFile;
use Jet\IO_Dir;
use Jet\IO_File;
use Jet\SysConf_Path;
use Jet\SysConf_URI;

class Images
{
	public static function uploadImageAndReturnURI(
		string $entity,
		string $entity_id,
		string $image_type,
		Form_Field_File_UploadedFile $file
	) : string
	{
		$dir_name =
			$entity
			.'/'.$entity_id.'/';
		
		$file_name = $image_type.'.'.strtolower(pathinfo( $file->getFileName(), PATHINFO_EXTENSION ));
		
		$dir_path = SysConf_Path::getImages().$dir_name;
		
		if(!IO_Dir::exists($dir_path)) {
			IO_Dir::create( $dir_path );
		}
		
		IO_File::copy( $file->getTmpFilePath(), $dir_path.$file_name );
		
		return SysConf_URI::getImages().$dir_name.$file_name;
		
	}
}