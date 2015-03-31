<?php
    require('../database/connect.db.php');
    $id = $_POST['delete'];
    $sql = "DELETE FROM `tasks` WHERE `id` = '$id'";
    mysql_query($sql);
    echo "del_$id";
?>