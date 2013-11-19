<?php
if (isset($_GET['interval']))
    $interval = $_GET['interval'];
else
    $interval = 20;

if (isset($_GET['time']))
    $time = $_GET['time'];
else
    $time = null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="EN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DevFest Praha 2013</title>
    <style type="text/css">
        html {
            overflow: auto;
        }

        html, body, div, iframe {
            margin: 0px;
            padding: 0px;
            height: 100%;
            border: none;
        }

        iframe {
            display: block;
            width: 100%;
            border: none;
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<iframe id="frame" src="/leaderboard-single" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%"
        scrolling="no"></iframe>

<script type="text/javascript">
    var i = 1;
    function changeFrame() {
        switch (i) {
            case 1:
                var uri = '/promo';
                break;
            case 2:
                var uri = 'http://devfestpraha.tweetwally.com/embed';
                break;
            <?php
            if(!is_null($time)){
                echo "            case 3:
                var uri = '/countdown?time=".$time."';
                break;";
            }
            ?>
            default:
                document.location = document.location;
                break;
        }
        document.getElementById('frame').src = uri;
        i++;
    }
    setInterval(changeFrame, <?php echo $interval; ?> * 1000
    )
    ;
</script>
</body>
</html>