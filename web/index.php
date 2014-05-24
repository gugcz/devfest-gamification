<?php include("includes/header.php"); ?>
    <div class="container">
        <br>

        <?php
        if($_SESSION['logged_in']){
            include("includes/leaderboard-login.php");
        } else {
            include("includes/leaderboard-public.php");
        }
        ?>
    </div>
<?php include("includes/footer.php"); ?>