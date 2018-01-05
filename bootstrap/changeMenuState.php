<?php
echo 'start at'.date('Y-m-d H:i:s');

$pdo = new PDO('mysql:host=localhost;dbname=db_mos', 'db_mos', 'I1YRfSE0bGybgKa');
//$pdo = new PDO('mysql:host=localhost;dbname=db_mos', 'root', '123456');

$sql = "update menus set mweek = ? where mweek = ?;";
$preObj = $pdo->prepare($sql);
$res    = $preObj->execute(array(3, 2));
$res    = $preObj->execute(array(2, 1));
$res    = $preObj->execute(array(1, 3));

echo 'end at'.date('Y-m-d H:i:s');