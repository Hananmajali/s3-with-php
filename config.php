<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'sql3.freesqldatabase.com');
define('DB_USERNAME', 'sql3204811');
define('DB_PASSWORD', 'VanxmAjTW6');
define('DB_NAME', 'sql3204811');

 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// $sql="CREATE TABLE users (
//     id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
//     username VARCHAR(50) NOT NULL UNIQUE,
//     password VARCHAR(255) NOT NULL,
//     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
// )"
// mysqli_select_db('sql3204811');
// $retval = mysql_query( $sql, $link );

// if(! $retval ) {
//          die('Could not create table: ' . mysqli_connect_error());
//          }
//          echo "Table created successfully\n";
         
//          mysql_close($link);

?>