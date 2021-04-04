<?php
    include('db.php');
    include('userHandlerClasses.php');
    
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Admin LogIn</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#registrationForm').hide();
        $('#registerQueryClick').click(function(){
            $('#loginForm').hide();
            $('#registrationForm').show();
        });
        $('#LoginQueryClick').click(function(){
            $('#registrationForm').hide();
            $('#loginForm').show();
        });
    });
    </script>
    <script>
    onload(click,)
    </script>
</head>

<body class="bg-dark">
    <div class="container bg-dark">
        <div class="jumbotron bg-success">
            <h3>This website is a demo website to learn PHP and to make user management system.</h3>
        </div>
        <div class="row" id="loginForm">
            <div class="col card" style="width: 18rem;">
                <span class="text-weight-bold">You Can Login Here.</span>
                <?php
                    if(isset($_POST['loginClick'])){
                        $loginEmail=$_POST['loginEmail'];
                        $loginPassword=$_POST['loginPassword'];
                        $loginPassword=sha1($loginPassword);
                        $dbObj=new dbConnection();
                        $queryObj = new createDataQuery();
                        $memberObj = new handleUsers();
                        // var_dump($dbObj);
                        $dbObj->connectDb();
                        $queryObj = new createDataQuery();                        
                        $queryObj->fetchWithEmail($loginEmail);
                        $table=mysqli_query($dbObj->con,$queryObj->myQuery);
                        if($table){
                            list($valid,$resultvalue)=$memberObj->loginUser($table,$loginEmail,$loginPassword);
                            // var_dump($valid);
                            // var_dump($value);
                            if($valid){
                                header($resultvalue);
                            }else{
                                echo "
                                    <div class='alert alert-danger' role='alert'>
                                    $resultvalue
                                    </div>";
                            }
                        }elseif($table){
                            var_dump($table);
                            echo "
                                    <div class='alert alert-danger' role='alert'>
                                    Wrong Credentials
                                    </div>";
                        }
                        
                    }
                ?>
                <form action="" method="POST" class="form" >
                    <div class="form-group">
                        <input type="text" name="loginEmail" id="loginEmail" class="form-control" placeholder="Enter Your Email" required> 
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="loginPassword" id="loginPassword" placeholder="Enter Your Password" required>
                    </div>
                    <div class="form-group">
                        <button id="loginClick" name="loginClick" class="btn btn-primary">LogIN</button>
                    </div>
                </form>
                </br>
                <p>
                    <b>Note:</b> If You are not registered please register Yourself.
                    <button class="btn btn-primary" id="registerQueryClick" >Click to Register</button>
                </p>
            </div>
        </div>
    </div>
    <div class="container"  id="registrationForm">
        
        <div class="col card mt-3" >
            <div>You Can Register with us.</div>
            <form action="" method="POST" class="form" >
                <div class="form-group">
                    <input type="text" name="registrationName" id="registrationName" class="form-control" placeholder="Enter Your Name" required> 
                </div>
                <div class="form-group">
                    <input type="text" name="registrationEmail" id="registrationEmail" class="form-control" placeholder="Enter Your Email" required> 
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="registrationPassword" id="registrationPassword" placeholder="Enter Your Password" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="registrationRole" id="registrationRole" placeholder="Enter Your Role" required>
                </div>
                <div class="form-group">
                    <button id="registrationClick" name="registrationClick" class="btn btn-primary">Register</button>
                    
                </div>
            </form>
            </br>
                <p>
                    <button class="btn btn-primary" id="LoginQueryClick" onclick="register()">Click to Login</button>
                </p>
        </div>
    </div>
    
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