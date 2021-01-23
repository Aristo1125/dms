<?php

const DOC_DATA_NAME = "data/docmanagementdata.csv";
const SET_DATA_NAME = "data/setting.csv";

// "docname"に値が入っている場合、write関数を呼び出す
if(isset($_POST['docname'])) {
    write();
}

// "flagchk"に値が入っている場合、delete関数を呼び出す
if(isset($_POST['flagchk'])) {
    delete();
}


// "notify-token"に値が入っている場合、
if(isset($_POST['notifyToken'])) {
    if($_POST['notifyToken'] !=""){
        applyTokenMessage($_POST['notifyToken']);
        applyToken($_POST['notifyToken']);
    }
}

/**
 * CSVデータを読み込む
 * 
 * @param string $fileName 読込ファイルのファイルパス
 * @param string $option　 fopen関数のオプション（'r','w','a')
 * @return $csvdata 読み込んだCSVファイル
 */
function readCSV($fileName, $option) {

    // CSVファイルが存在しているかチェックする
    if (($csvdata = fopen($fileName, $option)) !== FALSE) {

        //　現在のCSVデータを$record変数に格納する
        while($dataList = fgetcsv($csvdata)) {
            $record[] = $dataList;
        }

        fclose($csvdata);

        return $record;

    } else {
        throw new Exception("ファイル名かオプションが間違っています");
    }
}

/**
 * docmanagementdata.csvの内容を画面に表示する
 * 
 */
function read() {

            $record = readCSV(DOC_DATA_NAME, "r");
            
            echo '<table>';
            echo '<tr>';
            echo '<th>名称</th>';
            echo '<th>型番</th>';
            echo '<th>開始日</th>';
            echo '<th>終了日</th>';
            echo '<th>廃棄</th>';
            echo '</tr>';
            $row = 0;

            for($i = 0; $i < count($record);$i++) {

                $row++;
                echo '<tr>';
                if ($record[$i][4] != "1") {

                    for($j = 0; $j < count($record[$i]) - 1; $j++) {

                        $value = $record[$i][$j];
                        echo "<td>${value}\n</td>";
                    }
                    echo '<td>';
                    echo '<form action="scripts.php" method="POST">';
                    echo "<input type='checkbox' name='flagchk[]' value=${row}>";
                    echo '</td>';
                }
                echo '</tr>';
            }

    echo '</table>';
    echo '<form name="deletebtn">';
    echo '<input type="submit" value="削除" onclick="return deleteChk()">';
    echo '</from>';

}

/**
 * "登録"ボタンを押されたときにdocmanagementdata.csvの最後の行に追加する
 * 
 */
function write() {

        $name = $_POST['docname'];
        $typename= $_POST['typename'];
        $stardate = (string)$_POST['startdate'];
        $enddate = (string)$_POST['enddate'];
        $flag = "0";
        
        // ファイルが存在しているかチェックする
        if (($handle = fopen("data/docmanagementdata.csv", "a")) !== FALSE) {

            // 入力内容を追記する
            fwrite($handle, $name.",".$typename.",".$stardate.",".$enddate.",".$flag."\n");

            //　ファイルを閉じる
            fclose($handle);

            //　入力画面にリダイレクトする
            header('Location: ./document.php');
            exit;
        }

}


// チェックが入れられ”削除”が押下されたデータを”廃棄（1）”にする
function delete() {

    $delflag = $_POST['flagchk'];

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
        $record[$delflag[$i] -1 ][4] = "1"; 
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
        header('Location: ./document.php');
        exit;
}

/**
 * 保証書の終了日をチェックする。
 */
function checkDocDate() {

    $today = date("Y-m-d");
    $messege = "";
    //echo $today;

    $record = readCSV(DOC_DATA_NAME, "r");

    for($i = 0; $i < count($record);$i++) {

        //$row++;
        if ($record[$i][4] != "1") {

            if ($record[$i][3] < $today) {
                $messege = $messege . $record[$i][0] . "の保証書が切れています。" . "\n";
            }


            /*
            for($j = 0; $j < count($record[$i]) - 1; $j++) {
                $record[]
                $value = $record[$i][$j];
                echo "<td>${value}\n</td>";
            }
            */
        }
    }
    post_message($messege, "C3UAMSPoEilnjcuTII4DYUho1elTmZ9L5RvAJPkq9jY");
}

/**
 * アクセストークンが登録された際にメッセージを送信する。
 * @param string $TOKEN Line Notify Acess-token
 */
function applyTokenMessage($TOKEN) {
    post_message("登録が完了しました。", $TOKEN);
}

/**
 * アクセストークンをsetting.csvに書き込む
 * @param string $TOKEN Line Notify Acess-token
 */
function applyToken($TOKEN) {
    // ファイルが存在しているかチェックする
    if(($handle = fopen("data/setting.csv", "w")) !== FALSE){
        // 入力内容を追記する
        fwrite($handle, $TOKEN."\n");

        //　ファイルを閉じる
        fclose($handle);
    
        //　入力画面にリダイレクトする
        //header('Location: ./document.php', true, 200);
        header('Location: ./setting.php');
        exit;
    }
    
}

function readTokenData() {

    $record = readCSV(SET_DATA_NAME, "r");
    $data = $record[0][0];
    echo "<p>通知先のLine Notify：${data}</p>";
}

/**
 * LINE Notifyへ通知する
 * 
 * @param string $message       Lineに通知するメッセージ
 * @param string $ACCESS_TOKEN  Line NotifyのAccess-token
 */
function post_message($message, $ACCESS_TOKEN){
    define('LINE_API_URL'  ,"https://notify-api.line.me/api/notify");
    define('LINE_API_TOKEN',$ACCESS_TOKEN);    // 「ACCESS_TOKEN」を取得したアクセストークンに置き換える
    $data = array(
                        "message" => $message
                     );
    $data = http_build_query($data, "", "&");
    $options = array(
        'http'=>array(
            'method'=>'POST',
            'header'=>"Authorization: Bearer " . LINE_API_TOKEN . "\r\n"
                      . "Content-Type: application/x-www-form-urlencoded\r\n"
                      . "Content-Length: ".strlen($data)  . "\r\n" ,
            'content' => $data
        )
    );
    $context = stream_context_create($options);
    $resultJson = file_get_contents(LINE_API_URL,FALSE,$context );
    $resutlArray = json_decode($resultJson,TRUE);
    if( $resutlArray['status'] != 200)  {
        return false;
    }
    return true;
}
