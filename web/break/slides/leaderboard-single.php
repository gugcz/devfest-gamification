<?php require_once("../config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DevFest Quest">
    <meta name="author" content="Jirka Korejtko">

    <title>DevFest Quest</title>

    <!-- Bootstrap core CSS -->
    <link href="http://quest.devfest.cz/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://quest.devfest.cz/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://quest.devfest.cz/css/theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://quest.devfest.cz/js/html5shiv.js"></script>
    <script src="http://quest.devfest.cz/js/respond.min.js"></script>
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
        <img src="http://quest.devfest.cz/images/footer.png" class="img-responsive" style="margin: auto;">
    </div>
    <h2 style="text-align: center; font-weight: bold; margin: 29px 0;">Leaderboard achievementů - <span style="color: #0080c5;">quest.devfest.cz</span></h2>

    <div class="container">
        <div class="row">
            <?php
            $pocet = 11;
            for ($j = 0; $j < 2; $j++) {
                ?>
                <div class="col-md-6">
                    <div class="panel panel-success">
                        <!--<div class="panel-heading">
                            <span class="glyphicon glyphicon-stats"></span>
                            Leaderboard <?php echo ($j * $pocet + 1) . ". - " . ($j * $pocet + $pocet) . "." ?>
                        </div>-->
                        <table class="table table-striped leaderboard">

                            <?php
                            $result = dibi::query("SELECT * FROM leaderboard ORDER BY " . $nastaveni['orderSequence'] . " %ofs %lmt", $j * $pocet, $pocet);
                            if (count($result) == 0 && $j == 1) {
                                echo "<tr><td colspan='4'>Do soutěže se zapojilo méně než ".$pocet." účastníků</td></tr>";
                            } elseif (count($result) == 0) {
                                echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>Zatím nikdo nesoutěžil.</td><td>&nbsp;</td></tr>";
                            }
                            else {
                                $i = $j * $pocet + 1;
                                foreach ($result as $player) {
                                    echo "<tr>
                            <td style='width: 45px;' class='text-right'>" . $i . ".</td>
                            <td class='profile-photo'><img src='" . $player['user_image'] . "?sz=40' alt='" . $player['user_name'] . "'></td>
                            <td class='player_name'>" . $player['user_name'] . "</td>
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
        </div>
    </div>
    <div style="height: 8px"></div>
    <div class="container" style="position: absolute; bottom: 0; width: 100%;">
        <img src="http://quest.devfest.cz/images/footer.png" class="img-responsive" style="margin: auto;">
    </div>
</div>
<script type='text/javascript' src='http://quest.devfest.cz/js/jquery.js'></script>
<script type='text/javascript' src='http://quest.devfest.cz/js/bootstrap.min.js'></script>
</body>
</html>