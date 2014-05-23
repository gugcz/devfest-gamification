<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jirka
 * Date: 14.10.13
 * Time: 23:21
 * To change this template use File | Settings | File Templates.
 */

//error_reporting(E_ALL);
require_once("../config.php");

$result = dibi::query("SELECT attendee_id AS id, first_name, last_name FROM leaderboard");
$allAttendees = $result->fetchAll();
$items = array(
    "items" => $allAttendees);
send_json_success($items);
exit;