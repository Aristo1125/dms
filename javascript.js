function applicateChk() {
    if (applicate.docname.value == "" || applicate.startdate.value == "" || applicate.enddate.value =="") {
        alert("保証署名,開始日,終了日の何れかが入力されていません");
        return false;
    } else {
        return true;
    }
}


