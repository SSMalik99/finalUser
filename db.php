<?php
    class dbConnection{
        private $serverName="localhost";  #  this is hostName
        private $userName="root";    # this the user name for the database
        private $userPass="";    #this is the password for the user database  
        private $dbName="usermanagement";    #this is the official name of our database
        public $con = FALSE;
        #this method will try to connect database for the different purposes;
        public function connectDb(){
            try{
                $this->con = mysqli_connect($this->serverName,$this->userName,$this->userPass,$this->dbName);
                // echo "i'm established";
                return $this->con;
            }
            catch(mysqli_sql_exception $error){
                throw $error;
            }
        }
        # this will dissconnect database 
        public function dissconnectDb(){
            $this->con = NULL;
            // echo "i'm disconnected";
            return $this->con;
        }
    }
    class createDataQuery{#this class will generate queries for the different tasks;
        public $myQuery;
        private $tableName = 'workmate';
        //this method will add new user into our database
        public function addUserQuery($name,$email,$role,$password,$valid){
            $this->myQuery="INSERT INTO `$this->tableName` (`userName`, `userEmail`, `userRole`, `userPassword`,`valid`) VALUES ('$name', '$email','$role','$password','$valid');";
            return $this->myQuery;
        }
        //This will select all the User fot the Admin
        public function selectAllUserQuery(){
            $this->myQuery="SELECT * FROM $this->tableName";
            return $this->myQuery;
        }
        #select any user on the basis of userId
        public function selectWithCond($condition){
            $this->myQuery="SELECT * FROM $this->tableName WHERE userId=$condition";
            return $this->myQuery;
        }
        public function fetchWithEmail($condition){
            $this->myQuery="SELECT * FROM `$this->tableName` WHERE userEmail='$condition'";
            return $this->myQuery;
        }
        #this method will help end user and admin to change the info the users;
        public function updateInfoQuery($userId,$name,$email,$userRole,$valid){
            $this->myQuery= "UPDATE `usermanagement`.`workmate` SET `userName`='$name', `userEmail`='$email', `userRole`='$userRole', `valid`='$valid' WHERE  `userId`=$userId;";
            return $this->myQuery;
        }
        #this method will help tp change the password of the users;
        public function updatePassword($userId,$userPassword){
            $this->myQuery="UPDATE `$this->tableName` SET `userPassword` = '$userPassword' WHERE `workmate`.`userId` = $userId;";
        }
        #this will delete an end user from the database
        public function deleteQuery($userId){
            $this->myQuery="DELETE FROM $this->tableName WHERE $this->tableName.`userId`=$userId";
            return $this->myQuery;
        }
        #this method will validate the user
        public function validateQuery($userId){
            $this->myQuery="UPDATE `$this->tableName` SET `valid`='yes' WHERE  `userId`=$userId;";
            return $this->myQuery;
        }
        #this auery can be used to block the user login 
        public function deValidateQuery($userId){
            $this->myQuery="UPDATE `$this->tableName` SET `valid`='no' WHERE  `userId`=$userId;";
            return $this->myQuery;
        }
    }
    class createTaskQuery{
        public $myQuery;
        private $tableName = 'usertask';
        //this method will add new user into our database
        public function addTaskQuery($userId,$taskTitle,$taskDisc){
            $this->myQuery="INSERT INTO `$this->tableName` (`userId`, `taskTitle`, `taskDisc`) VALUES ('$userId', '$taskTitle', '$taskDisc');";
            echo "i'm working Buddy";
            return $this->myQuery;
        }
        //This will select all the User fot the Admin
        public function selectAllTask(){
            $this->myQuery="SELECT * FROM $this->tableName";
            return $this->myQuery;
        }
        #select any user on the basis of userId
        public function selectTaskWithCond($condition){
            $this->myQuery="SELECT * FROM $this->tableName WHERE userId=$condition";
            return $this->myQuery;
        }
        #this method will help end user and admin to change the info the users;
        public function updateTask($taskId,$taskTitle,$taskDisc){
            $this->myQuery= "UPDATE `usermanagement`.`$this->tableName` SET `taskTitle`='$taskTitle', `taskDisc`='$taskDisc' WHERE  `userId`=$taskId;";
            return $this->myQuery;
        }
        #this will delete an end user from the database
        public function deleteTask($taskId){
            $this->myQuery="DELETE FROM $this->tableName WHERE $this->tableName.`taskId`=$taskId";
            return $this->myQuery;
        }
        
    }
    // echo "<h3>Hey buddy!,,,I'm from database connectivity page and this page is working perfectluy.</h3>"
?>