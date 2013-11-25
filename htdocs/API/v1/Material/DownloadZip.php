<?php
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/class/FlxZipArchive.php");

$the_folder = DOCUMENT_ROOT."Material";

//$zip_file_name = time().".zip"; // Zip name
$zip_file_name = "TeachingMaterial.zip"; // Zip name

$requestURLArray = explode("/",$_SERVER['REQUEST_URI']);
$requestLastURL = explode("?",end($requestURLArray));
$requestFileName = $requestLastURL[0];

if(extension_loaded('zip'))
{
	$zip = new FlxZipArchive;
	$res = $zip->open($zip_file_name, ZipArchive::CREATE);
	
	if($res === TRUE) {
		$zip->addDir($the_folder, basename($the_folder));
		$zip->close();
		
		if(file_exists($zip_file_name)){
			// push to download the zip
			header('Content-type: application/zip');
			
			header('Content-Disposition: attachment; filename="'.str_replace(".php",".zip", $requestFileName ).'"');
			header('Content-Length: ' . filesize($zip_file_name));
			readfile($zip_file_name);
			// remove zip file is exists in temp path
			unlink($zip_file_name);
		}
	}
	else
		echo 'Could not create a zip archive';
}