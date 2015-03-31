<?php
    require('../database/connect.db.php');
    
    if (empty($_POST["title"]) || empty($_POST["details"])) {
        header('Location: ' . '/to_do/');
    }
    else {
        $title     = $_POST["title"];
        $details   = $_POST["details"];
        $important = $_POST["important"];
        
        $sql =  "INSERT INTO tasks (title, details, done, important, created_at)
                        VALUES ('$title', '$details', '0', '$important', NOW())";
        mysql_query($sql);
        $id = mysql_insert_id();
        if ($important == 1) $class = 'important';
        else $class = 'rest';
        echo "<li class='$class'><h3> $title <form action='/to_do/includes/functions/delete.php' method='POST' class='delete-form' id='del_$id' novalidate='novalidate'><i class='pull-right delete-task'> X </i><input name='delete' type='hidden' value='$id'/></form><form action='/to_do/includes/functions/mark_as_done.php' method='POST' class='done-form' id='done_$id' novalidate='novalidate'><i class='pull-right done-task'> ✓ </i><input name='done' type='hidden' value='1'/></form></h3><p>$details</p></li>";
    }
?>