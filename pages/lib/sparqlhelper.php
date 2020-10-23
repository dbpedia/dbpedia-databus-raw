<?php

include_once("sparqllib.php");

class SparqlHelper {

  public $linkQueries = array(
<<<EOD
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX foaf: <http://xmlns.com/foaf/0.1/>
SELECT DISTINCT ?uri WHERE {
  ?dataset dct:publisher ?publisher.
  ?publisher foaf:account ?uri .
}
EOD,
<<<EOD
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
PREFIX foaf: <http://xmlns.com/foaf/0.1/>
SELECT DISTINCT ?uri WHERE {
  ?dataset dct:publisher ?publisher .
  ?publisher foaf:account <%DATABUS_URI%> .
  ?dataset dct:publisher ?publisher .
  ?dataset dataid:group ?uri
}
EOD,
<<<EOD
PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
SELECT DISTINCT ?uri WHERE {
  ?dataset dataid:group <%DATABUS_URI%> .
  ?dataset dataid:artifact ?uri .
}
EOD,
<<<EOD
PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
SELECT DISTINCT ?uri WHERE {
  ?dataset dataid:version ?uri .
  ?dataset dataid:artifact <%DATABUS_URI%> .
}
EOD,
<<<EOD
PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX dcat:  <http://www.w3.org/ns/dcat#>
SELECT DISTINCT ?uri ?size ?time WHERE {
?distribution dataid:file ?uri .
?distribution dcat:byteSize ?size .
?distribution dct:issued ?time .
?distribution dataid:isDistributionOf ?dataset .
?dataset dataid:version <%DATABUS_URI%> .
}
EOD);


public $docQueries = array(
  <<<EOD
  EOD,
  <<<EOD
  PREFIX foaf: <http://xmlns.com/foaf/0.1/>
  SELECT DISTINCT ?label ?desc WHERE {
    ?publisher foaf:account <%DATABUS_URI%> .
    ?publisher foaf:name ?label .
    OPTIONAL { ?publisher foaf:status ?desc . }
  } LIMIT 1
  EOD,
  <<<EOD
  PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
  PREFIX dct: <http://purl.org/dc/terms/>
  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
  SELECT DISTINCT ?label ?desc WHERE {
 
    BIND(<%DATABUS_URI%> AS ?uri) 
    OPTIONAL { ?uri rdfs:label ?label . }
    ?dataset dataid:group ?uri .
    OPTIONAL { ?dataset dataid:groupdocu ?desc . }
    ?dataset dct:issued ?date.
  }
  ORDER BY desc(?date) LIMIT 1
  EOD,
  <<<EOD
  PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
  PREFIX dct: <http://purl.org/dc/terms/>
  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
  SELECT DISTINCT ?label ?desc WHERE {
    ?dataset dataid:artifact <%DATABUS_URI%> .
    ?dataset rdfs:label ?label.
    ?dataset rdfs:comment ?desc.
    ?dataset dct:hasVersion ?version.
  }
  ORDER BY desc(?version) LIMIT 1
  EOD,
  <<<EOD
  PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
  SELECT DISTINCT ?label ?desc WHERE {
    ?dataset dataid:version <%DATABUS_URI%> .
    ?dataset rdfs:label ?label.
    ?dataset rdfs:comment ?desc.
  } LIMIT 1
  EOD);

  public $sparqlEndpointUrl = "https://databus.dbpedia.org/repo/sparql/";

  /**
   * Creates a new sparql endpoint instance with a sparql endpoint URL
   * @param [type] $sparqlEndpointUrl [description]
   */
  public function __construct($sparqlEndpointUrl) {
    $this->sparqlEndpointUrl = $sparqlEndpointUrl;
  }

  /**
   * Cuts off the sub-string after the last forward slash of a string
   * and returns it
   * @param  [type] $uri [description]
   * @return [type]      [description]
   */
  public function uriToName($uri) {
    $tmp = explode('/', $uri);
    return array_pop($tmp);
  }

  /**
   * Connects to the sparql endpoint and executes a query
   * @param  [type] $query [description]
   * @return [type]        [description]
   */
  function executeQuery($query) {

    $db = sparql_connect( $this->sparqlEndpointUrl );

    if(!$db) {
      error_log("Failed to reach the sparql endpoint at ".$this->sparqlEndpointUrl);
      return null;
    }

    $result = $db->query( $query );

    if(!$result) {
      error_log("Failed to execute query.\n".$db->errno().": ".$db->error()."\n");
      return null;
    }

    return $result;
  }

  function getDocs($pathEntries) {
   
    $pathLength = count($pathEntries);
    $relativePath = join('/', $pathEntries);
    $databusUri =  'https://databus.dbpedia.org/'.$relativePath;
    $label = '-';
    $desc = '-';

    if($pathLength > 0) {
      $query = str_replace('%DATABUS_URI%', $databusUri, $this->docQueries[$pathLength]);
      $queryResult = $this->executeQuery($query);
    
      $row = $queryResult->fetch_array();

      $label = $row["label"] != NULL ? $row["size"] : '-';
      $desc = $row["desc"] != NULL ? $row["desc"] : '-';
    }

    return array('label' => $label, 'databus-uri' => $databusUri, 'desc' => $desc);
  }

  function getLinks($pathEntries) {
    $pathLength = count($pathEntries);
    $relativePath = join('/', $pathEntries);

    $databusUri =  'https://databus.dbpedia.org/'.$relativePath;
    $query = str_replace('%DATABUS_URI%', $databusUri, $this->linkQueries[$pathLength]);
    $queryResult = $this->executeQuery($query);

    $links = array();
   
    while($row = $queryResult->fetch_array()) {
      $name = $this->uriToName($row["uri"]);
      $uri = $pathLength == 0 ? $name : $relativePath.'/'.$name;
      $size = $row["size"] != NULL ? $row["size"] : '-';
      $time = $row["time"] != NULL ? $row["time"] : '-';

      $links[] = array('label' => $name, 'uri' => $uri, 'size' => $size, 'time' => $time);
    }

    return $links;
  }
}
