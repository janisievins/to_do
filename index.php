<?php
    require('includes/database/connect.db.php'); // Connects to database
    require('includes/functions/show.php');      // Gets data from database
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> TODO </title>
        <link rel="shortcut icon" href="/to_do/includes/img/fvcn.jpg">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- JavaScript files-->
        <script type="text/javascript" src="/to_do/includes/js/jquery.js"></script>
        <script type="text/javascript" src="/to_do/includes/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/to_do/includes/js/main.js"></script>
        <script type="text/javascript" src="/to_do/includes/js/jquery.validate.min.js"></script>

        <!-- CSS files -->
        <link rel="stylesheet" href="/to_do/includes/css/font-awesome.min.css">
        <link rel="stylesheet" href="/to_do/includes/css/bootstrap.min.css">
        <link rel="stylesheet" href="/to_do/includes/css/jquery-dialog.css" >
        <link rel="stylesheet" href="/to_do/includes/css/main.css">
    </head>

    <body>
        <!-- Info button -->
        <div class="info-box">
           <p class="marginb0">
                <i class="fa fa-question-circle fa-2x info-button"></i>
                <i class="overlay"> What is this? </i>
           </p>
        </div>
        
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 padding0">
            
            <!-- Main title -->
            <div class="title">
                <h2> Your very own </h2>
                <h1>TODO</h1>
            </div>
            
            <!-- Main container with all tasks -->
            <div class="main-box pos-center">
                <div class="main-box-add">
                    <i class="fa fa-plus fa-3x"></i>
                </div>
                
                <!-- If JavaScript is disabled -->
                <noscript>
                    <style type="text/css">
                        .items-inner, .dialog-done, .dialog-delete, .main-box-add { display:none; }
                        .no-js { display: block; }
                    </style>
                </noscript>
                <div class="no-js">
                    <h3><i>Please enable JavaScript to make this page work properly!</i></h3>
                </div>
                
                <div class="items-inner">
                    <ul class="item-list">
                        <!-- Input form -->
                        <h1 id="new-task-title"> Add a new task! </h1>
                        <li id='form' class='normal-form' > 
                            <form action='/to_do/includes/functions/add.php' method='POST' class='ajax'>
                                <input type='text' id='title' name='title' class='title-input' placeholder='Title here...' autocomplete='off' autocorrect='off' spellcheck='false'><br>
                                <textarea id='details' name='details'  class='details-input' placeholder='And details here...'></textarea>
                                <div class='row form-buttons'>
                                    <div id='star' class='col-md-1 pull-left'>
                                        <i class='fa fa-star-o fa-lg'></i>
                                    </div>
                                    <div id='mark-important' class='col-md-9 pull-left'>
                                        <p> -  Mark as important!  </p>
                                    </div>
                                    <input id='important' name='important' type='hidden' value='0'/>
                                    <div id='submit-btn' class='form-btn col-md-1 pull-right'>
                                        <i id='submit' class='fa fa-check'></i>
                                    </div>
                                </div>
                            </form>
                        </li>
                        
                        <!--  Message if there are no tasks yet -->
                        <div class="empty">
                            <h1> Congratulations! </h1><hr>
                            <h3> By now you have absolutely nothing to do! </h3>
                        </div>
                        
                        <!-- Important tasks -->
                        <?php while ($task_i = mysql_fetch_array($tasks_impo, MYSQL_ASSOC)){ //Loops through all the important tasks ?> 
                            <li class="important">
                                <h3> <?php echo htmlentities($task_i['title']) ?>
                                    <form action='/to_do/includes/functions/delete.php' method='POST' class='delete-form' id="del_<?php echo $task_i['id'] ?>">
                                        <i class="pull-right delete-task"> X </i>
                                        <input name='delete' type='hidden' value='<?php echo $task_i['id'] ?>'/>
                                    </form>
                                    <form action='/to_do/includes/functions/mark_as_done.php' method='POST' class='done-form' id="done_<?php echo $task_i['id'] ?>">
                                        <i class="pull-right done-task"> ✓ </i>
                                        <input name='done' type='hidden' value='<?php echo $task_i['id'] ?>'/>
                                    </form>
                                </h3>
                                <p><?php echo htmlentities($task_i['details']) ?></p>
                            </li>
                        <?php } ?>
                        
                        <!-- Other tasks -->
                        <?php while ($task_r = mysql_fetch_array($tasks_rest, MYSQL_ASSOC)){ //Loops through all the rest tasks ?>
                            <li class="rest">
                                <h3> <?php echo htmlentities($task_r['title']) ?>
                                    <form action='/to_do/includes/functions/delete.php' method='POST' class='delete-form' id="del_<?php echo $task_r['id'] ?>">
                                        <i class="pull-right delete-task"> X </i>
                                        <input name='delete' type='hidden' value='<?php echo $task_r['id'] ?>'/>
                                    </form>
                                    <form action='/to_do/includes/functions/mark_as_done.php' method='POST' class='done-form' id="done_<?php echo $task_r['id'] ?>">
                                        <i class="pull-right done-task"> ✓ </i>
                                        <input name='done' type='hidden' value='<?php echo $task_r['id'] ?>'/>
                                    </form>
                                </h3>
                                <p><?php echo htmlentities($task_r['details']) ?></p>
                            </li>
                        <?php } ?>
                        
                        <!-- Done tasks -->
                        <?php while ($task_d = mysql_fetch_array($tasks_done, MYSQL_ASSOC)){ //Loops through all the done tasks ?>
                            <li class="done">
                                <h3> <?php echo htmlentities($task_d['title']) ?>
                                    <form action='/to_do/includes/functions/delete.php' method='POST' class='delete-form' id="del_<?php echo $task_d['id'] ?>">
                                        <i class="pull-right delete-task"> X </i>
                                        <input name='delete' type='hidden' value='<?php echo $task_d['id'] ?>'/>
                                    </form>
                                </h3>
                                <p><?php echo htmlentities($task_d['details']) ?></p>
                            </li>
                        <?php } ?>
                        
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Dialog popups -->
        <div class="dialog-delete">
            <h2> Attention! </h2><br>
            <h4> Are you sure you want to permanently delete this task? </h4>
        </div>
        
        <div class="dialog-done">
            <h2> Confirmation! </i></h2><br>
            <h4> Are you sure you want to mark this task as done? </h4>
        </div>
        
        <div class="dialog-info">
            <h2> What's TODO? </h2><br>
            <p class="first-par"> TODO may seem as a perfect name for your next dog, but actually it's just a 'To Do list' homework for White Digital made by Jānis Ieviņš at the end of March, 2015.</p>
            <h2> Instructions: </h2>
            <ol>
                <li><b> To add a new task: </b></li>
                <ul>
                    <li> Press <img src="/to_do/includes/img/plus.jpg"></li>
                    <li> Fill the form</li>
                        <ul>
                            <li> Feel free to put date or time in the title field if you wish</li>
                            <li> Both 'title' and 'details' fields must be filled with at least 5 characters in each of them</li>
                        </ul>
                    <li> If the task is important, press<img src="/to_do/includes/img/star.jpg"></li>
                    <li> Press <img src="/to_do/includes/img/done.jpg"> to submit task</li>
                </ul>
                <p>* All the important tasks will be colored pink and always stay at the very top of the list, in a descending order. Other tasks will be yellow, descending as well.</p>
                          
                <li><b> To mark a task as done: </b></li>
                <ul>
                    <li> Press <img src="/to_do/includes/img/check.jpg"> </li>
                    <li> In the popup window, read the confirmation text and press <img src="/to_do/includes/img/yes.jpg"></li>
                    <li> If you have changed your mind and don't want to submit this task anymore, press <img src="/to_do/includes/img/no.jpg"></li>
                </ul>
                <p class="marginb0">*The tasks that you mark as done will be colored white and always stay at the very bottom of the list.</p>
                <p>*There will be no way you can ever return the status of the task.</p>
                
                <li><b> To delete a task: </b></li>
                <ul>
                    <li>Press <img src="/to_do/includes/img/delete.jpg">;</li>
                    <li> In the popup window, read the confirmation text and press <img src="/to_do/includes/img/yes.jpg"></li>
                    <li> If you have changed your mind and don't want to change the status of this task, press <img src="/to_do/includes/img/no.jpg"></li>
                </ul>
                <p>*The task will be teleted permanently and there will be no way you can ever see it again.</p>    
            </ol>
        </div>
        
    </body>
</html>
