<?php
$target_dir = "uploads/";
$file_name = str_replace(' ', '_', $_FILES['fileToUpload']['name']);
$tmp_file_name = str_replace(' ', '_', $_FILES['fileToUpload']['tmp_name']);
$target_file = $target_dir . basename($file_name);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($tmp_file_name);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "txt") {
    echo "Sorry, only TXT files are allowed.<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($tmp_file_name, $target_file)) {
	    echo "The file ". basename($file_name). " has been uploaded.";

	    $file_noex = pathinfo("$target_dir/$file_name", PATHINFO_FILENAME);
	    $cmd = "mv " . "$target_dir$file_name" . " " . "$target_dir/$file_noex" .".py";
            shell_exec($cmd);
	    $output = shell_exec('ls -lart ' . $target_dir);
            echo "<pre>$output</pre>";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
