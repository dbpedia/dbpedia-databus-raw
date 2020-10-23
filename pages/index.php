<?php
include_once("lib/sparqlhelper.php");
$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");

$pathEntries = explode('/', rtrim($_GET["path"], '/'));
array_shift($pathEntries);

$pathLength = count($pathEntries);

$docs = $sparql->getDocs($pathEntries);
$links = $sparql->getLinks($pathEntries);
$parent = $pathLength == 0 ? 'DBpedia Databus' : $pathEntries[$pathLength - 1];

include_once('template.php')
?>

