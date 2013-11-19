<?php require_once("../config.php");
if (isset($_GET['time']))
    $time = $_GET['time'];
else
    header("Location: /leaderboard-single");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DevFest Praha 2013">
    <meta name="author" content="Jirka Korejtko">

    <title>DevFest Praha 2013</title>

    <!-- Bootstrap core CSS -->
    <link href="http://quest.devfest.cz/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://quest.devfest.cz/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/devfest-style.css" rel="stylesheet">
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
        .next {
            margin: 20px 0 0 0;
            display: block;
            text-align: center;
            font-weight: bold;
            font-size: 50px;
        }
        .prednaska {
            margin: 0;
            display: block;
            text-align: center;
            font-weight: bold;
            color: #0080c5;
            font-size: 70px;
            overflow: hidden;
        }
    </style>
</head>

<body>
<div class="totalcenter">
    <div class="container">
        <img src="http://quest.devfest.cz/images/footer.png" class="img-responsive" style="margin: auto;">

        <span class="next">Následuje</span>
        <span class="prednaska">Vnitřní architektura Chrome Developer Tools</span>

        <div class="col-md-12 countdown">
            <div id="countdown">
                <div style="height: 50px"></div>
                <ul class="menu menu-h">
                    <li>
                        <span id="minutes"></span> Minut
                    </li>
                    <li>
                        <span id="seconds"></span> Vteřin
                    </li>
                </ul>
            </div>
        </div>

        <div style="height: 103px"></div>

        <img src="http://quest.devfest.cz/images/footer.png" class="img-responsive" style="margin: auto;">
    </div>
</div>
<script type='text/javascript' src='http://quest.devfest.cz/js/jquery.min.js'></script>
<script type='text/javascript' src='http://quest.devfest.cz/js/jquery.countdown.min.js'></script>
<script type='text/javascript'>
    $(document).ready(function () {
        /* Countdown */
        if ($('#countdown').size() > 0) {
            $('#countdown').countdown(new Date("November 23, 2013 <?php echo $time; ?>:00"), function (event) {
                var $this = $(this);
                switch (event.type) {
                    case "seconds":
                    case "minutes":
                    case "hours":
                    case "days":
                        $this.find('span#' + event.type).html(event.value);
                        break;
                    case "finished":
                        $this.hide();
                        break;
                }
            });
        }
    });
</script>
</body>
</html>