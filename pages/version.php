<?php
include_once("lib/sparqlhelper.php");

$publisher = $_GET["publisher"];
$group = $_GET["group"];
$artifact = $_GET["artifact"];
$version = $_GET["version"];
$versionUri = 'https://databus.dbpedia.org/'.$publisher.'/'.$group.'/'.$artifact.'/'.$version;

$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");
$files = $sparql->getFiles($publisher, $group, $artifact, $version);

?>
<html>
 <head>
  <title>VERSION</title>
 </head>
 <body>
 <?php foreach ($files as &$file) { ?>
    <p><a href="/<?=$publisher.'/'.$group.'/'.$artifact.'/'.$version.'/'.$file?>"><?=$file?></a></p>
 <?php } ?>
 </body>
</html>