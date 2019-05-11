<?php
$ret['code'] = 1;
$ret['data'] = file_get_contents('history/' . $_POST['name'] . '.data');
echo json_encode($ret);
?>