<?php
require_once("config.php");

if (isset($_POST['login_id'])) {
    if(filter_var($_POST['login_id'], FILTER_VALIDATE_INT)){
        $result = dibi::query("SELECT * FROM leaderboard WHERE attendee_id = %i", $_POST['login_id']);
        if(count($result) == 1){
            $me = $result->fetch();
            $_SESSION['logged_in'] = true;
            $_SESSION['attendee_id'] = $me['attendee_id'];
        } else {
            $error = "Soutěžící nenalezen";
        }
    } else {
        $error = "Soutěžící nenalezen";
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['logged_in']);
    unset($_SESSION['attendee_id']);
    unset($me); // pro jistotu
    session_destroy();
}

if (!isset($_POST['login_id']) && isset($_SESSION['logged_in'])) {
    $result = dibi::query("SELECT * FROM leaderboard WHERE attendee_id = %i", $_SESSION['attendee_id']);
    $me = $result->fetch();
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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/theme.css" rel="stylesheet">

    <script type='text/javascript' src='/js/jquery.min.js'></script>
    <script type='text/javascript' src='/js/bootstrap.min.js'></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type='text/javascript' src="/js/autocomplete.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
  <script>
  $(function() {
    $( "#combobox" ).combobox();
    $( "#combobox" ).change(function() {
        $( "#login_form" ).submit();
    });
  });
  </script>
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
                <a class="navbar-brand" href="/" title="DevFest Game">
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
                        if ($_SESSION['logged_in']) {
                            echo "<li class='dropdown'>
                                        <a href='#' style='padding-top: 5px; padding-bottom: 5px;' class='dropdown-toggle' data-toggle='dropdown'>
                                            <img src='/images/attendees/" . $me['user_image'] . "' width='30' height='30'>&nbsp;&nbsp;<strong>". $me['first_name'] . " ". $me['last_name'] . "</strong><b class='caret'></b></a>
                                        <ul class='dropdown-menu'>
                                            <li><a href='?logout'>Odhlásit</a></li>
                                        </ul>
                                      </li></ul>";

                        } else {
                            echo "
                            <form action='/' method='POST' class='navbar-form' id='login_form'>
                                <span style='color:white;' class='navbar-text'>Vaše jméno: </span>
                                <select id='combobox' name='login_id'>
                                    <option value=''>Vyberte své jméno...</option>";
                            $result = dibi::query("SELECT attendee_id, first_name, last_name, email, duplicate_name FROM leaderboard");
                            $allAttendees = $result->fetchAll();
                            foreach ($allAttendees as $attendee) {
                                $attendee['email'] = substr_replace($attendee['email'], "***", 4, strpos($attendee['email'], "@")-4) ;

                                echo "<option value='".$attendee['attendee_id']."'>". $attendee['first_name']." ".$attendee['last_name'].($attendee['duplicate_name']?" (".$attendee['email'].")":"")."</option>";
                            }
                            echo "
                                  </select>
                                  <input type='submit' class='btn' value='Přihlásit'>
                            </form>
                            ";
                        }
                        ?>

                    
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
</nav>

<?php
if (isset($error)){
    echo "<div class='container' style='margin-top: 15px'>
    <div class='alert alert-danger'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
". $error."
</div>
</div>";
}

 /*<img src="images/header.jpg" class="img-responsive" style="margin: auto;" alt="DevFest Quest - Generating Secure Heuristic Encryption Megakey">
    <div id="shem"></div>
    <div id="hash"></div>
    */?>