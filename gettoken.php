<?php
require_once('./include/config.php');
require_once('./include/main.php');
require_once('./include/addlog.php');
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
if (!$conn){
    $re['code'] = -1;
    $re['msg'] = '数据库连接失败,请检查目录下./include/config.php是否已配置';
	die(json_encode($re));
}
/*if($_POST['version'] == "2.0.0"){

}
*/
$stmt = $conn->prepare('SELECT `token` FROM `user` WHERE `qq` = :qq AND `version` = :version AND `sysInfo` = :sysInfo');
$stmt->bindValue(':version', $_POST['version']);
$stmt->bindValue(':qq', $_POST['qq']);
$stmt->bindValue(':sysInfo', $_POST['sysInfo']);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

if (count($result) == 1){
    $re['code'] = 1;//已存在记录
    $re['token'] = $result[0];
	die(json_encode($re));
}else{
    $re['code'] = 2;//生成并返回一个token
    $re['token'] = getToken(getClientIP(0, false), $_POST['sysInfo'], $_POST['qq'], $_POST['version']);

    $into = $conn->prepare('INSERT INTO user (`qq`,`token`,`inTime`,`version`,`sysInfo`,`regIP`) VALUE (:qq,:token,:inTime,:version,:sysInfo,:regIP)');
    $into->bindValue(':qq', $_POST['qq']);
    $into->bindValue(':token', $re['token']);
    $into->bindValue(':inTime', time());
    $into->bindValue(':version', $_POST['version']);
    $into->bindValue(':sysInfo', $_POST['sysInfo']);
    $into->bindValue(':regIP', getClientIP(0, false));
    $into->execute();
    $into->closeCursor();
    die(json_encode($re));
}

?>