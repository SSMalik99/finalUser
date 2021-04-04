<?php
    
    if(isset($_POST['updateTask'])){
        $taskId=$_POST['taskId'];
        $taskTitle=$_POST['taskTitleEdit'];
        $taskDesc=$_POST['taskDiscEdit'];
        $taskDesc=strtolower($taskDesc);
        $taskTitle=strtolower($taskTitle);
        $dbObj=new dbConnection();
        $dbObj->connectDb();
        $queryObj=new createTaskQuery();
        $queryObj->updateTask($taskId,$taskTitle,$taskDesc);
        $result = mysqli_query($dbObj->con,$queryObj->myQuery);
        $dbObj->dissconnectDb();
        if($result){
            echo "<div class=\"alert alert-success\"role=\"alert\">
            User is updated successfully
        </div>";
        }else{
            echo "<div class=\"alert alert-success\"role=\"alert\">
            Sorry! but currently we are not able to do this task!
        </div>";
        }
    }

?>
