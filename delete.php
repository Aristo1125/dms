<?php


$delflag = $_POST['flagchk'];

$row = 1;

// ファイルが存在しているかチェックする
if(($handle = fopen("data/docmanagementdata.csv", "r")) !== FALSE)

    //　現在のCSVデータを$record変数に格納する
    while($dataList = fgetcsv($handle)) {
        $record[] = $dataList; 
    }

    // ファイルをクローズする
    fclose($handle);

for($i = 0; $i < count($delflag); $i++) {
    echo count($delflag);
    echo '<br>';

    echo $delflag[$i];
    echo '<br>';
    $record[$delflag[$i] -1 ][3] = "1"; 
}


// ファイルが存在しているかチェックする
if (($handle = fopen("data/docmanagementdata.csv", "w")) !== FALSE) {
    
    foreach ($record as $data) {
        fputcsv($handle, $data);
    }
        
}

    //　ファイルを閉じる
    fclose($handle);

    //　入力画面にリダイレクトする
    header('Location: document.php', true, 307);

?>