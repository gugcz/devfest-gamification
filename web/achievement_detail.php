<?php include("includes/header.php");
$result = dibi::query("SELECT id, name, location, nice_image, basic_image, congrats_text, unlocked_time, unlocked_count FROM achievements
                 LEFT JOIN (SELECT achievement_id, unlocked_time FROM log WHERE gplus_id = %s) d ON achievement_id = id
                 WHERE id = %i", $me['id'], $_GET['id']);

$result->setType('unlocked_time', dibi::FIELD_DATETIME)->setFormat(dibi::FIELD_DATETIME, 'H:i:s');

$achievement = $result->fetch();
if (is_null($achievement['unlocked_time'])) {
    $title = "Detail achievementu";
}else{
    $title = "Detail získaného achievementu";
}
?>
    <div class="container">
        <h1 class="text-center"><?php echo $title; ?></h1>

        <div class="row">
            <div class="col-md-8 col-md-offset-2 well">
                <div class="row achievement-detail">
                    <?php

                    if (is_null($achievement['unlocked_time'])) {
                        echo "<div class='col-xs-12 col-sm-5 col-md-5 col-lg-4 text-center'>
                    <img src='images/achievements/230/" . $achievement['basic_image'] . "'></div>

                <div class='col-xs-12 col-sm-7 col-md-7 col-lg-8'>
                    <h1>" . $achievement['name'] . "</h1>
                    <br>
                    <p>" . $achievement['location'] . "</p>
                    <p><strong>Tento achievement jste ještě nezískali.</strong></p>
                    <p><strong>Počet získání</strong>: <span class='badge'>" . $achievement['unlocked_count'] . "</span></p>
                </div>
                ";
                    } else {
                        echo "<div class='col-xs-12 col-sm-5 col-md-5 col-lg-4 text-center'>
                    <img src='images/achievements/230/" . $achievement['nice_image'] . "'></div>

                <div class='col-xs-12 col-sm-7 col-md-7 col-lg-8'>
                    <h1>" . $achievement['name'] . "</h1>
                    <br>
                    <p>" . $achievement['congrats_text'] . "</p>
                    <p><strong>Čas získání</strong>: <span class='badge'>" . $achievement['unlocked_time'] . "</span></p>
                    <p><strong>Počet získání</strong>: <span class='badge'>" . $achievement['unlocked_count'] . "</span></p>
                </div>
                ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php include("includes/footer.php"); ?>