<?php


echo '<head>';
    echo '<link href="style.css" rel="stylesheet" type="text/css">';
    echo '<title>test3</title>';
echo '</head>';


// ファイルが存在しているかチェックする
if (($handle = fopen("data/docmanagementdata.csv", "r")) !== FALSE) {

    // 1行ずつfgetcsv()関数を使って読み込む
    echo '<table>';
    while (($data = fgetcsv($handle))) {
        //echo "${row}行目\n";
        //$row++;
        echo '<tr>';
        foreach ($data as $value) {
            
            
            echo "<td>${value}\n</td>";
            //echo '<td>2015/01/01</td>';
            //echo '<td>2020/12/31</td>';
            
            
            //echo "${value}\n";
            
        }
        echo '</tr>';
        //echo "<br>";

    }
    echo '</table>';
    fclose($handle);
}
?>
