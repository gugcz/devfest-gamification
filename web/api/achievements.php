<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jirka
 * Date: 14.10.13
 * Time: 23:21
 * To change this template use File | Settings | File Templates.
 */

/** Database trigger
 * DELIMITER $$
 * CREATE TRIGGER trUpAchievementCount
 * AFTER INSERT
 * ON log
 * FOR EACH ROW
 * BEGIN
 * UPDATE leaderboard
 *  SET achievements_unlocked = (achievements_unlocked + 1),
 *      unlocked_first = IF (unlocked_first IS NULL, NOW(), unlocked_first),
 *      unlocked_last = NOW()
 *  WHERE gplus_id = NEW.gplus_id;
 * UPDATE achievements
 *  SET unlocked_count = (unlocked_count + 1)
 *  WHERE id = NEW.achievement_id;
 * END$$
 * DELIMITER ;
 */
//error_reporting(E_ALL);
require_once("../config.php");

if (isset($_GET['action']) && $_GET['action'] == "unlock") {
    if (!isset($HTTP_RAW_POST_DATA)) {
        send_json_error("Invalid request");
        exit;
    }
    //$data = json_decode($HTTP_RAW_POST_DATA, true, 512, JSON_BIGINT_AS_STRING); // az od PHP 5.4 :-(
    $data = my_json_decode($HTTP_RAW_POST_DATA);

    // Nepodarilo se precist json nebo je prazdny
    if ($data === NULL) {
        send_json_error("Invalid request");
        exit;
    }
    // Kontrola hesla
    if ($data['password'] != $secretPassword) {
        send_json_error("Invalid password");
        exit;
    }
    // Kontrola zda achievement existuje
    $result = dibi::query("SELECT COUNT(*) FROM achievements");
    $achievements_count = $result->fetchSingle();
    if ($data['achievement_id'] <= 0 || $data['achievement_id'] > $achievements_count) {
        send_json_error("Achievement does not exist");
        exit;
    }

    $gId = $data['gplus_id'];
    $result = dibi::query("SELECT user_name, user_image  FROM leaderboard WHERE gplus_id = %i", $gId);
    $rows = count($result);

    // Uzivatel se nenasel, pridame ho do databaze :-)
    if ($rows == 0) {
        //$user = file_get_contents("https://www.googleapis.com/plus/v1/people/" . $gId . "?fields=id,displayName,image&key=" . $API_KEY);
        //if (get_http_response_code($http_response_header) == 200){}

        try {
            $user = $plus->people->get($gId);
            $user_arr = array(
                "gplus_id" => $user['id'],
                "user_name" => $user['displayName'],
                "user_image" => substr($user['image']['url'], 0, -6),
                "gender" => $user['gender'],
                "location" => $user['placesLived'][0]['value'],
                "unlocked_last%t" => time(),
                "unlocked_first%t" => time(),
            );
            dibi::query('INSERT INTO leaderboard', $user_arr);
        } catch (Google_ServiceException $e) {
            if ($e->getCode() == 404) {
                send_json_error("User " . $gId . " does not exist");
                exit;
            } else {
                send_json_error("Unexpected error");
                exit;
            }
        }
    }
    //zapsat achievement
    try {
        $unlock_arr = array(
            "gplus_id" => $gId,
            "achievement_id" => $data['achievement_id'],
            "org_email" => $data['org_email'],
        );
        dibi::query('INSERT INTO log', $unlock_arr);

        $result = dibi::query("SELECT user_name, user_image, achievements_unlocked, leaderboard_position
                         FROM (
                             SELECT *, @curRank := @curRank + 1 AS leaderboard_position
                             FROM leaderboard l, (SELECT @curRank := 0) r
                             ORDER BY " . $nastaveni['orderSequence'] . ") result
                         WHERE gplus_id = %i
                         ", $gId);

        $response = $result->fetch();
        send_json_success($response);
        exit;
    } catch (DibiDriverException $e) {
        if ($e->getCode() == 1062) {
            send_json_error("This achievement was already unlocked");
            exit;
        } else {
            send_json_error("Unexpected error");
            exit;
        }
    }

} else { // Vypis vsech achievementu

    $result = dibi::query("SELECT * FROM achievements");
    $allAchievements = $result->fetchAll();
    $image_folder_url = "http://quest.devfest.cz/images/achievements/300/";
    foreach ($allAchievements as $achievement) {
        $achievement['basic_image'] = $image_folder_url . $achievement['basic_image'];
        $achievement['nice_image'] = $image_folder_url . $achievement['nice_image'];
    }
    $items = array(
        "items" => $allAchievements);
    send_json_success($items);
    exit;
}