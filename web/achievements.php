<?php include("includes/header.php"); ?>
    <div class="container">
        <h1 class="text-center">Přehled achievementů</h1>

        <div class="row">
            <?php if (!isset($authUrl)) { // Uživatel přihlášen
                $result = dibi::query("SELECT id, name, location, nice_image, basic_image, congrats_text, unlocked_time FROM achievements
                 LEFT JOIN (SELECT achievement_id, unlocked_time FROM log WHERE gplus_id = %s) d ON achievement_id = id
                 ORDER BY unlocked_time DESC", $me['id']);

                foreach ($result as $achievement) {
                    if (is_null($achievement['unlocked_time'])) {
                        $image = $achievement['basic_image'];
                        $unlocked_class = "danger";
                        $unlocked = "Nesplněno";
                        $bg_class = " achievement-locked";
                    } else {
                        $image = $achievement['nice_image'];
                        $unlocked_class = "success";
                        $unlocked = "Splněno";
                        $bg_class = " achievement-unlocked";
                    }
                    echo "
                    <div class='col-sm-4 col-md-3 col-lg-3'>
                        <div class='thumbnail achievement" . $bg_class . "'>
                            <a href='achievement-".$achievement['id']."'><img src='images/achievements/230/" . $image . "' width='120'></a>
                            <div class='caption text-center'>
                                <h3>" . $achievement['name'] . "</h3>
                                <p>" . $achievement['location'] . "</p>
                                <p style='height: 24px;'><a href='achievement-".$achievement['id']."' class='btn btn-".$unlocked_class." btn-achievement-unlocked'>
                        <span class='glyphicon glyphicon-ok'></span> " . $unlocked . "</a></p>
                            </div>
                        </div>
                    </div>\n";
                }
            } else { // Uživatel nepřihlášen
                $result = dibi::query("SELECT * FROM achievements ORDER BY id");

                foreach ($result as $achievement) {
                    echo "
                    <div class='col-sm-4 col-md-3 col-lg-3'>
                        <div class='thumbnail achievement achievement-public'>
                            <img src='" . $achievement['basic_image'] . "' width='120'>
                            <div class='caption text-center'>
                                <h3>" . $achievement['name'] . "</h3>
                                <p>" . $achievement['location'] . "</p>
                            </div>
                        </div>
                    </div>\n";
                }
            } ?>
        </div>
    </div>
<?php include("includes/footer.php"); ?>