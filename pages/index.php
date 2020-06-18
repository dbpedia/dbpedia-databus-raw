<?php
include_once("lib/sparqlhelper.php");

$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");
$publishers = $sparql->getPublishers();

?>
<html>
 <head>
  <title>INDEX</title>
 </head>
 <body>
 <h1>Databus</h1>
 <?php foreach ($publishers as &$publisher) { ?>
    <p><a href="/<?=$publisher?>"><?=$publisher?></a></p>
 <?php } ?>
 </body>
</html>