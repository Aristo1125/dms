<!doctype html>
<meta http-equiv="content-type"
content="text/html; charset=UTF-8">
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="javascript.js"></script>

</head>
<html>
<body>
    <header>
	    <form action="scripts.php" method="POST" name="applicate">
            保証書名：<input type="text" name="docname">
            型番:<input type="text" name="typename">
            開始日：<input type="date" name="startdate">
            終了日：<input type="date" name="enddate">
            <input type="submit" value="登録" onClick="return applicateChk();">
        </form>
    </header>
    <br>
    
        <?php include('scripts.php');
            read();
        ?>
        
        <br>
    <br>

    
    

</body>
</html>

