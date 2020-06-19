<?php
?>
<html>
<head><title>Index of <?=$parent?></title></head>
<body bgcolor="white">
<h1>Index of <?=$parent?></h1><hr><pre><a href="../">../</a>
<?php foreach ($publishers as &$publisher) { ?>
    <p><a href="/<?=$publisher?>"><?=$publisher?></a></p>
 <?php } ?>
</pre><hr></body>
</html>
