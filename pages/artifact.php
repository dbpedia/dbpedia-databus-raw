<?php
include_once("lib/sparqlhelper.php");

$publisher = $_GET["publisher"];
$group = $_GET["group"];
$artifact = $_GET["artifact"];

$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");
$versions = $sparql->getVersions($publisher, $group, $artifact);

?>
<html>
 <head>
  <title>ARTIFACT</title>
 </head>
 <body>
 <?php foreach ($versions as &$version) { ?>
    <p><a href="/<?=$publisher.'/'.$group.'/'.$artifact.'/'.$version?>"><?=$version?></a></p>
 <?php } ?>
 </body>
</html>