<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jirka
 * Date: 14.10.13
 * Time: 23:44
 * To change this template use File | Settings | File Templates.
 */
session_start();
require_once("libs/dibi.min.php");

dibi::connect(array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => 'mdevgame_inmite',
    'password' => 'CdsWsaqw.12X',
    'database' => 'mdevgame_inmite',
    'charset' => 'utf8',
));

//// Nacteni nastaveni z databaze
$result = dibi::query('SELECT * FROM settings');
$nastaveni = $result->fetchPairs('key', 'value');
$secretPassword = $nastaveni['secretPassword'];

/*
//// Nastaveni Google API
require_once 'libs/GoogleAPI/Google_Client.php';
require_once 'libs/GoogleAPI/contrib/Google_PlusService.php';
require_once 'libs/GoogleAPI/contrib/Google_Oauth2Service.php';


$client = new Google_Client();
$client->setApplicationName($nastaveni['App_name']);
// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
$client->setClientId($nastaveni['API_ClientId']);
$client->setClientSecret($nastaveni['API_ClientSecret']);
$client->setRedirectUri($nastaveni['API_RedirectUri']);
$client->setDeveloperKey($nastaveni['API_KEY']);
$client->setScopes(array('https://www.googleapis.com/auth/plus.me')); // set scope during user login
$plus = new Google_PlusService($client);
*/

//// Funkce
function my_json_decode($string)
{
    return json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $string), true);
}

function send_json_success($json_arr = "")
{
    $out = json_encode($json_arr);
    header('HTTP/1.0 200 OK', true, 200);
    header('Content-type: application/json');
    if (is_array($json_arr) || $json_arr instanceof Traversable) {
        echo $out;
    }
}

function send_json_error($message)
{
    $err = array("error" => $message);
    $out = json_encode($err);
    header('HTTP/1.0 400 BAD REQUEST', true, 400);
    header('Content-type: application/json');
    echo $out;
}

//function a($cislo, $s1 = "bod", $s2 = "body", $s3 = "bodů")
//function a($cislo, $s1 = "achievement", $s2 = "achievementy", $s3 = "achievementů")
function a($cislo, $s1 = "x", $s2 = "x", $s3 = "x")
{
    switch ($cislo) {
        case 1:
            $s = $s1;
            break;
        case 2:
        case 3:
        case 4:
            $s = $s2;
            break;
        default:
            $s = $s3;
    }
    return $cislo . " " . $s;
}