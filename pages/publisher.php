<?php
include_once("lib/sparqlhelper.php");

$publisher = $_GET["publisher"];

$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");
$groups = $sparql->getGroups($publisher);

?>
<html>
 <head>
  <title>PUBLISHER</title>
 </head>
 <body>
 <?php foreach ($groups as &$group) { ?>
    <p><a href="/<?=$publisher.'/'.$group?>"><?=$group?></a></p>
 <?php } ?>
 </body>
</html>