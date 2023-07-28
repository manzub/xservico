<?php
require_once "../../../../core/init.php";

if (empty($_POST['link'])) exit;

if (!empty($_FILES)) {

    if (isset($_FILES["file"]) && $_FILES["file"]['size'] > 0) {

        if ($_FILES["file"]['size'] > 5000000) {
            $activity = "Upload failed due to bad image.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        } else {

            define("UPLOAD_DIR", "assets/images/exclusive-banner/");
            $image = $_FILES["file"];

            // check image properties
            $prop = getImageSize($image['tmp_name']);
            if ($image["error"] !== UPLOAD_ERR_OK || (exif_imagetype($image['tmp_name']) != 2 && exif_imagetype($image['tmp_name']) != 3) || (!is_numeric($prop[0]) && !is_numeric($prop[1])) || $prop[0] == false) {
                $activity = "Upload failed due to bad image properties.";
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
            if (imagecreatefromfile($image['tmp_name'], exif_imagetype($image['tmp_name']), $image['name']) == false) {
                $activity = "Upload failed due to failed image recreation.";
                createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
                exit;
            }

            // rename file
            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = round(microtime(true)) . rand(100000000, 999999999) . '.' . end($temp);

            // upload file
            $success = move_uploaded_file($_FILES["file"]["tmp_name"], "../../" . UPLOAD_DIR . $newfilename);

            // delete temp file
            unlink($_FILES["file"]["name"]);

            if (!isset($success)) {
                $activity = "Upload failed due to bad image.";
                createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
                exit;
            } else {
                // set proper permissions on the new file
                chmod(UPLOAD_DIR . $newfilename, 0644);
                $image = UPLOAD_DIR . $newfilename;

                // save file name to database
                $date = date("Y-m-d H:i:s");
                $link = $_POST['link'];
                otherQuery("insert into banners (image, link, date_posted) values ('$image','$link','$date')");
            }
        }
    }
}
