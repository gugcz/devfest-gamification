<div class="row">
    <div class="col-sm-6 col-sm-push-6">
        <?php include("includes/panel-achievements.php"); ?>
    </div>
    <div class="col-sm-6 col-sm-pull-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-stats"></span> Leaderboard
            </div>
            <table class="table table-striped leaderboard">
                <tr>
                    <th>&nbsp;</th>
                    <th colspan="2">Jméno</th>
                    <th class="text-right">Achievementů</th>
                </tr>
                <?php
                $result = dibi::query("SELECT * FROM leaderboard ORDER BY " . $nastaveni['orderSequence']);
                if (count($result) == 0) {
                    echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>Zatím nikdo nesoutěžil</td><td>&nbsp;</td></tr>";
                } else {
                    $i = 1;
                    foreach ($result as $player) {
                        echo "<tr>
                            <td style='width: 45px;' class='text-right'>" . $i . ".</td>
                            <td class='profile-photo'><img src='/images/attendees/" . $player['user_image'] . "' alt='" . $player['first_name'] . " " . $player['last_name'] . "' width='30' height='30'></td>
                            <td>";
                            if($player["twitter"]){
                            echo "
                                <a href='//twitter.com/" . $player['twitter'] . "'>
                                " . $player['first_name'] . " " . $player['last_name'] . "
                                </a>";
                            } else {
                                echo $player['first_name'] . " " . $player['last_name'];
                            }
                            echo "
                            </td>
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