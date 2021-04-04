<?php
    include('db.php'); #this will include the data of the Database and queries;
    include('userHandlerClasses.php');
    session_start();  #this will start the session
    if($_SESSION['userRole']){
        if (isset($_GET['logout'])) {
            session_destroy();
            // echo '<script>alert("You clicked me! Now i\'m logging you out")</script>';
            header("Location:admin.php");
        }
    }
?>