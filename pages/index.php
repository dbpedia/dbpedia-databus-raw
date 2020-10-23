<?php
$baseUri =  'https://raw.databus.dbpedia.org/';

include_once("lib/sparqlhelper.php");
$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");

$pathEntries = explode('/', rtrim($_GET["path"], '/'));
array_shift($pathEntries);

$breadcrumbs = array();

for ($i = 0; $i <= count($pathEntries); $i++) { 
    $crumb = "/";
    for ($j = 0; $j <= $i; $j++) { 
        $crumb = $crumb.$pathEntries[$j];
    }
    $breadcrumbs[] = $crumb;    
}


$pathLength = count($pathEntries);

$docs = $sparql->getDocs($pathEntries);
$links = $sparql->getLinks($pathEntries);
$parent = $pathLength == 0 ? 'DBpedia Databus' : $pathEntries[$pathLength - 1];

include_once('template.php')
?>

