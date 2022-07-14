<html>
    <body>
        <?php
        $username = $_POST['username'];
        $password = $_POST['password'];
        $exist = 0;
        
        //read the file line by line
        $file = fopen("http://titan.csit.rmit.edu.au/~s3715210/assignment/database/database.txt","r");
        while(!feof($file))  {
            // get a line without the last ¡°newline¡± character
            $line = trim(fgets($file));
            //compare the content of the input and the line
            list($a, $b) = array_pad(explode(",", $line),2,null);
            if($a == $username ){
                $exist = 1;
                break;
            }
        }
        fclose($file);
        
        if($exist == 1){
		echo "The user is exist! <br/>GO <a href= 'http://titan.csit.rmit.edu.au/~s3715210/assignment/client/register.html'>back </a> to register, login or check the database.txt";
        }else{
            $file = fopen("../database/database.txt","a");
            fwrite($file,$username.','.$password);
            fwrite($file,"\n");
            fclose($file);
            echo "The user has been added to the database.txt. <br/> Go  <a href='http://titan.csit.rmit.edu.au/~s3715210/assignment/client/index.html'>back</a> to register, login or check the database.txt";
        }?>
    </body>
</html>