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
<html lang="cs" itemscope itemtype="http://schema.org/Event" xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DevFest Praha 2013 - Game</title>
    <meta itemprop="name" content="DevFest Praha 2013 - Game">
    <meta itemprop="description" content="Herní portál DevFestové hry 2013">

    <link rel="stylesheet" href="/css/style.css" media="screen, projection">
    <link rel="stylesheet" href="/css/print.css" media="print">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link rel="stylesheet" href="/css/ie.css" type="text/css" media="screen, projection"/>
    <![endif]-->

<body>
<nav>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <!-- required for collapseable bar -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="/" title="DevFest Game">
                    DevFest Game
                </a>

                <div class="nav-collapse">
                    <ul class="nav">
                        <li>
                            <a href="/leaderboard">LeaderBoard</a>
                        </li>
                        <li>
                            <a href="/achievements">Seznam achievementů</a>
                        </li>
                    </ul>
                    <ul class="nav pull-right">

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
                                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                                            <img src='" . substr($me['image']['url'], 0, -6) . "?sz=20'>&nbsp;&nbsp;<strong>". $me['displayName'] . "</strong><b class='caret'></b></a>
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
    </div>
</nav>