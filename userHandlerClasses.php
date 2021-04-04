<?php
    #this file of php contain all the classes require for the change inside the user intefaces.

    # Class to handle the changes made bu the admin;
    class userChange{
        public static function handleAnyQuery($con,$query){
            $result=mysqli_query($con,$query);
            return $result;
        }
        public $makeChange;
        public function allowToChange($con,$query){
            $table=mysqli_query($con,$query);
            $row=$table->fetch_assoc();
            if($row['userRole']!="admin" && $row['userRole']!="manager"){
                $this->makeChange=TRUE;
                return $this->makeChange;
            }else{
                $this->makeChange=FALSE;
                return $this->makeChange;
            }
        }
    }
    //handle website membes log in
    class handleUsers{
        
        public function loginUser($table,$email,$password){
            // $table=mysqli_query($con,$query);
            // echo "aaaaaaaaaaaaaaaa!";
            if($table){
                $result='Wrong Credentials';
                // echo "bbbbbbbbbbb!";
                $valid=FALSE;
                session_start();
                while($row=$table->fetch_assoc()){
                    // echo "cccccccccccc";
                    if($row['userEmail']==$email){
                        if($row['userRole']=="admin"){
                            if($row['userPassword']==$password){
                                $_SESSION['userRole']=$row['userRole'];
                                $_SESSION['userId']=$row['userId'];
                                // echo '<script>alert("You are logged in")</script>';
                                // header("Location:adminInterface.php");
                                $result="Location:managerInterface.php?home=true";
                                $valid=TRUE;
                                
                                // return $this->result;
                            }else{
                                // echo '<script>alert("please enter a valid password!")</script>';
                                $result="Please Enter a Valid Password";
                                $valid=FALSE;
                                // return array($valid,$result);
                                // return $this->result;
                            }
                        }elseif($row['userRole']=="manager"){
                            if($row['userPassword']==$password){
                                if($row['valid']=="yes"){
                                    $_SESSION['userRole']=$row['userRole'];
                                    $_SESSION['userId']=$row['userId'];
                                    // echo '<script>alert("You are logged in")</script>';
                                    // header("Location:managerInterface.php");
                                    // array_push($result,"Location:managerInterface.php",1);
                                    $result="Location:managerInterface.php?home=true";
                                    $valid=TRUE;
                                    // return array($valid,$result);
                                    // return $this->result;
                                }else{
                                    // echo '<script>alert("Your account is not approved!please wait until it is not approved.")</script>';
                                    $result = "Your account is not approved!";
                                    $valid=FALSE;
                                    // return array($valid,$result);
                                    // return $this->result;
                                }
                            }else{
                                // echo '<script>alert("please enter a valid password!")</script>';
                                // return ('Please Enter a Valid Password');
                                // array_push($result,"Please Enter a Valid Password",0);
                                $result="Please Enter a Valid Password";
                                $valid=FALSE;
                                // return array($valid,$result);
                                // return $this->result;
                            }
                        }elseif($row['userRole']!="admin" && $row['userRole']!="manager"){
                            // $row['userPassword']=sha1($row['userPassword']);
                            if($row['userPassword']==$password){
                                if($row['valid']=="yes"){
                                    $_SESSION['userId']=$row['userId'];
                                    $_SESSION['userRole']=$row['userRole'];
                                    // echo '<script>alert("You are logged in")</script>';
                                    // header("Location:staffInterface.php");
                                    $result="Location:staffInterface.php?home=true";
                                    $valid=TRUE;
                                    // return array($valid,$result);
                                    // array_push($result,"Location:staffInterface.php",1);
                                    // return $this->result;
                                }else{
                                    // echo '<script>alert("You are not approved yet!")</script>';
                                    // array_push($result,"Your account is not approved!",0);
                                    $result = "Your account is not approved!";
                                    $valid=FALSE;
                                    // return array($valid,$result);
                                    // return $this->result;
                                }
                            }else{
                                $result="Please Enter a Valid Password";
                                $valid=FALSE;
                            }
                        }
                    }
                }
                return array($valid,$result);
            }
        }
    }
    // echo 'allclasses is working perfectly'
?>
