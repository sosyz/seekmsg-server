<?php
require_once('./include/config.php');
require_once('./include/main.php');
require_once('./include/addlog.php');
$data = '<!DOCTYPE html>
<html>

<head>
    <title>';
$data .= $_POST['group'];
$data .= '</title>
    <link rel="stylesheet" type="text/css" href="https://cdn1.sonui.cn/css/chat/litewebchat.min.css" />
    <link href="https://fonts.font.im/css?family=Roboto:500" rel="stylesheet" type="text/css">
    <script src="https://cdn1.sonui.cn/js/aes.js"></script>
    <script src="./js/data.js"></script>
    <meta name="referrer" content="no-referrer" />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        charset="UTF-8">
</head>

<body>
    <div id="msgList" class="lite-chatbox" data="';
$data .= $_POST['data'];
$data .='">

</div>
</div>

</body>

</html>';
$fileName = md5($_POST['data']);
$fileName = md5(md5('2e869651fb427a0' . $fileName)) . ".html";
file_put_contents('history/' . $fileName, $data);
$ret['code'] = 1;//成功
$ret['name'] = '/' . $fileName;
echo json_encode($ret);
?>