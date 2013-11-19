<?php include("includes/header.php"); ?>
    <div class="container">
        <br>

        <?php
        if(!isset($authUrl)){
            include("includes/leaderboard-login.php");
        } else {
            include("includes/leaderboard-public.php");
        }
        ?>
    </div>
<?php include("includes/footer.php"); ?>