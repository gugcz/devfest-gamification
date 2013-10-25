<?php include("includes/header.php"); ?>
    <div class="container">
        <?php if (!isset($authUrl)) { ?>
            <h1>Přehled tvých achievementů</h1>
            <table class="table table-striped">
                <tr>
                    <th>&nbsp;</th>
                    <th>Název</th>
                    <th>Místo</th>
                </tr>
                <?php
                $result = dibi::query("SELECT * FROM achievements
                 LEFT JOIN log ON achievement_id = id
                 WHERE gplus_id = %s
                 ORDER BY id", $me['id']);

                foreach ($result as $achievement) {
                    $image = $achievement['nice_image'];
                    echo "<tr><td><img src='" . $image . "' width='50'></td><td>" . $achievement['name'] . "</td><td>" . $achievement['location'] . "</td></tr>";
                }
                ?>
            </table>
        <?php } else { ?>
            <h1>Přehled achievementů</h1>
            <table class="table table-striped">
                <tr>
                    <th>&nbsp;</th>
                    <th>Název</th>
                    <th>Místo</th>
                </tr>
                <?php
                $result = dibi::query("SELECT * FROM achievements ORDER BY id");

                foreach ($result as $achievement) {
                    echo "<tr><td><img src='" . $achievement['nice_image'] . "' width='50'></td><td>" . $achievement['name'] . "</td><td>" . $achievement['location'] . "</td></tr>";
                }
                ?>
            </table>
        <?php } ?>
    </div>
<?php include("includes/footer.php"); ?>