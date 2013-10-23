<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jirka
 * Date: 17.10.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */
require_once("config.php");
?>
<html>
<head><title>DevFest Praha 2013 - Game</title></head>
<body>
<h1>Přehled achievementů</h1>
<?php
$result = dibi::query("SELECT * FROM achievements ORDER BY id");

foreach ($result as $achievement) {
    echo $achievement['name']."<br>";
}
?>
</body>
</html>