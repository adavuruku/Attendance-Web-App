<?php

$host = 'localhost';
$dbname = 'atbu_attendance';
$username = 'root';
$password = '';

try
    {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      //  echo "Connected to $dbname at $host successfully.";
        return ($conn);
       // $conn = null;
    }
catch (PDOException $e)
    {
        die("Could not connect to the database $dbname :" . $e->getMessage());
        $conn = null;
    }
?>
