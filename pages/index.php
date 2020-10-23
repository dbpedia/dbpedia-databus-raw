<?php
include_once("lib/sparqlhelper.php");
$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");

$pathEntries = explode('/', rtrim($_GET["path"], '/'));
array_shift($pathEntries);

$breadcrumbs = array();

for ($i = 0; $i < count($pathEntries); $i++) {
    $breadcrumb = "https://raw.databus.dbpedia.org";
    for ($j = 0; $j <= $i; $j++) {
        $breadcrumb = $breadcrumb."/".$pathEntries[$j];
    }
    $breadcrumbs[] = $breadcrumb;
}


$pathLength = count($pathEntries);

$docs = $sparql->getDocs($pathEntries);
$links = $sparql->getLinks($pathEntries);
$parent = $pathLength == 0 ? 'DBpedia Databus' : $pathEntries[$pathLength - 1];

include_once('template.php')
?>

