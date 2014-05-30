<div class="panel panel-blue">
    <div class="panel-heading">
        <?php if($_SESSION['logged_in'] === true){
            $result = dibi::query("SELECT id, name, location, nice_image, basic_image, unlocked_time FROM achievements
                 LEFT JOIN (SELECT achievement_id, unlocked_time FROM log WHERE attendee_id = %i) d ON achievement_id = id
                 ORDER BY unlocked_time DESC, id", $me['attendee_id']);
            ?>
            <span class="glyphicon glyphicon-tags"></span> Moje Achievementy
        <?php } else {
            $result = dibi::query("SELECT id, basic_image, name, location FROM achievements ORDER BY id");
            ?>
            <span class="glyphicon glyphicon-tags"></span> Seznam Achievementů
        <?php } ?>
    </div>
    <div class="panel-body row">
        <?php

        if (count($result) == 0) {
            echo "<p>Zatím jste nezískal žádný achievement.</p>";
        } else {
            foreach ($result as $achievement) {
                if (is_null($achievement['unlocked_time'])) {
                    $image = $achievement['basic_image'];
                } else {
                    $image = $achievement['nice_image'];
                }
                echo "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center' style='height: 180px;'>
                        <a href='achievement-" . $achievement['id'] . "'><img style='width: 100px;' src='images/achievements/100/" . $image . "' ></a>
                            <div class='text-center'>
                                <strong>".$achievement['name']."</strong><br>
                                ".$achievement['location']."
                            </div>
                        </div>\n";
            }
        }
        ?>
    </div>
</div>