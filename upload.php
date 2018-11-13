<?php

include('config.php');

/* Upload images */
if(!empty($_FILES) && !empty($_FILES['files']))
{
	$totalFiles = count($_FILES['files']['name']);
	if($totalFiles > 0)
	{
		$allFiles = array();

		/* Manage Image Directory */
		$folder_path = BASE_PATH.UPLOAD_FOLDER;
		if (!file_exists($folder_path)) {
	      mkdir($folder_path, 0777, true);
	    }else{
	      @chmod($folder_path, 0777);
	    }

	    /* Upload Images */
	    $isExtensionInvalid = 0;
		for ($i=0; $i < $totalFiles; $i++) 
		{ 
			$fileName  = $_FILES['files']['name'][$i];
			$fileTemp  = $_FILES['files']['tmp_name'][$i];    
			$fileSize  = $_FILES['files']['size'][$i];    
			$fileExtension = explode('.',$fileName);     
			$fileExtension = strtolower(end($fileExtension));    
			if(!in_array($fileExtension, array('png','jpeg','jpg','gif'))){
				$isExtensionInvalid = 1;
				continue;
			}
			$newFileName = "";    
			if($fileName){      
			    $newFileName = rand()."-360-view-".time().'.'.$fileExtension;      
			    $filePath = UPLOAD_FOLDER."/". $newFileName;     
			    if(move_uploaded_file($fileTemp,$filePath))
			    {        
			      chmod($filePath, 0777); 
			      $allFiles[] = $filePath;     
			    }
			}
		}
		echo json_encode(array('files' => $allFiles,'base_url' => BASE_URL,'isExtensionInvalid' => $isExtensionInvalid));exit;
	}
}

/* Remove Image */
if(isset($_POST['imgPath']) && !empty($_POST['imgPath']))
{
	if(file_exists($_POST['imgPath']))
	{
		@unlink($_POST['imgPath']);
	}
	echo json_encode(array('status' => 1));exit;
}

/* Remove All Image */
if(isset($_POST['resetImages']) && !empty($_POST['resetImages']))
{
	$files  = glob(UPLOAD_FOLDER . '/*');
	foreach($files as $file)
	{
	    if(is_file($file))
	    {
	        @unlink($file);
	    }
	}
	echo json_encode(array('status' => 1));exit;
}

?>