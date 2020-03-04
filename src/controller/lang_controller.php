<?php

require_once dirname(__FILE__).'/../common/path.php';
require_once $rootpath.'/src/common/db.php';

$pageName = $_POST['pageName'];
$lang = $_POST['lang'];

session_start();
$_SESSION['lang'] = $lang;
//连接数据库
$con = DbOpen();
$sql = '
  SELECT XU_HAO,WEN_ZI FROM txl_yuyan WHERE
  YE_MIAN_MING = ? AND
  YU_ZHONG = ?
  order by XU_HAO
';

$stmt = $con->prepare($sql);
$stmt->bind_param('ss', $pageName, $lang);
$stmt->execute();
$result = $stmt->get_result();

$response = [];
$i = 0;

while ($row = $result->fetch_assoc()) {
    $response[$i] = [
        'XuHao' => $row['XU_HAO'],
        'WenZi' => $row['WEN_ZI'],
    ];

    $i++;
}

echo json_encode($response);

$stmt->close();
DbClose($con);
