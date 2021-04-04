<?php
    session_start();
    
    if($_SESSION['userRole']){
        include('db.php'); #this will include the data of the Database and queries;
        include('userHandlerClasses.php');
        // include('userHandlerQueries.php');
    }else{
        header("Location:admin.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>ManagerDashboard</title>
</head>
<body>

    <!-- <<<<<<<<<<<<<<<<<<<<<NAVBAR SECTION FOR ADMIN AND MANAGER>>>>>>>>>>>>>> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <a class="navbar-brand font-weight-bold text-light" href="managerInterface.php?home=true">Groot</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon text-dark"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle font-weight-bold text-light" href="user.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    USER
                    </a>
                    <div class="dropdown-menu bg-dark " aria-labelledby="navbarDropdown">
                    <a class="dropdown-item font-weight-bold text-light" href="managerInterface.php?addNewUser=true">Add New Member <span class="sr-only">(current)</span></a>
                    <a class="dropdown-item font-weight-bold text-light" href="managerInterface.php?showAllMember=true">All Users</a>
                    <!-- <div class="dropdown-divider"></div> -->
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle font-weight-bold text-light" href="toDo.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    TASK
                    </a>
                    <div class="dropdown-menu bg-dark " aria-labelledby="navbarDropdown">
                    <a class="dropdown-item font-weight-bold text-light" href="managerInterface.php?myTask=true">My Task</a>
                    <a class="dropdown-item font-weight-bold text-light" href="managerInterface.php?otherUserTask=true">Staff Member Tasks </a>
                    <!-- <div class="dropdown-divider"></div> -->
                    </div>
                </li>
            </ul>
            <?php
                $userId=$_SESSION['userId'];
                $dbObj=new dbConnection();
                $queryObj=new createDataQuery();
                $dbObj->connectDb();
                $queryObj->selectWithCond($userId);
                $userObj=new userChange();
                $table = userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
                $dbObj->dissconnectDb();
                $row=$table->fetch_assoc(); ?>
                <ul class='nav navbar-nav navbar-right'>
                    <li class='nav-item'>
                        <a class='nav-link font-weight-bold text-white float-right ' href='managerInterface.php?showMyDetailClick=true'><?php echo $row['userName']; ?></a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link font-weight-bold text-warning' href='logOut.php?logout=true'>Log Out</a>
                    </li>
                </ul>
        </div>
    </nav>


    
    <div class="container">
        

        <!-- >>>>>>>>>>>>>>>>USER INFORMATION OF STAFF MEMBERS<<<<<<<<<<<<<<<<<<, -->
        <div>
        <!-- div to show information for all users -->
            <?php
                if(isset($_GET['showAllMember'])): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SR. no.</th>
                            <th scope="col">USER Id</th>
                            <th scope="col">User Name</th>
                            <th scope="col">User Email</th>
                            <th scope="col">User Role</th>
                            <th scope="col">User Approval</th>
                            <th scope="col">User Modification</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $dbObj=new dbConnection();
                    $queryObj=new createDataQuery();
                    $userObj=new userChange();
                    $dbObj->connectDb();
                    $queryObj->selectAllUserQuery();                    
                    $result=userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
                    $dbObj->dissconnectDb();
                    if($result)
                        $srNo=0; ?>
                        <?php
                            while($row=$result->fetch_assoc()):
                                if($_SESSION['userRole']=='manager'): 
                                    if($row['userRole']!='admin'&& $row['userRole']!='manager'):
                                        $srNo+=1; ?>
                                    <!-- all user information for the Manager -->
                                    <tr>
                                        <td><?php echo $srNo;  ?></td>
                                        <td><?php echo $row['userId'];  ?></td>
                                        <td><?php echo $row['userName'];  ?></td>
                                        <td><?php echo $row['userEmail'];  ?></td>
                                        <td><?php echo $row['userRole'];  ?></td>
                                        <td><?php echo $row['valid'];  ?></td>
                                        <td>
                                            <a href="managerInterface.php?editMe=<?php echo $row['userId'];  ?>" > Edit </a>|
                                            <?php if($row['valid']=='yes'): ?>
                                                <a href="managerInterface.php?blockMe=<?php  echo $row['userId'];  ?>" > Block</a>|
                                                <?php else: ?>
                                                    <a href="managerInterface.php?validMe=<?php  echo $row['userId'];  ?>" > Approve</a>|
                                                <?php endif; ?>
                                            <a href='managerInterface.php?deleteMe=<?php echo $row['userId']; ?>' onclick= "return confirmDelete()" > Delete</a>
                                        </td>
                                    </tr>
                                <?php endif;  endif;  ?>
                                <?php if($_SESSION['userRole']=='admin'):
                                    $srNo+=1; ?>
                                    <!-- All user information for the Admin -->
                                    <tr>
                                        <td><?php echo $srNo;  ?></td>
                                        <td><?php echo $row['userId'];  ?></td>
                                        <td><?php echo $row['userName'];  ?></td>
                                        <td><?php echo $row['userEmail'];  ?></td>
                                        <td><?php echo $row['userRole'];  ?></td>
                                        <td><?php echo $row['valid'];  ?></td>
                                        <td>
                                            <a href="managerInterface.php?editMe=<?php echo $row['userId'];  ?>" > Edit </a>|
                                            <?php if($row['valid']=='yes'): ?>
                                                <a href="managerInterface.php?blockMe=<?php  echo $row['userId'];  ?>" > Block</a>|
                                                <?php else: ?>
                                                    <a href="managerInterface.php?validMe=<?php  echo $row['userId'];  ?>" > Approve</a>|
                                                <?php endif; ?>
                                            <a href='managerInterface.php?deleteMe=<?php echo $row['userId']; ?>' onclick= "return confirmDelete()" > Delete</a>
                                        </td>
                                    </tr>
                                    
                            <?php endif; endwhile; ?>
                    </tbody>
                </table>
                <?php endif; ?>
        </div>


        <!-- >>>>>>>>>>>>>>>>>>SECTION FOR CURRENT USER INFORMATION<<<<<<<<<< -->
        <div>
        <!-- This will provide the current user infomation -->
            <?php
                if(isset($_GET['showMyDetailClick'])):
                    $userId=$_SESSION['userId'];
                    $dbObj=new dbConnection();
                    $queryObj=new createDataQuery();
                    $dbObj->connectDb();
                    $queryObj->selectWithCond($userId);
                    $result=userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
                    $row=$result->fetch_assoc();
            ?>
                <div class="card">
                    <h5 class="card-header"><?php echo $row['userName']; ?> Information</h5>
                    <div class="card-body">
                        <h5 class="card-title">Your Email: <?php echo $row['userEmail'] ?></h5>
                        <p class="card-text">Your Role With Our company: <?php echo $row['userRole'] ?></p>
                        <a href="managerInterface.php?editMe=<?php echo $row['userId'];  ?>" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- >>>>>>>>>>>>>>>HOME PAGE SECTION<<<<<<<<<<<<<<<< -->
    <div>
    <!-- Home page of current user Desktop -->
    <?php 
        if(isset($_GET['home'])): 
            include('home.php');
        endif;
        ?>
    </div>
    <!-- >>>>>>>>>>>>><<<<<<<<<<<<<<>EDIT THE INFORMATION OF THE MEMBERS<<>>>>>>>>>>>>>><<<<<<<<<<<<<<> -->
    <div>
    <!-- Div to edit the information of the end users -->
    <?php
        if(isset($_GET['editMe'])):
            $userId=$_GET['editMe'];
            $dbObj=new dbConnection();
            $queryObj=new createDataQuery();
            // $userObj=new userChange();
            $dbObj->connectDb();
            $queryObj->selectWithCond($userId);                    
            $result=mysqli_query($dbObj->con,$queryObj->myQuery);
            $row=$result->fetch_assoc();
            include('edituser.php');
        ?>
            <form action="" method="POST" class="container">
            <div class="form-row">
                    <input type="hidden" class="form-control" id="userId" value="<?php echo $userId ?>" name="userId" placeholder="User Id">
                <div class="form-group col-md-6">
                    <label for="userName">User Name</label>
                    <input type="text" class="form-control" id="userName" name="userName" value="<?php echo $row['userName'] ?>" placeholder="Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="userEmail">Email</label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo $row['userEmail'] ?>" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="userRole">User Role</label>
                    <input type="text" class="form-control" id="userRole" value="<?php echo $row['userRole'] ?>" name="userRole" placeholder="user Role">
                </div>
                <div class="form-group col-md-6">
                    <label for="userValid">Validate User</label>
                    <input type="text" class="form-control" id="userValid" value="<?php echo $row['valid'] ?>" name="userValid" placeholder="user Role">
                </div>
            </div>
            <button type="submit" name="updateInfo" class="btn btn-primary">Update</button>
            </form>

        
        <?php endif; ?>
    </div>
    
    <!-- <<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>STAFF MEMBER USER VALIDATION AND APPROVAL SECTION>>>><<<<<<<<<<<<<<<>>>>>>>>>>>>>>> -->
    <div>
    <!-- Section to improve the user Information -->
        <?php
            if(isset($_GET['validMe'])):
                $userId=$_GET['validMe'];
                $dbObj=new dbConnection();
                $queryObj=new createDataQuery();
                // $userObj=new userChange();
                $dbObj->connectDb();
                $queryObj->validateQuery($userId);
                $result=userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
                $dbObj->dissconnectDb();
                if($result){
                echo "<div class=\"alert alert-success\" role=\"alert\">
                user is approved successfully
                </div>";}else{
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                We are unable to do this task!
                </div>";
                }
            endif;
                if(isset($_GET['blockMe'])):
                    $userId=$_GET['blockMe'];
                    $dbObj=new dbConnection();
                    $queryObj=new createDataQuery();
                    // $userObj=new userChange();
                    $dbObj->connectDb();
                    $queryObj->deValidateQuery($userId);
                    $result=userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
                    $dbObj->dissconnectDb();
                    if($result){
                    echo "<div class=\"alert alert-warning\" role=\"alert\">
                    user is blocked successfully
                    </div>";}else{
                        echo "<div class=\"alert alert-danger\" role=\"alert\">
                    We are unable to do this task!
                    </div>";
                    }
                    endif;
        ?>
    </div>
    
    <!-- >>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<ADD AND DELETE STAFF MEMBER>>>>>>>>>>>>>>>>>>>>>>><>>>>>>>>>>>>>>>>>>>>>>>>>>> -->
    
    <div>
    <!-- section to add and delete any staff member -->
        <div class="container">
        <?php
            if(isset($_GET['addNewUser'])):
                include('addnew.php');
            endif; 
        ?>
        </div>
        <?php
            if(isset($_GET['deleteMe'])):
                $userId=$_GET['deleteMe'];
                $dbObj=new dbConnection();
                $queryObj=new createDataQuery();
                // $userObj=new userChange();
                $dbObj->connectDb();
                $queryObj->deleteQuery($userId);
                $result=userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
                $dbObj->dissconnectDb();
                if($result){
                echo "<div class=\"alert alert-warning\" role=\"alert\">
                user is DELETED successfully!
                </div>";}else{
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                We are unable to do this task!
                </div>";
                }
                endif;
        ?>
    </div>

    <!-- >>>>>>>>>>>CURRENT USER TASKS SECTION<<<<<<<<<<<<<<<<<<<<<<<< -->
    <div>
    <!-- section to show the tasks of the current user -->
    <?php
        if(isset($_GET['myTask'])):
            $userId=$_SESSION['userId'];
            $dbObj=new dbConnection();
            $queryObj=new createTaskQuery();
            $dbObj->connectDb();
            $queryObj->selectTaskWithCond($userId);
            $result=mysqli_query($dbObj->con,$queryObj->myQuery);
            $srNo=0;
            if(mysqli_num_rows($result)>0): 
            ?>
            <div class="container">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Ser. No.</th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Detail</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                while($row=$result->fetch_assoc()):
                    $srNo+=1;
            ?>
                        <tr>
                            <th scope="row"><?php echo $srNo; ?></th>
                            <td><?php echo $row['taskTitle']; ?></td>
                            <td><?php echo $row['taskDisc'] ?></td>
                            <td>
                                <a href="managerInterface.php?editTaskId=<?php echo $row['taskId']; ?>">EDIT</a>|
                                <a href="managerInterface.php?deleteTaskId=<?php echo $row['taskId']; ?>" onclick="return confirmDelete()">Delete</a>
                            </td>
                        </tr>
            <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php else: ?>
                <div class="alert alert-primary" role="alert">
                    Hurray! You have no Pending Task.
                </div>
            <?php endif; ?>
            <div class="container">                    
                <a href="managerInterface.php?addNewTask=<?php echo $userId; ?>" class="btn btn-primary stretched-link" >Add New Task</a>
            </div>      
            <?php endif; ?>
    </div>


    <!-- >>>>>>>>>>Section DIVISION Task of other Users<<<<<<<<<<<< -->
    <div class="container">
        <!-- section to show the information about the other users task -->
        <?php 
            if(isset($_GET['otherUserTask'])):
                $dbObj=new dbConnection();
                $queryObj=new createTaskQuery();
                $dbObj->connectDb();
                $queryObj->selectAllTask($userId);
                $result=mysqli_query($dbObj->con,$queryObj->myQuery);
                $srNo=0;
                if(mysqli_num_rows($result)>0): 
            ?>
                    <div class="container">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Ser. No.</th>
                                    <th scope="col">Task Title</th>
                                    <th scope="col">Task Detail</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                <?php if($_SESSION['userRole']=='admin'):
                        while($row=$result->fetch_assoc()):
                            $srNo+=1;
                    ?>
                            <tr>
                                <th scope="row"><?php echo $srNo; ?></th>
                                <td><?php echo $row['taskTitle']; ?></td>
                                <td><?php echo $row['taskDisc'] ?></td>
                                <td>
                                    <a href="managerInterface.php?editTaskId=<?php echo $row['taskId']; ?>" class="btn btn-info stretched-link">EDIT</a>
                                    <a href="managerInterface.php?deleteTaskId=<?php echo $row['taskId']; ?>" onclick="return confirmDelete()" class="btn btn-danger stretched-link">Delete</a>
                                    <a href="managerInterface.php?addNewTask=<?php echo $userId; ?>" class="btn btn-primary stretched-link" >Add New Task</a>
                                </td>
                            </tr>
                <?php endwhile; endif; ?>
                <?php if($_SESSION['userRole']=='manager'):
                        while($row=$result->fetch_assoc()):
                            $srNo+=1;
                            $dataQueryObj=new createDataQuery();
                            $dataQuery=$dataQueryObj->selectWithCond($row['userId']);
                            $dataResult=userChange::handleAnyQuery($dbObj->con,$dataQueryObj->myQuery);
                            $dataRow=$dataResult->fetch_assoc(); 
                            if($dataRow['userRole']!='admin' && $dataRow['userRole']!='manager'):
                    ?>
                                <tr>
                                    <th scope="row"><?php echo $srNo; ?></th>
                                    <td><?php echo $row['taskTitle']; ?></td>
                                    <td><?php echo $row['taskDisc'] ?></td>
                                    <td>
                                        <a href="managerInterface.php?editTaskId=<?php echo $row['taskId']; ?>" class="btn btn-info stretched-link">EDIT</a>
                                        <a href="managerInterface.php?deleteTaskId=<?php echo $row['taskId']; ?>" onclick="return confirmDelete()" class="btn btn-danger stretched-link">Delete</a>
                                        <a href="managerInterface.php?addNewTask=<?php echo $userId; ?>" class="btn btn-primary stretched-link" >Assign New Task</a>
                                    </td>
                                </tr>
                    <?php endif;
                        endwhile; 
                    endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                    <div class="alert alert-primary" role="alert">
                        Hurray! No Pending Tasks.
                    </div>

        <?php endif; endif; ?>
    </div>


        <!-- >>>>>>>>>>>>>>>>>>>>>>>ADD AND DELETE TASKS<<<<<<<<<<<<<<<<<<<>>>>>>>>>>> -->
    <div class="container">
    <!-- section for handling the task (ADD and DELETE) -->
        <!-- ---------------ADD NEW TASK--------------------------- -->
        <?php
        if(isset($_GET['addNewTask'])):
            $userId=$_GET['addNewTask'];
            include('addNewTask.php');
            ?>
        <?php
            endif; 
        ?>
        <!-- -------------DELETE TASK------------------- -->
        <?php
            if(isset($_GET['deleteTaskId'])):
                $taskId=$_GET['deleteTaskId'];
                $dbObj=new dbConnection();
                $queryObj=new createTaskQuery();
                // $userObj=new userChange();
                $dbObj->connectDb();
                $queryObj->deleteTask($taskId);
                $result=userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
                $dbObj->dissconnectDb();
                if($result){
                echo "<div class=\"alert alert-warning\" role=\"alert\">
                Task is DELETED successfully!
                </div>";}else{
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                We are unable to do this task!
                </div>";
                }
                endif;
        ?>
    </div>

    <!-- >>>>>>>>>>>>>EDIT TASK<<<<<<<<<<<< -->
    <div class="container">
        <?php            
            if(isset($_GET['editTaskId'])):
                $taskId=$_GET['editTaskId'];
                $queryObj=new createTaskQuery();
                $dbObj=new dbConnection();
                $dbObj->connectDb();
                $queryObj->selectTaskWithCond($taskId);
                $result=mysqli_query($dbObj->con,$queryObj->myQuery);
                $row=$result->fetch_assoc();
                include('editTask.php');
        ?>
        <div>
        <form action="" method="POST" class="container">
            <div class="form-row">
                    <input type="hidden" class="form-control" id="taskId" value="<?php echo $taskId ?>" name="taskId" placeholder="Task Id">
                <div class="form-group col-md-6">
                    <label for="taskTitleEdit">Task Title</label>
                    <input type="text" class="form-control" id="taskTitleEdit" name="taskTitleEdit" value="<?php echo $row['taskTitle'] ?>" placeholder="Title">
                </div>
                <div class="form-group col-md-6">
                    <label for="taskDiscEdit">Task Detail</label>
                    <input type="text" class="form-control" id="taskDiscEdit" name="taskDiscEdit" value="<?php echo $row['taskDisc'] ?>" placeholder="Description">
                </div>
            <button type="submit" name="updateTask" class="btn btn-primary">Update</button>
            </form>
        </div>
        <?php endif; ?>
    </div>



    <!-- <<<<<<<<<<<<<<<< JAVASCRIPT PART >>>>>>>>>>>>>>>>>>>>>>>>>>  -->
    <script>
        function confirmDelete(){
            // window.location='editUser.php';
            return confirm("Are You Sure You want to delete!");
            // console.log(Id)
            // if(!res){
            //     window.location.href=`managerInterface.php?deleteMe=${Id}`;
            // }else{
            //     window.location='managerInterface.php?showAllMember=true';
            // }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>