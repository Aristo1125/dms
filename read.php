<?php


echo '<head>';
//echo '<link href="style.css" rel="stylesheet" type="text/css">';
echo '<script type="text/javascript" src="javascript.js"></script>';
echo '<title>test3</title>';
echo '</head>';



$row = 0;
// ファイルが存在しているかチェックする
if (($handle = fopen("data/docmanagementdata.csv", "r")) !== FALSE) {

    // 1行ずつfgetcsv()関数を使って読み込む
    echo '<table>';
    echo '<tr>';
    echo '<th>名称</th>';
    echo '<th>開始日</th>';
    echo '<th>終了日</th>';
    echo '<th>削除</th>';
    echo '</tr>';
    while (($data = fgetcsv($handle))) {
        //echo "${row}行目\n";
        //echo $data[3];

        $row++;
        echo '<tr>';
        if ($data[3] != "1") {
            //foreach ($data as $value) {
            for($i = 0; $i < count($data) - 1; $i++) {





                    
                $value = $data[$i];
                echo "<td>${value}\n</td>";





            
            }
            echo '<td>';
            echo '<form action="delete.php" method="POST">';
            echo "<input type='checkbox' name='flagchk[]' value=${row}>";

            echo '</td>';
        }
        echo '</tr>';

    }
    echo '</table>';
    echo '<form name="deletebtn">';
    echo '<input type="submit" value="削除" onclick="return deleteChk()">';
    echo '</from>';
    fclose($handle);
}
?>
