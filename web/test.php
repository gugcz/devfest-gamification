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
\"gplus_id\" => \"100156589101321820776\",
\"achievement_id\" => 2,
\"password\" => \"3141\",
\"org_email\" => \"jirka@korejtko.cz\"
)";
}
?><html>
<head>
    <title>Test Interface</title>
</head>
<body>
<h1>CDH API Test Interface</h1>
Test IDs:<br>
Jirka Korejtko: 102938374256233421705<br>
David Vávra: 100156589101321820776<br>
Larry Page: 106189723444098348646<br>
Daniel Franc: 114523676440083927755<br>
Milan Kacálek: 117544014397520627186<br>
Jirka Pénzeš: 103463398899682658670<br>
Tomáš Jukin: 104479307512579553448<br>
Pavel Vybíral: 106453391606524616170<br>
Jana Moudrá: 115898582817676935843<br>

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