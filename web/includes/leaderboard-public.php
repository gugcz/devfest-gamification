<div class="row">
    <div class="col-sm-6 col-sm-push-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-tag"></span> Získej achievement
            </div>
            <div class="panel-body">
                <?php
                $result = dibi::query("SELECT * FROM achievements ORDER BY RAND() LIMIT 0,1");

                foreach ($result as $achievement) {
                    echo "<img style='float: left; margin-right: 15px;' src='" . $achievement['nice_image'] . "'>";
                    echo "<h2>".$achievement['name']."</h2>";
                    echo "<p>".$achievement['location']."</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-sm-pull-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-stats"></span> Leaderboard
            </div>
            <table class="table table-striped leaderboard">
                <tr>
                    <th>&nbsp;</th>
                    <th colspan="2">Google+ Jméno</th>
                    <th class="text-right">Počet bodů</th>
                </tr>
                <?php
                $result = dibi::query("SELECT * FROM leaderboard ORDER BY achievements_unlocked DESC, unlocked_last ASC");
                if (count($result) == 0) {
                    echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>Zatím nikdo nesoutěžil</td><td>&nbsp;</td></tr>";
                } else {
                    $i = 1;
                    foreach ($result as $player) {
                        echo "<tr>
                            <td style='width: 45px;' class='text-right'>".$i.".</td>
                            <td class='profile-photo'><img src='" . $player['user_image'] . "?sz=30' alt=''></td>
                            <td><span>" . $player['user_name'] . "</span></td>
                            <td class='text-right'>" . a($player['achievements_unlocked']) . "</td>
                        </tr>\n";
                        $i++;
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>