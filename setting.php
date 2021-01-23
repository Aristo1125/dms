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
	    <form action="scripts.php" method="POST" name="setting">
            LINE Notify-Token：<input type="text" name="notifyToken">
            <input type="submit" value="登録" onClick="return applicateChk();">
        </form>
    </header>
    <br>
    <?php include('scripts.php');
            readTokenData();
            checkDocDate();
    ?>
        
    <br>

    
    

</body>
</html>

