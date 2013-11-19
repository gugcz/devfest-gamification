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
    'username' => 'gamedevfest',
    'password' => 'qNXLLjQ692mmLNrr',
    'database' => 'gamedevfest',
    'charset' => 'utf8',
));

//// Nacteni nastaveni z databaze
$result = dibi::query('SELECT * FROM settings');
$nastaveni = $result->fetchPairs('key', 'value');
$secretPassword = $nastaveni['secretPassword'];

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