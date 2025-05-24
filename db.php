 <?php
  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "laced_lifestyle";

    $con = mysqli_connect($servername , $username, $password , $dbname);

    if(!$con){
        echo "Db connection error..." . mysqli_connect_error();
    }


          
?>