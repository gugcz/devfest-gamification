<?php
require_once("config.php");

if (isset($_GET['code'])) {
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = $nastaveni['API_RedirectUri'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_GET['logout'])) {
    unset($_SESSION['token']);
    session_destroy();
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="mDevGame">
    <meta name="author" content="Jirka Korejtko">

    <title>mDevGame</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php /*<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-45381550-1', 'devfest.cz');
    ga('send', 'pageview');

</script>
*/ ?>
<nav>
    <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <!-- required for collapseable bar -->
                <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/leaderboard" title="DevFest Game">
                    mDevGame
                </a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/leaderboard">LeaderBoard</a>
                        </li>
                        <li>
                            <a href="/o-hre">O hře</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <?php
                        if ($client->getAccessToken()) {
                            try {
                                $me = $plus->people->get('me');
                                //$oauth2 = new Google_Oauth2Service($client); // Call the OAuth2 class for get email address
                                //$userinfo = $oauth2->userinfo->get();
                            } catch (Google_Exception $e) {
                                session_destroy();
                                $redirect = 'http://' . $_SERVER['HTTP_HOST'] . "/";
                                header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
                            }
                            echo "<li class='dropdown'>
                                        <a href='#' style='padding-top: 5px; padding-bottom: 5px;' class='dropdown-toggle' data-toggle='dropdown'>
                                            <img src='" . substr($me['image']['url'], 0, -6) . "?sz=30'>&nbsp;&nbsp;<strong>". $me['displayName'] . "</strong><b class='caret'></b></a>
                                        <ul class='dropdown-menu'>
                                            <li><a href='?logout'>Odhlásit</a></li>
                                        </ul>
                                      </li>";

                            //print_r($me);
                            // We're not done yet. Remember to update the cached access token.
                            // Remember to replace $_SESSION with a real database or memcached.
                            $_SESSION['token'] = $client->getAccessToken();
                        } else {
                            $authUrl = $client->createAuthUrl();
                            print "<li><a class=\"g-signin\" href='$authUrl'><img src=\"/images/Red-signin_Medium_base_32dp.png\"></a></li>";
                        }
                        ?>

                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
</nav>

<?php /*<img src="images/header.jpg" class="img-responsive" style="margin: auto;" alt="DevFest Quest - Generating Secure Heuristic Encryption Megakey">
    <div id="shem"></div>
    <div id="hash"></div>
    */?>