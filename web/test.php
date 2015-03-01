<?php
require_once("config.php");
if(isset($_GET['clear'])){
    dibi::query("TRUNCATE log");
    dibi::query("TRUNCATE leaderboard");
    dibi::query("UPDATE achievements SET unlocked_count = 0");
}
if(isset($_POST['url'])){
    $url = $_POST['url'];
} else {
    $url = "achievements/unlock";
}
if(isset($_POST['content'])){
    $content = $_POST['content'];
} else {
    $content = "array(
\"gplus_id\" => \"102751345660146384940\",
\"achievement_id\" => 2,
\"password\" => \"3141\",
\"org_email\" => \"test@gug.cz\"
)";
}
?><html>
<head>
    <title>Test Interface</title>
</head>
<body>
<h1>CDH API Test Interface</h1>

<a href="test.php?clear">Clear Database!</a>
<h2>Request</h2>
<form action="test.php" method="POST">
    Request url:
    <input type="text" name="url" value="<?php echo $url; ?>">
    <br/>
    Json mesage:
    <textarea cols="60" rows="10" name="content"><?php echo $content; ?></textarea>
    <input type="submit" value="Send request">
</form>
Sended:
<pre>
<?php
if (isset($_POST['url'])) {
    eval("\$request = " . $_POST['content'] . ";");

    $json = json_encode($request);
    var_dump($json);
    echo "<br>";
} else {
    echo "nothing yet";
}
?>
</pre>
<div id="response">
<h2>Response:</h2>
<pre>
<?php
if (isset($_POST['url'])) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://quest.devfest.cz/api/" . $_POST['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        curl_close($ch);

        print_r($response);
    } else {
        echo "Please send request.";
    }
    ?>
</pre>
</div>
</body>
</html>