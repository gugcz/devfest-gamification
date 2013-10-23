<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jirka
 * Date: 14.10.13
 * Time: 22:01
 * To change this template use File | Settings | File Templates.
 */
require_once("../config.php");

$data = my_json_decode($HTTP_RAW_POST_DATA);

if ($data === NULL) { // Nepodarilo se precist json nebo je prazdny
    send_json_error("Invalid request");
} elseif ($data['password'] == $secretPassword) { // Json je v poradku, kontrola hesla
    send_json_success();
} else { // Spatne heslo
    send_json_error("Invalid password");
}