<?php
session_start();
?>
<html>
    <body>
        <?php
        $username = $_POST['username'];
        $password = $_POST['password'];
        $exist = 0;
        
        $file = fopen("http://titan.csit.rmit.edu.au/~s3715210/assignment/database/database.txt","r");
        while(!feof($file)){
            $line = trim(fgets($file));
            list($a, $b) = array_pad(explode(",", $line),2,null);
            if($a == $username && $b==$password){
			$exist = 1;
			break;
            }else if(empty($username)){
                $exist=2;
                break;
            }else if(empty($password)){
                $exist=3;
                break;
            }
        }
        fclose($file);
        
        if($exist == 1){
            echo "Your Login is Successful!";
            $_SESSION['login'] = "YES";
            header('Location: http://titan.csit.rmit.edu.au/~s3715210/assignment/client/shoppingcart.html');
        }else if($exist == 2){
            echo "Your username cannot be empty.<br/>GO <a href= 'http://titan.csit.rmit.edu.au/~s3715210/assignment/client/login.html'>back </a> to login";
        }else if($exist == 3){
            echo "Your password can not be empty.<br/>GO <a href= 'http://titan.csit.rmit.edu.au/~s3715210/assignment/client/login.html'>back </a> to login";
        }else{
            echo "Your username or password is not correct.<br/>GO <a href= 'http://titan.csit.rmit.edu.au/~s3715210/assignment/client/login.html'>back </a> to login";
        }