<?php


namespace api\picture;


class Provider
{
    function getImage()
    {
        $pic = "doorvallend-tourmalijn-0.5-4.5-2xobj.jpg";
        if (file_exists($pic)) {
            $image_info = getimagesize($pic);

            //Set the content-type header as appropriate
            header('Content-Type: ' . $image_info['mime']);

            //Set the content-length header
            header('Content-Length: ' . filesize($pic));

            //Write the image bytes to the client
            readfile($pic);
        }
        else { // Image file not found

            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");

        }
    }
}