<?php
	require './vendor/autoload.php';
	
	use Aws\S3\S3Client;
	use Aws\Exception\AwsException;
	// AWS Info
	$bucketName = 'photos-example';
	$IAM_KEY = 'AKIAIRKOZA5L4R24FS4Q';
	$IAM_SECRET = 'Gww2JW+g00MIxoX3g8uNUVFXsdX5GfcdT751aMP7';
	// Connect to AWS
	try {
		// You may need to change the region. It will say in the URL when the bucket is open
		// and on creation.
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'us-east-2'
			)
		);
	} catch (Exception $e) {
		// We use a die, so if this fails. It stops here. Typically this is a REST call so this would
		// return a json object.
		die("Error: 1" . $e->getMessage());
	}

// 	try {
//     $result = $s3->putBucketCors([
//         'Bucket' => $bucketName, // REQUIRED
//         'CORSConfiguration' => [ // REQUIRED
//             'CORSRules' => [ // REQUIRED
//                 [
//                     'AllowedHeaders' => ['Authorization'],
//                     'AllowedMethods' => ['POST', 'GET', 'PUT'], // REQUIRED
//                     'AllowedOrigins' => ['*'], // REQUIRED
//                     'ExposeHeaders' => [],
//                     'MaxAgeSeconds' => 3000
//                 ],
//             ],
//         ]
//     ]);
//     var_dump($result);
// } catch (AwsException $e) {
//     // output error message if fails
//     error_log($e->getMessage());
// }
	
	$keyName = 'test_example/' . basename($_FILES["file"]['tmp_name']);
	$pathInS3 = 'https://s3.us-east-2.amazonaws.com/' . $bucketName . '/' . $keyName;
	// Add it to S3
	try {
		// Uploaded:
		$file = $_FILES["file"]['tmp_name'];
		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);
	} catch (S3Exception $e) {
		die('Error:2' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:3' . $e->getMessage());
	}
	echo 'Done';

 //  $db = mysqli_connect("sql3.freesqldatabase.com", "sql3204811", "VanxmAjTW6", "sql3204811");
 //  $msg = "";

 //  if (isset($_POST['upload'])) {

 //    $target = "images/".basename($_FILES['image']['name']);
 //    $image = $_FILES['image']['name'];
 //    // $result = mysqli_query($db, "SELECT id FROM users WHERE username=");
 //    $sql = "INSERT INTO images (image) VALUES ('$image')";
 //    mysqli_query($db, $sql);

 //    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
 //      $msg = "Image uploaded successfully";
 //      print_r($msg);
 //    }
 //    else
 //    {
 //      $msg = "Failed to upload image";
 //      print_r($msg);

 //    }
 //  }

 //  $result = mysqli_query($db, "SELECT * FROM images");
 // while ($row = mysqli_fetch_array($result)) {
 //    echo "<div id='img_div'>";
 //      echo "<img src='images/".$row['image']."' >";
 //      print_r($row['image']);
 //    echo "</div>";
 //  }

	 error_reporting(E_ALL);
        ini_set('display_errors', 1);
 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             
            $name     = $_FILES['file']['name'];
            $tmpName  = $_FILES['file']['tmp_name'];
            $error    = $_FILES['file']['error'];
            $size     = $_FILES['file']['size'];
            $ext      = strtolower(pathinfo($name, PATHINFO_EXTENSION));
           
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if ( !in_array($ext, array('jpg','jpeg','png','gif')) ) {
                        $valid = false;
                        $response = 'Invalid file extension.';
                    }
                    //validate file size
                    if ( $size/1024/1024 > 2 ) {
                        $valid = false;
                        $response = 'File size is exceeding maximum allowed size.';
                    }
                    //upload file
                    if ($valid) {
                        $targetPath =  dirname( __FILE__ ) . DIRECTORY_SEPARATOR. 'uploads' . DIRECTORY_SEPARATOR. $name;
                        move_uploaded_file($tmpName,$targetPath);
                        header( 'Location: welcome.php?sucssefull upload' ) ;
                        exit;
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response = 'File upload stopped by extension. Introduced in PHP 5.2.0.';
                    break;
                default:
                    $response = 'Unknown error';
                break;
            }
 
            echo $response;
        }

?>