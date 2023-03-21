<?php

namespace JetApplication;

use Jet\Data_Image;
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
		
		$file_name = $image_type.'_'.uniqid().'.'.strtolower(pathinfo( $file->getFileName(), PATHINFO_EXTENSION ));
		
		$dir_path = SysConf_Path::getImages().$dir_name;
		
		if(!IO_Dir::exists($dir_path)) {
			IO_Dir::create( $dir_path );
		}
		
		$old = IO_Dir::getFilesList( $dir_path, $image_type.'*' );
		foreach($old as $path=>$name) {
			IO_File::delete( $path );
		}
		
		IO_File::moveUploadedFile( $file->getTmpFilePath(), $dir_path.$file_name, true );
		
		return SysConf_URI::getImages().$dir_name.$file_name;
		
	}
	
	public static function createThumbnailAndReturnURI( string $URI, int $max_w, int $max_h ) : string
	{
		$path = substr( $URI,  strlen(SysConf_URI::getImages()));
		
		$dir_name = pathinfo( $path, PATHINFO_DIRNAME ).'/';
		$file_name = pathinfo( $path, PATHINFO_FILENAME );
		$file_ext = pathinfo( $path, PATHINFO_EXTENSION );
		
		$thb_file_name = $file_name.'_'.$max_w.'x'.$max_h.'.'.$file_ext;
		$thb_path = SysConf_Path::getImages().$dir_name.$thb_file_name;
		if(!IO_File::exists($thb_path)) {
			$img = new Data_Image( SysConf_Path::getImages().$path );
			$img->createThumbnail( $thb_path, $max_w, $max_h );
		}
		
		return SysConf_URI::getImages().$dir_name.$thb_file_name;
	}
}