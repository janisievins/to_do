<?php
    require('../database/connect.db.php');
    $id = $_POST['done'];
    $sql = "UPDATE `tasks` SET `done`=1, `important`=0 WHERE `id`='$id'";
    mysql_query($sql);
    echo "done_$id";
?>