<?php
// debughelper on in fireox
// error in server
// for next time
include_once "../../autoloader.php"; // somewhat clunky, acceptable for the time being

use api\picture\Provider as Provider;

$provider = new Provider;

$provider->getImage();



