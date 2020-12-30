<?php

$name = $_POST['docname'];
$stardate = (string)$_POST['startdate'];
$enddate = (string)$_POST['enddate'];
//$flag =


// ファイルが存在しているかチェックする
if (($handle = fopen("data/docmanagementdata.csv", "a")) !== FALSE) {

    // 入力内容を追記する
    fwrite($handle, $name.",".$stardate.",".$enddate.","."\n");

    //　ファイルを閉じる
    fclose($handle);

    //　入力画面にリダイレクトする
    header('Location: document.php', true, 307);

}
?>