<?php
if (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Conference Twitter Wall</title>
    <link rel="stylesheet" type="text/css" href="http://mdevgame.inmite.eu/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://mdevgame.inmite.eu/css/bootstrap-theme.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="app/screen.css"> -->

    <!-- make your customisations to the twitter wall using the custom.css -->
    <!-- <link rel="stylesheet" type="text/css" href="custom.css"> -->
    <link href="http://mdevgame.inmite.eu/css/theme.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 0;
        }

        .barvicka {
            border-bottom: 4px #0081c5 solid;
            padding: 10px;
            height: 240px;
            margin-bottom: 10px;
        }

        .row {
            height: 748px;
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .col-md-3 {
                width: 242px;
            }
        }

        @media (min-width: 1200px) {
            .col-md-3 {
                width: 292px;
            }
        }
    </style>
</head>
<body>
<div class="totalcenter">
    <div class="container" id="twitterwall">
        <img src="http://mdevgame.inmite.eu/images/footer.png" class="img-responsive" style="margin: auto;">

        <div class="row" id="tweets"></div>
        <img src="http://mdevgame.inmite.eu/images/footer.png" class="img-responsive" style="margin: auto;">
    </div>
</div>
<script type="text/html" id="tweet_template">
    <div class="col-md-3" id="<%=id%>">
        <div class="barvicka">
            <img src="<%=profile_image_url%>"/>
    <span style="font-size: 14pt; margin-left: 5px; font-weight: bold;">
        <%=screen_name%>
    </span>

            <p style="font-size: 12pt; margin-top: 5px; overflow: hidden;"><%=tweet%></p>
        </div>
    </div>
</script>


<script src="twtwall/config<?php echo $id;?>.js"></script>
<script src="twtwall/app/js/twitterlib.js"></script>
<script src="twtwall/app/js/jquery.min.js"></script>
<script src="twtwall/app/js/app.js"></script>
</body>
</html> 
 
 
 
 
 
 
 
