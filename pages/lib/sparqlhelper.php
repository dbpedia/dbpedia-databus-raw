<?php

include_once("sparqllib.php");

class SparqlHelper {

  public $getPublishersQuery = <<<EOD
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX foaf: <http://xmlns.com/foaf/0.1/>
SELECT DISTINCT ?uri WHERE {
  ?dataset dct:publisher ?publisher.
  ?publisher foaf:account ?uri .
}
EOD;

public $getGroupsQuery = <<<EOD
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
PREFIX foaf: <http://xmlns.com/foaf/0.1/>
SELECT DISTINCT ?group WHERE {
  ?dataset dct:publisher ?publisher .
  ?publisher foaf:account <%PUBLISHER_URI%> .
  ?dataset dct:publisher ?publisher .
  ?dataset dataid:group ?group
}
EOD;

public $getArtifactsQuery = <<<EOD
PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
SELECT DISTINCT ?artifact WHERE {
  ?dataset dataid:group <%GROUP_URI%> .
  ?dataset dataid:artifact ?artifact .
}
EOD;

public $getVersionsQuery = <<<EOD
PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
SELECT DISTINCT ?version WHERE {
  ?dataset dataid:version ?version .
  ?dataset dataid:artifact <%ARTIFACT_URI%> .
}
EOD;

public $getFilesQuery = <<<EOD
PREFIX dataid: <http://dataid.dbpedia.org/ns/core#>
SELECT ?file WHERE {
?distribution dataid:file ?file .
?distribution dataid:isDistributionOf ?dataset .
?dataset dataid:version <%VERSION_URI%> .
}
EOD;

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

  public function debugPrint($query) {
    echo "<pre>".str_replace('>', '&#62;', str_replace('<', '&#60;', $query))."</pre>";
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

  function getPublishers() {
    $result = $this->executeQuery($this->getPublishersQuery);
    $data = array();

    while($row = $result->fetch_array()) {
      $data[] = $this->uriToName($row["uri"]);
    }
    return $data;
  }

  function getGroups($publisher) {
    $publisherUri = 'https://databus.dbpedia.org/'.$publisher;
    $query = str_replace('%PUBLISHER_URI%', $publisherUri, $this->getGroupsQuery);

    $result = $this->executeQuery($query);
    $data = array();

    while($row = $result->fetch_array()) {
      $data[] = $this->uriToName($row["group"]);
    }
    return $data;
  }

  function getArtifacts($publisher, $group) {
    $groupUri = 'https://databus.dbpedia.org/'.$publisher.'/'.$group;
    $query = str_replace('%GROUP_URI%', $groupUri, $this->getArtifactsQuery);

    $result = $this->executeQuery($query);
    $data = array();

    while($row = $result->fetch_array()) {
      $data[] = $this->uriToName($row["artifact"]);
    }
    return $data;
  }

  function getVersions($publisher, $group, $artifact) {
    $artifactUri = 'https://databus.dbpedia.org/'.$publisher.'/'.$group.'/'.$artifact;
    $query = str_replace('%ARTIFACT_URI%', $artifactUri, $this->getVersionsQuery);

    $result = $this->executeQuery($query);
    $data = array();

    while($row = $result->fetch_array()) {
      $data[] = $this->uriToName($row["version"]);
    }
    return $data;
  }

  function getFiles($publisher, $group, $artifact, $version) {
    $versionUri = 'https://databus.dbpedia.org/'.$publisher.'/'.$group.'/'.$artifact.'/'.$version;
    $query = str_replace('%VERSION_URI%', $versionUri, $this->getFilesQuery);

    $result = $this->executeQuery($query);
    $data = array();

    while($row = $result->fetch_array()) {
      $data[] = $this->uriToName($row["file"]);
    }
    return $data;
  }
}
