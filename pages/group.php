<?php
include_once("lib/sparqlhelper.php");

$publisher = $_GET["publisher"];
$group = $_GET["group"];

$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");
$artifacts = $sparql->getArtifacts($publisher, $group);

?>
<html>
 <head>
  <title>GROUP</title>
 </head>
 <body>
 <?php foreach ($artifacts as &$artifact) { ?>
    <p><a href="/<?=$publisher.'/'.$group.'/'.$artifact?>"><?=$artifact?></a></p>
 <?php } ?>
 </body>
</html>