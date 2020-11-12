<?php

// $err = "";
// if (!empty($_FILES)) {
// 	if (is_uploaded_file($_FILES['file']['tmp_name'])) {
// 		$fileType = $_FILES["file"]["type"]; 			// The type of file it is
// 		$fileSize = $_FILES["file"]["size"]; 			// File size in bytes
// 		$fileErrorMsg = $_FILES["file"]["error"]; 	// 0 for false... and 1 for true

// 		$fileName = basename($_FILES['file']['name']);		// The file name
// 		$fileTmpLoc = $_FILES["file"]["tmp_name"];				// File in the PHP tmp folder

// 		if (!$fileTmpLoc) { 															// if file not chosen
// 			$err = "ОШИБКА. Найдите файл, прежде чем нажимать кнопку загрузки.";
// 			exit();
// 		}

// 		$targetDir = "test/";
// 		$allowTypes = array('mp4', 'wmw', 'mpeg');
// 		$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
// 		$dateNow = date('Y-m-d H:i:s');
// 		$newName = strtotime($dateNow) . rand(0, 1000);
// 		if (in_array($fileType, $allowTypes)) {

// 			$targetFilePath = $targetDir . $newName . '.' . $fileType;
// 			// $targetFileSql = '/use/source/videos/' . $newName . '.' . $fileType;
// 			if (move_uploaded_file($fileTmpLoc, $targetFilePath)) {
// 				$err = "<div class='alert alert-success'>$fileName успешно загружен</div>";
// 			} else
// 				$err = "<div class='alert alert-danger'>Ошибка функции загрузки</div>";
// 		}
// 	}
// }
















$target_dir = "test/";
$target_file = $target_dir . basename($_FILES["file1"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["file1"]["tmp_name"]);
  if($check !== false) {
    echo "File is an - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

if ($_FILES["file1"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "mp4" ) {
  echo "Take, only JPG, JPEG, PNG & mp4 files are allowed.";
  $uploadOk = 0;
}

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["file1"]["name"]). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
	<div class="container mt-5 pt-5">
		<?= $err ?>
		<h2 class="text-center mt-5">Добавьте видео</h2>
		<form action="" method="POST" class="row" enctype="multipart/form-data">
			<div class="col-3"></div>
			<div class="col-6 border pt-3 pb-4">

				<div class="custom-file my-3">
					<input type="file" name="file" class="custom-file-input" accept="video/mp4,video/x-m4v,video/*">
					<label class="custom-file-label" for="file">Выберите файл</label>
				</div>
				<input type="submit" name="submit" value="Добавить" class="btn btn-primary btn-lg btn-block">
			</div>
			<div class="col-3"></div>
		</form>
	</div>

</body>

</html>