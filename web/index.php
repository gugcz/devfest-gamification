<?php include("includes/header.php"); ?>
<div class="container">
<h1>Žebříček soutěžících</h1>
<table class="table table-striped">
    <tr><th>&nbsp;</th><th>Jméno soutěžícího</th><th>Počet bodů</th></tr>
<?php
$result = dibi::query("SELECT * FROM leaderboard ORDER BY achievements_unlocked DESC, unlocked_last ASC");
if(count($result) == 0){
    echo "<tr><td>&nbsp;</td><td>Zatím nikdo nesoutěžil</td><td>&nbsp;</td></tr>";
}
else {
foreach ($result as $player) {
    echo "<tr><td><img src='".$player['user_image'] ."?sz=50' alt=''></td><td>" . $player['user_name']."</td><td>".$player['achievements_unlocked']."</td></tr>";
}}
?>
</table>
    </div>
<?php include("includes/footer.php"); ?>