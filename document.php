<!doctype html>
<meta http-equiv="content-type"
content="text/html; charset=UTF-8">
<html>
<body>
    <header>
	    <form action="write.php" method="POST">
            保証書名：<input type="text" name="docname">
            開始日：<input type="date" name="startdate">
            終了日：<input type="date" name="enddate">
            <input type="submit" value="送信する">
            <script>
            alert('JavaScriptのアラート');
            </script>
        </form>
    </header>
    <br>

    <?php include('read.php'); ?>

    <br>

</body>
</html>

