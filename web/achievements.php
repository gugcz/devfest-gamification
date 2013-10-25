<?php include("includes/header.php"); ?>
    <div class="container">
        <?php if (!isset($authUrl)) { ?>
            <h1>Přehled tvých achievementů</h1>
            <table class="table table-striped">
                <tr>
                    <th>&nbsp;</th>
                    <th>Název</th>
                    <th>Místo</th>
                    <th>Stav</th>
                </tr>
                <?php
                $result = dibi::query("SELECT id, name, location, nice_image, basic_image, congrats_text, unlocked_time FROM achievements
                 LEFT JOIN (SELECT achievement_id, unlocked_time FROM log WHERE gplus_id = %s) d ON achievement_id = id
                 ORDER BY id", $me['id']);

                foreach ($result as $achievement) {
                    if ($achievement['unlocked_time'] === null) {
                        $image = $achievement['basic_image'];
                        $unlocked = "Nesplněno";
                    } else {
                        $image = $achievement['nice_image'];
                        $unlocked = "Splněno";
                    }
                    echo "<tr>
                            <td><img src='" . $image . "' width='50'></td>
                            <td>" . $achievement['name'] . "</td>
                            <td>" . $achievement['location'] . "</td>
                            <td>" . $unlocked . "</td>
                          </tr>";
                }
                ?>
            </table>
        <?php } else { ?>
            <h1>Přehled achievementů</h1>
            <table class="table table-striped">
                <tr>
                    <th>&nbsp;</th>
                    <th>Název</th>
                    <th>Místo</th>
                </tr>
                <?php
                $result = dibi::query("SELECT * FROM achievements ORDER BY id");

                foreach ($result as $achievement) {
                    echo "<tr><td><img src='" . $achievement['nice_image'] . "' width='50'></td><td>" . $achievement['name'] . "</td><td>" . $achievement['location'] . "</td></tr>";
                }
                ?>
            </table>
        <?php } ?>
    </div>
<?php include("includes/footer.php"); ?>