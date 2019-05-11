<?php
require './include/config.php';
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
if (!$conn){
    print_r('数据库连接失败,请检查目录下./include/config.php是否已配置');
    die(json_encode($re));
}
$result = $conn->query("SHOW TABLES LIKE 'user'");
$row = $result->fetchAll();
$result->closeCursor();
if ('1' != count($row)){
  $sql = "CREATE TABLE `$dbname`.`user` (
    `id` int(0) NOT NULL AUTO_INCREMENT,
    `qq` bigint(255) UNSIGNED NULL,
    `token` char(64) NULL,
    `inTime` bigint(10) UNSIGNED NULL,
    `endTime` bigint(10) UNSIGNED NULL,
    `version` char(16) NULL,
    `sysInfo` varchar(1024) NULL,
    `regIP` varchar(15) NULL,
    PRIMARY KEY (`id`)
  );";
$conn->exec($sql);
}
$result = $conn->query("SHOW TABLES LIKE 'log'");
$row = $result->fetchAll();
$result->closeCursor();
if ('1' != count($row)){
  $sql = "CREATE TABLE `$dbname`.`log`  (
    `id` int(0) NOT NULL AUTO_INCREMENT,
    `qq` bigint(255) NULL,
    `version` varchar(16) NULL,
    `reqName` varchar(255) NULL,
    `ip` varchar(15) NULL,
    `time` bigint(10) UNSIGNED NULL,
    PRIMARY KEY (`id`)
  );";
$conn->exec($sql);
}


?>