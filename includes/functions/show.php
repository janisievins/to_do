<?php

/* get the important tasks */
    $query_impo = "SELECT id, title, details, important, done
                   FROM tasks
                   WHERE important = 1 AND done = 0
                   ORDER BY created_at DESC
    ";
    
    $tasks_impo = NULL;
    $tasks_impo =  mysql_query($query_impo);
    $important_tasks = mysql_num_rows($tasks_impo) ? $tasks_impo : [];
   
/* get the tasks that are done*/
    $query_done = "SELECT id, title, details, important, done
                   FROM tasks
                   WHERE done = 1 
                   ORDER BY done DESC
    ";
    $tasks_done = NULL;
    $tasks_done =  mysql_query($query_done);
    $done_tasks = mysql_num_rows($tasks_done) ? $tasks_done : [];
    
/* get all the rest tasks*/
     $query_rest = "SELECT id, title, details, important, done
                    FROM tasks
                    WHERE important = 0 AND done = 0
                    ORDER BY created_at DESC
    ";
    $tasks_rest = NULL;
    $tasks_rest =  mysql_query($query_rest);
    $rest_tasks = mysql_num_rows($tasks_rest) ? $tasks_rest : [];

     
/* check if all empty */
    if ($important_tasks == 0 && $rest_tasks == 0  && $done_tasks == 0 ) $empty = true; 

    
?>