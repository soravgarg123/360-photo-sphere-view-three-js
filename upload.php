<?php

include('config.php');

/* Upload images */
if(!empty($_FILES) && !empty($_FILES['files']))
{
	$totalFiles = count($_FILES['files']['name']);
	if($totalFiles > 0)
	{
		$allFiles = array();
		for ($i=0; $i < $totalFiles; $i++) 
		{ 
			$f_name1 = $_FILES['files']['name'][$i];
			$f_tmp1  = $_FILES['files']['tmp_name'][$i];    
			$f_size1 = $_FILES['files']['size'][$i];    
			$f_extension1 = explode('.',$f_name1);     
			$f_extension1 = strtolower(end($f_extension1));    
			$f_newfile1="";    
			if($f_name1){      
			    $f_newfile1 = rand()."-360-view-".time().'.'.$f_extension1;      
			    $store1 = "uploads/". $f_newfile1;     
			    if(move_uploaded_file($f_tmp1,$store1))
			    {        
			      chmod($store1, 0777); 
			      $allFiles[] = $store1;     
			    }
			}
		}
		echo json_encode(array('files' => $allFiles,'base_url' => BASE_URL));exit;
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
	$folder = 'uploads';
	$files  = glob($folder . '/*');
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