<?php
if (isset($_GET['part']))
    $part = $_GET['part'];
else
    $part = 1;
?>
<!DOCTYPE html>
<html>
<head>
    <title>DevFest Praha 2013 - Partneri</title>
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/theme.css" rel="stylesheet">
    <style type="text/css">
        .fullimg {
            width: 1024px;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>
<div class="totalcenter">
    <img src="images/partneri/wall<?php echo $part; ?>.png" class="fullimg">
</div>
</body>
</html>