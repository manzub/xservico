<?php
require_once "../../../../core/init.php";

if (! empty($_FILES)) {

    if(isset($_FILES["file"]) && $_FILES["file"]['size']>0){

        if($_FILES["file"]['size']>5000000){
            $activity = "Update failed due to bad image.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        }else{
            $var = "assets/images/products/";
            $upload_dir = isset($_SESSION['is_dev_admin']) ? "/Applications/XAMPP/xamppfiles/htdocs/xservico/"+$var : $var;
//            define("UPLOAD_DIR", $upload_dir);
            define("UPLOAD_DIR", $var);
            $image = $_FILES["file"];

            // check image properties
            $prop = getImageSize($image['tmp_name']);
            if ($image["error"] !== UPLOAD_ERR_OK || (exif_imagetype($image['tmp_name']) != 2 && exif_imagetype($image['tmp_name']) != 3) || (!is_numeric($prop[0]) && !is_numeric($prop[1])) || $prop[0]==false) {
                $activity = "Update failed due to bad image properties.";
                createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
                exit;
            }

            // ensure a safe filename
            $name = preg_replace("/[^A-Z0-9._-]/i", "_", $image["name"]);

            // don't overwrite an existing file
            $i = 0;
            $parts = pathinfo($name);
            while (file_exists(UPLOAD_DIR . $name)) {
                $i++;
                $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
            }

            // recreate image
            if(imagecreatefromfile($image['tmp_name'], exif_imagetype($image['tmp_name']), $image['name'])==false){
                $activity = "Update failed due to failed image recreation.";
                createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
                exit; 
            }

            // rename file
            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = round(microtime(true)) . rand(100000000,999999999) . '.' . end($temp);

            // upload file
            $success = move_uploaded_file($_FILES["file"]["tmp_name"], "../../". UPLOAD_DIR . $newfilename);

            // delete temp file
            unlink($_FILES["file"]["name"]);

            if (!isset($success)) {
                $activity = "Update failed due to bad image.";
                createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
                exit;
            }else{
                // set proper permissions on the new file
                chmod(UPLOAD_DIR . $newfilename, 0644);
                $image = UPLOAD_DIR.$newfilename;

                // save file name to database
                $date = date("Y-m-d H:i:s");
                otherQuery("insert into prod_images (image, prod_id, date_posted) values ('$image','{$_POST['x']}','$date')");

                // update product image stat
                $query = selectQuery("select * from prods where id = '{$_POST['x']}'");
                $row=mysqli_fetch_assoc($query);
                $image_count =  $row['images']+1;
                otherQuery("update prods set images = '$image_count', date_modified='$date' where id = '{$_POST['x']}'");
            }
        }
    }
}
