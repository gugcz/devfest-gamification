<div class="row">
    <div class="col-sm-6 col-sm-push-6">
        <!-- Profil -->
        <div class="panel panel-blue">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-user"></span> Profil
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    $result = dibi::query("SELECT user_name, user_image, achievements_unlocked, leaderboard_position, unlocked_first, unlocked_last
                         FROM (
                             SELECT *, @curRank := @curRank + 1 AS leaderboard_position
                             FROM leaderboard l, (SELECT @curRank := 0) r
                             ORDER BY achievements_unlocked DESC, unlocked_last ASC) result
                         WHERE gplus_id = %i", $me['id']);

                    foreach ($result as $user) {
                        $mojePozice = $user['leaderboard_position'];
                        echo "<div class='col-sm-5 col-md-4 col-lg-3'><img style='margin-right: 15px;' src='" . $user['user_image'] . "?sz=120'></div>\n";
                        echo "<div class='col-sm-7 col-md-8 col-lg-9'><table><tr><td colspan='2'><h3 style='margin-top: 0;'>" . $user['user_name'] . "</h3></td></tr>\n";
                        echo "<tr>
                    <td class='text-muted'>Moje pořadí</td><td>" . $user['leaderboard_position'] . ". z 100</td>
                    </tr><tr>
                    <td class='text-muted'>První achievement</td><td>" . $user['unlocked_first'] . "</td>
                    </tr><tr>
                    <td class='text-muted'>Poslední achievement</td><td>" . $user['unlocked_last'] . "</td>
</tr>
                    </table></div>\n";
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Achievementy -->
        <div class="panel panel-red">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-tags"></span> Moje Achievementy
            </div>
            <table class="table table-striped table-hover leaderboard">
                <tr>
                    <th colspan="2">Google+ Jméno</th>
                    <th class="text-right">Počet bodů</th>
                </tr>
                <?php
                $result = dibi::query("SELECT * FROM leaderboard ORDER BY achievements_unlocked DESC, unlocked_last ASC LIMIT 0,10");
                if (count($result) == 0) {
                    echo "<tr><td>&nbsp;</td><td>Zatím nikdo nesoutěžil</td><td>&nbsp;</td></tr>";
                } else {
                    foreach ($result as $player) {
                        echo "<tr><td class='profile-photo'><img src='" . $player['user_image'] . "?sz=30' alt=''></td>
                        <td><span>" . $player['user_name'] . "</span></td>
                        <td class='text-right'>" . $player['achievements_unlocked'] . " bodů</td></tr>\n";
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div class="col-sm-6 col-sm-pull-6">
        <!-- Moje pořadí -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-stats"></span> Moje pořadí
            </div>
            <table class="table table-striped table-hover leaderboard">
                <tr>
                    <th>&nbsp;</th>
                    <th colspan="2">Google+ Jméno</th>
                    <th class="text-right">Počet bodů</th>
                </tr>
                <?php
                $startLimit = $mojePozice - 3;
                if ($startLimit < 0)
                    $startLimit = 0;

                $result = dibi::query("SELECT * FROM leaderboard ORDER BY achievements_unlocked DESC, unlocked_last ASC LIMIT " . $startLimit . ",5");
                if (count($result) == 0) {
                    echo "<tr><td>&nbsp;</td><td>Zatím nikdo nesoutěžil</td><td>&nbsp;</td></tr>";
                } else {
                    $i = $startLimit + 1;
                    foreach ($result as $player) {
                        if ($i == $mojePozice) {
                            $podbarveni = " class='danger'";
                        } else {
                            $podbarveni = "";
                        }
                        echo "<tr" . $podbarveni . ">
                            <td style='width: 45px;' class='text-right'>" . $i . ".</td>
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
        <!-- Celkové pořadí -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-stats"></span> Leaderboard <strong>TOP 10</strong>
            </div>
            <table class="table table-striped table-hover leaderboard">
                <tr>
                    <th>&nbsp;</th>
                    <th colspan="2">Google+ Jméno</th>
                    <th class="text-right">Počet bodů</th>
                </tr>
                <?php
                $result = dibi::query("SELECT * FROM leaderboard ORDER BY achievements_unlocked DESC, unlocked_last ASC LIMIT 0,10");
                if (count($result) == 0) {
                    echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>Zatím nikdo nesoutěžil</td><td>&nbsp;</td></tr>";
                } else {
                    $i = 1;
                    foreach ($result as $player) {
                        echo "<tr>
                            <td style='width: 45px;' class='text-right'>" . $i . ".</td>
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