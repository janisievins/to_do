<?php

    session_start();
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'to_do';
    $query = '';

    if ($conn = mysql_connect($db_host, $db_user, $db_pass))
    {
        if($db = mysql_select_db($db_name))
        {
            $table = "CREATE TABLE IF NOT EXISTS tasks (
                id         INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                created_at TIMESTAMP,
                title      VARCHAR (30) NOT NULL,
                details    VARCHAR(100) NOT NULL,
                done       tinyint(1) unsigned default '0',
                important  tinyint(1) unsigned default '0'
            ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
            
             mysql_query($table);
        }
        
    }
    
    

?>