<div class="row">
    <div class="col-sm-6 col-sm-push-6">
        <!-- Profil -->
        <div class="panel panel-red">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-user"></span> Profil
            </div>
            <div class="panel-body">
                <?php
                $result = dibi::query("SELECT user_name, user_image, achievements_unlocked, leaderboard_position, players_total, unlocked_first, unlocked_last
                         FROM (
                             SELECT *, @curRank := @curRank + 1 AS leaderboard_position
                             FROM leaderboard l, (SELECT @curRank := 0, COUNT(*) AS players_total FROM leaderboard) r
                             ORDER BY " . $nastaveni['orderSequence'] . ") result
                         WHERE gplus_id = %i", $me['id']);

                if (count($result) == 1) {
                    $result->setType("unlocked_first", dibi::FIELD_DATETIME)->setFormat(dibi::FIELD_DATETIME, "H:i:s");
                    $result->setType("unlocked_last", dibi::FIELD_DATETIME)->setFormat(dibi::FIELD_DATETIME, "H:i:s");
                    $user = $result->fetch();
                    $mojePozice = $user['leaderboard_position'];
                    $result = dibi::query("SELECT COUNT(*) FROM achievements");
                    $achievements_count = $result->fetchSingle();
                    echo " <div class='row'>
                        <div class='col-sm-5 col-md-4 col-lg-3'>
                            <img style='margin-right: 15px;' src='" . $user['user_image'] . "?sz=136'>
                        </div>\n";
                    echo "<div class='col-sm-7 col-md-8 col-lg-9'><table class='table-profil'><tr><td colspan='2'>
                            <h3 style='margin-top: 0;'>" . $user['user_name'] . "</h3>
                        </td></tr>\n";
                    echo "<tr>
                        <td class='text-muted'>Moje pořadí</td><td><span class='badge'>" . $user['leaderboard_position'] . ".</span> z " . $user['players_total'] . "</td>
                    </tr><tr>
                        <td class='text-muted'>Celkem získáno</td><td><span class='badge'>" . $user['achievements_unlocked'] . "</span> z " . $achievements_count . "</td>
                    </tr><tr>
                        <td class='text-muted'>První achievement</td><td>" . $user['unlocked_first'] . "</td>
                    </tr><tr>
                        <td class='text-muted'>Poslední achievement</td><td>" . $user['unlocked_last'] . "</td>
                    </tr>
                    </table></div></div>\n";
                } else {
                    echo "<div class='alert alert-danger'><strong>Získej první achievement a zde uvidíš své statistiky.</strong></div>";
                }
                ?>
            </div>
        </div>
        <!-- Achievementy -->
        <?php include("includes/panel-achievements.php"); ?>
    </div>
    <div class="col-sm-6 col-sm-pull-6">
        <!-- Moje pořadí -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-stats"></span> Moje pořadí
            </div>
            <table class="table table-striped table-hover leaderboard">
                <tr>
                    <th>&nbsp;</th>
                    <th colspan="2">Google+ Jméno</th>
                    <th class="text-right">Achievementů</th>
                </tr>
                <?php
                $startLimit = $mojePozice - 3;
                if ($startLimit < 0)
                    $startLimit = 0;

                $result = dibi::query("SELECT * FROM leaderboard ORDER BY " . $nastaveni['orderSequence'] . " LIMIT " . $startLimit . ",5");
                if (count($result) == 0) {
                    echo "<tr><td>&nbsp;</td><td colspan='2'>Zatím nikdo nesoutěžil.</td><td>&nbsp;</td></tr>";
                } else if (is_null($mojePozice)) {
                    echo "<tr><td>&nbsp;</td><td colspan='2'>Zatím jste se do soutěže nezapojil.</td><td>&nbsp;</td></tr>";
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
                            <td class='profile-photo'><a href='//plus.google.com/".$player['gplus_id']."'><img src='" . $player['user_image'] . "?sz=30' alt=''></a></td>
                            <td><a href='//plus.google.com/".$player['gplus_id']."'>" . $player['user_name'] . "</a></td>
                            <td class='text-right'>" . a($player['achievements_unlocked']) . "</td>
                        </tr>\n";
                        $i++;
                    }
                }
                ?>
            </table>
        </div>
        <!-- Celkové pořadí -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-stats"></span> Leaderboard <strong>TOP 10</strong>
            </div>
            <table class="table table-striped table-hover leaderboard">
                <tr>
                    <th>&nbsp;</th>
                    <th colspan="2">Google+ Jméno</th>
                    <th class="text-right">Achievementů</th>
                </tr>
                <?php
                $result = dibi::query("SELECT * FROM leaderboard ORDER BY " . $nastaveni['orderSequence'] . " LIMIT 0,10");
                if (count($result) == 0) {
                    echo "<tr><td>&nbsp;</td><td colspan='2'>Zatím nikdo nesoutěžil.</td><td>&nbsp;</td></tr>";
                } else {
                    $i = 1;
                    foreach ($result as $player) {
                        echo "<tr>
                            <td style='width: 45px;' class='text-right'>" . $i . ".</td>
                            <td class='profile-photo'><a href='//plus.google.com/".$player['gplus_id']."'><img src='" . $player['user_image'] . "?sz=30' alt=''></a></td>
                            <td><a href='//plus.google.com/".$player['gplus_id']."'>" . $player['user_name'] . "</a></td>
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