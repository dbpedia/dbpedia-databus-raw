<?php
include_once("lib/sparqlhelper.php");

//TODO sometimes REQUEST_URI contains scheme and domain, not sure
$PATH=$_SERVER["REQUEST_URI"];

function handlePath($PATH){
	if($PATH=='/'){
		//TODO needs to use sparql function
		//$sparql = new SparqlHelper("https://databus.dbpedia.org/repo/sparql");
		//$publishers = $sparql->getPublishers();

		return array('parent'=>'NONE', 'links'=>array('publisherpath1'=>'label1','publisherpath2'=>'label2'));
		
	//TODO use some regex	
	}else if($PATH=='/[a-zA-Z0-9]+/'){
		
	   return array('parent'=>'publisher', 'links'=>array('pub/grouppath1'=>'label','pub/grouppath2'=>'label2'));
	}
	//TODO further
	
}

//TODO 
//$parent
//$links 


include_once('template.php')
?>

