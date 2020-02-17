<?php

if (isset($data["username"])) {
    ?>
    <h1> HI, <?= $data["username"] ?> </h1>

    <?php
} else {
    ?>

    <h1> PLEASE <a href=""LOGIN </h1>
    <?php
}
?>

