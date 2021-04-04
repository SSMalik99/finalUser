<?php
    // session_start();
    // if($_SESSION['userId']):
    // include('db.php'); #this will include the data of the Database and queries;
    // include('userHandlerClasses.php');
    
    if(isset($_POST['updateInfo'])){
        $userID=$_POST['userId'];
        $userName=$_POST['userName'];
        $userEmail=$_POST['userEmail'];
        $userRole=$_POST['userRole'];
        $userValid=$_POST['userValid'];
        $userValid=strtolower($userValid);
        if($_SESSION['userRole']=='manager'){
            if($userRole!='admin' && $userRole!="manager"):
                $dbObj=new dbConnection();
                $dbObj->connectDb();
                $queryObj=new createDataQuery();
                $queryObj->updateInfoQuery($userID,$userName,$userEmail,$userRole,$userValid);
                // $userObj=new userChange();
                $result=mysqli_query($dbObj->con,$queryObj->myQuery);
                $dbObj->dissconnectDb();
                // var_dump($result);
                if($result){
                    echo "<div class=\"alert alert-success\" role=\"alert\">
                    User is updated successfully
                </div>";
                // header("Location:managerInterface.php?editMe=$userID");
                }else{
                    echo "<div class=\"alert alert-success\" role=\"alert\">
                    Sorry! but currently we are not able to do this task!
                </div>";
                // header("Location:managerInterface.php?editMe=$userID");
                }
            endif;
        }else if($_SESSION['userRole']=='admin'){
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createDataQuery();
            $queryObj->updateInfoQuery($userId,$userName,$userEmail,$userRole,$userValid);
            $result=mysqli_query($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
            if($result){
                echo "<div class=\"alert alert-success\" role=\"alert\">
                User is updated successfully
            </div>";
            }else{
                echo "<div class=\"alert alert-success\" role=\"alert\">
                Sorry! but currently we are not able to do this task!
            </div>";
            }
        }
    }
    // else
    //     header("Location:admin.php");
// endif;
?>
