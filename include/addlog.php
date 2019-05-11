<?php
require_once('config.php');
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
if ($conn){
    if ($conn){
        $into = $conn->prepare('INSERT INTO `log` (`qq`,`time`,`version`,`reqName`,`ip`) VALUE (:qq,:time,:version,:reqName,:ip)');
        $into->bindValue(':qq', $_POST['qq']);
        $into->bindValue(':time', time());
        $into->bindValue(':version', $_POST['version']);
        $into->bindValue(':reqName', $_SERVER['PHP_SELF']);
        $into->bindValue(':ip', getClientIP(0, false));
        $into->execute();
        $into->closeCursor();
    }
}
?>