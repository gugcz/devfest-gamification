<?php require_once("../config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="mDevGame">
    <meta name="author" content="Jirka Korejtko">

    <title>mDevGame</title>

    <!-- Bootstrap core CSS -->
    <link href="http://mdevgame.inmite.eu/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://mdevgame.inmite.eu/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://mdevgame.inmite.eu/css/theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://mdevgame.inmite.eu/js/html5shiv.js"></script>
    <script src="http://mdevgame.inmite.eu/js/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            padding-top: 0px;
            font-size: 24px;
        }

        .player_name {
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 240px;
            white-space: nowrap;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="totalcenter">
    <div class="container">
        <img src="http://mdevgame.inmite.eu/images/footer.png" class="img-responsive" style="margin: auto;">
    </div>
    <div class="container">
        <div class="row">
            <?php
            $pocet = 10;
            for ($j = 0; $j < 1; $j++) {
                ?>
                <div class="col-md-6">
                    <h2 style="text-align: center; font-weight: bold; margin: 29px 0;">mDevGame Leaderboard</h2>
                    <div class="panel panel-success">
                        <!--<div class="panel-heading">
                            <span class="glyphicon glyphicon-stats"></span>
                            Leaderboard <?php echo ($j * $pocet + 1) . ". - " . ($j * $pocet + $pocet) . "." ?>
                        </div>-->
                        <table class="table table-striped leaderboard">

                            <?php
                            $result = dibi::query("SELECT * FROM leaderboard WHERE achievements_unlocked > 0 ORDER BY " . $nastaveni['orderSequence'] . " %ofs %lmt", $j * $pocet, $pocet);
                            if (count($result) == 0 && $j == 1) {
                                echo "<tr><td colspan='4'>Do soutěže se zapojilo méně než ".($pocet+1)." účastníků</td></tr>";
                            } elseif (count($result) == 0) {
                                echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>Zatím nikdo nesoutěžil.</td><td>&nbsp;</td></tr>";
                            }
                            else {
                                $i = $j * $pocet + 1;
                                foreach ($result as $player) {
                                    echo "<tr>
                            <td style='width: 45px;' class='text-right'>" . $i . ".</td>
                            <td class='profile-photo'><img src='//mdevgame.inmite.eu/images/attendees/136/" . $player['user_image'] . "' alt='" . $player['first_name'] . " " . $player['last_name'] . "' width='45'></td>
                            <td class='player_name'>" . $player['first_name'] . " " . $player['last_name'] . "</td>
                            <td class='text-right'>" . a($player['achievements_unlocked']) . "</td>
                        </tr>\n";
                                    $i++;
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-6">
                <h2 style="text-align: center; font-weight: bold; margin: 29px 0;">Už máte tento achievement?</h2>
                <?php
            $result = dibi::query("SELECT * FROM achievements ORDER BY RAND() LIMIT 0,1");

            foreach ($result as $achievement) {
                ?>
                <div class="panel panel-red" style="border-width: 3px;">
                    <div class="panel-body">
                        <?php
                        echo "<img src='http://mdevgame.inmite.eu/images/achievements/230/" . $achievement['nice_image'] . "' style='display: block; margin:auto;'>";
                        echo "<h1 style='font-weight: bold; margin-top: 10px; text-align: center;'>" . $achievement['name'] . "</h1>";
                        echo "<p style='font-size: 24px; margin: 0; text-align: center;'>" . $achievement['location'] . "</p>";
                        ?>
                    </div>
                </div>
            <?php } ?>
            <span style="color: #0080c5; font-weight: bold; font-size: 46px; margin: 100px auto 0 auto; width: 458px; display: block;">mdevgame.inmite.eu</span>
            </div>
        </div>
    </div>
    <div style="height: 8px"></div>
    <div class="container" style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%;">
        <img src="http://mdevgame.inmite.eu/images/footer.png" class="img-responsive" style="margin: auto;">
    </div>
</div>
<script type='text/javascript' src='http://mdevgame.inmite.eu/js/jquery.js'></script>
<script type='text/javascript' src='http://mdevgame.inmite.eu/js/bootstrap.min.js'></script>
</body>
</html>