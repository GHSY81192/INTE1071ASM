<?php
session_start();
if(!isset($_SESSION['login'])){
    header('Location: login.html');
}
include('../server/rsa.php');
include('../server/des.php');
?>
<!DOCTYPE html>
<html lang='en'>
    <BODY>
        <style type="text/css">
            body{
                padding: 2%;
                margin: 2%;
            }
            
            h1{
                font-family:arial;
                color:black;
                font-size:20px;
            }
            
            th{
                background-color: chartreuse;
                font-size: 18px;
            }
            
            table, input{
                border-collapse: collapse;
                text-align: center;
            }
            
            th, td,tr{
                width: 300px;
                height: 100px;
            }
        </style>
        <h1>Shopping Cart</h1>
        <!-- <button type="submit">Logout</button> -->
        <br>
        <table border="1">
            <tr>
                <th>Products</th>
                <th>Price (Sliver Eagle)</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            
            <tr>
                <td>Leclerc</td>
                <td>390,000</td>
                <td><?php echo $_POST['Leclerc'];?></td>
                <td><?php echo $_POST['Leclerc']*390000;?></td>
            </tr>
            
            <tr>
                <td>Leopard 2A5</td>
                <td>390,000</td>
                <td><?php echo $_POST['Leopard2A5'];?></td>
                <td><?php echo $_POST['Leopard2A5']*390000;?></td>
            </tr>
            
            <tr>
                <td>CM11</td>
                <td>250,000</td>
                <td><?php echo $_POST['CM11'];?></td>
                <td><?php echo $_POST['CM11']*250000;?></td>
            </tr>
            
            <tr>
                <td>M1A1</td>
                <td>390,000</td>
                <td><?php echo $_POST['M1'];?></td>
                <td><?php echo $_POST['CM11']*390000;?></td>
            </tr>
            
            <tr>
                <td>T80U</td>
                <td>390,000</td>
                <td><?php echo $_POST['T80U'];?></td>
                <td><?php echo $_POST['CM11']*390000;?></td>
            </tr>
            
            <tr>
                <td>Type90</td>
                <td>390,000</td>
                <td><?php echo $_POST['Type90'];?></td>
                <td><?php echo $_POST['CM11']*390000;?></td>
            </tr>
            
            <tr>
                <th>           </th>
                <th>Total</th>
                <th><?php echo $_POST['Leclerc']+$_POST['Leopard2A5']+$_POST['CM11']+$_POST['M1']+$_POST['T80U']+$_POST['Type90'];?></th>
                <th><?php echo $_POST['Leclerc']*390000+$_POST['Leopard2A5']*390000+$_POST['CM11']*250000+$_POST['M1']*390000+$_POST['T80U']*390000+$_POST['Type90']*390000;?></th>
            </tr>
        </table>
        
        <form action="logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>

        <?php
        $CCN = $_POST['CCN'];
        $DES_Encryption_Key = $_POST['DES_Encryption_Key'];
        echo "Received encrypted Message: " . $CCN . "<br/>";
        echo "Pre-set decryption key: " . $DES_Encryption_Key. "<br/>";
        $privateKey = get_rsa_privatekey('../server/private.key');
        $decrypted = rsa_decryption($DES_Encryption_Key, $privateKey);
        echo 'Recovered plaintext key: ' . $decrypted . "<br/>";
        $recovered_message = php_des_decryption($decrypted, $CCN);
        echo "Recovered plaintext message: " . $recovered_message . "<br/>". "<br/>";
        
        $Leclerc=$_POST['Leclerc'];
        $Leopard2A5=$_POST['Leopard2A5'];
        $CM11=$_POST['CM11'];
        $M1=$_POST['M1'];
        $T80U=$_POST['T80U'];
        $Type90=$_POST['Type90'];
        
        $SubtotalLeclerc = $_POST['Leclerc']*390000;
        $SubtotalLeopard2A5 = $_POST['Leopard2A5']*390000;
        $SubtotalCM11 = $_POST['CM11']*250000;
        $SubtotalM1 = $_POST['M1']*390000;
        $SubtotalT80U = $_POST['T80U']*390000;
        $SubtotalType90 = $_POST['Type90']*390000;
        $Subtotal=$SubtotalLeclerc+$SubtotalLeopard2A5+$SubtotalCM11+$SubtotalT80U+$SubtotalType90+$SubtotalM1;
        
        $item1="Leclerc, 390000 ";
        $item2="Leopard2A5, 390000 ";
        $item3="CM11, 250000 ";
        $item4="M1, 390000 ";
        $item5="T80U, 390000 ";
        $item6="Type90, 390000 ";
        $item7="Key: ";
        $item8="Credit Card Number: ";
        $item9="Full Price: ";
        $item10="-------------------------------------";
        
        $file = fopen("../database/order.txt","a");
        fwrite($file,$item1.$Leclerc.' '.$SubtotalLeclerc."\r\n");
        fwrite($file,$item2.$Leopard2A5.' '.$SubtotalLeopard2A5."\r\n");
        fwrite($file,$item3.$CM11.' '.$SubtotalCM11."\r\n");
        fwrite($file,$item4.$M1.' '.$SubtotalM1."\r\n");
        fwrite($file,$item5.$T80U.' '.$SubtotalT80U."\r\n");
        fwrite($file,$item6.$Type90.' '.$SubtotalType90."\r\n");
        fwrite($file,$item9.$Subtotal."\r\n");
        fwrite($file,$item7.$decrypted."\r\n");
        fwrite($file,$item8.$recovered_message."\r\n");
        fwrite($file,$item10."\r\n");
        fwrite($file,"\n");
        fclose($file);
        
        echo "This order has been added to the database. <br/> Go  <a href='http://titan.csit.rmit.edu.au/~s3715210/assignment/client/index.html'>back</a> to check the order.txt";
        ?>
    </BODY>
</html>