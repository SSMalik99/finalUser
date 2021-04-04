<?php
    if(isset($_POST['addUser'])){
        $usrName=$_POST['newUserName'];
        $usrEmail=$_POST['newUserEmail'];
        $usrRole=$_POST['newUserRole'];
        $usrPassword=$_POST['newUserPassword'];
        $usrPassword=sha1('$usrPassword');
        $usrValid=$_POST['newUserValid'];
        $usrValid=strtolower($usrValid);
        if($_SESSION['userRole']=='manager'){
            if($usrRole!='admin' && $usrRole!="manager"){
                $dbObj=new dbConnection();
                $dbObj->connectDb();
                $queryObj=new createDataQuery();
                $queryObj->addUserQuery($usrName,$usrEmail,$usrRole,$usrPassword,$usrValid);
                $userObj=new userChange();
                $userObj->handleAnyQuery($dbObj->con,$queryObj->myQuery);
                $dbObj->dissconnectDb();
                echo "<div class=\"alert alert-success\" role=\"alert\">
                    User is added successfully
                </div>";
            }else{
                echo "<div class=\"alert alert-danger\" role=\"alert\">
                You are not allowed to add $usrRole
            </div>";
            }
        }else if($_SESSION['userRole']=='admin'){
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createDataQuery();
            $queryObj->addUserQuery($usrName,$usrEmail,$usrRole,$usrPassword,$usrValid);
            $userObj=new userChange();
            $userObj->handleAnyQuery($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
            echo "<div class=\"alert alert-success\" role=\"alert\">
                    User is added successfully
                </div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<form action="" method="POST">
    <label >Enter User Name</label>
    <input type="text" class="form-control" name="newUserName" placeholder="Enter Name for new user" required>
    <label >Enter User Email</label>
    <input type="text"  name="newUserEmail" class="form-control" placeholder="enter email for new user" required>
    <label >Enter Role for the User</label>
    <input type="text" class="form-control" name="newUserRole" placeholder="enter role for new user" required>
    <label >Enter Password</label>
    <input type="text"  name="newUserPassword" class="form-control" placeholder="enter password for new user" required>
    <label >Validate User</label>
    <input type="text"  name="newUserValid" class="form-control" placeholder="yes/no">
    <button  class="btn btn-primary" name="addUser">Add User</button>
</form>
</body>
</html>