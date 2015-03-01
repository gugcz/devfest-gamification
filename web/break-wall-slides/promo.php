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
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../js/html5shiv.js"></script>
    <script src="../js/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            padding-top: 0px;
        }
    </style>
</head>

<body>
<div class="totalcenter">

    <img src="../images/header.jpg" class="img-responsive" style="margin: auto;"
         alt="DevFest Quest - Generating Secure Heuristic Encryption Megakey">
    <div id="shem"></div>
    <div id="hash"></div>

    <h1 class="text-center" style="font-weight: bold;">Chceš se vrátit do současnosti?</h1>

    <div style="margin-top: 66px"></div>

    <h1 class="text-center" style="font-weight: bold;">Pomoz alchymistovi a získej tyto achievementy:</h1>
    <!--<h2 class="text-center" style="font-weight: bold;">Císař vás náležitě odmění a ten nejlepší bude moci použít Josill!</h2>-->
    <!--<h2 class="text-center">Získej tyto achievementy:</h2>-->
    <br>

    <div class="container">
        <div class="row">
            <?php
            $result = dibi::query("SELECT * FROM achievements ORDER BY RAND() LIMIT 0,2");

            foreach ($result as $achievement) {
                ?>
                <div class="col-md-6">
                    <div class="panel panel-red" style="border-width: 3px;">
                        <div class="panel-body">
                            <?php
                            echo "<img src='../images/achievements/230/" . $achievement['nice_image'] . "' style='width: 140px; float: left; margin-right: 20px'>";
                            echo "<h1 style='font-weight: bold; margin-top: 10px'>" . $achievement['name'] . "</h1>";
                            echo "<p style='font-size: 24px; margin: 0;'>" . $achievement['location'] . "</p>";
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div style="text-align: center; font-weight: bold; color: #0080c5; font-size: 90px; margin: 30px 0 50px 0;">quest.devfest.cz</div>

        <img src="../images/footer.png" class="img-responsive" style="margin: auto;">
    </div>
</div>
<script type='text/javascript' src='../js/jquery.min.js'></script>
<script type='text/javascript' src='../js/hash.js'></script>
</body>
</html>