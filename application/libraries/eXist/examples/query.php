<?php
include '../lib/Client.php';
include '../lib/Query.php';
include '../lib/ResultSet.php';
include '../lib/SimpleXMLResultSet.php';
include '../lib/DOMResultSet.php';

$connConfig = array(
		'protocol'=>'http',
		'host'=>'localhost',
		'port'=>'8080',
		'user'=>'admin',
		'password'=>'parola',		
		'collection' => 'apps/testExist/'
);
//http://localhost:8080/exist/apps/testExist/cd_catalaog.xml

$conn = new \ExistDB\Client($connConfig);
/*$xql = <<<EOXQL
	for \$cd in //CD[./PRICE < \$priceDefinedByBindVariableMethod]
		return \$cd 
EOXQL;*/
$xql = <<<EOXQL
 	'Hello World!'
EOXQL;

/*$xql = <<<EOXQL
	(: for \$price in //pret
	return update rename \$price as 'update' :)
	'Hello World!'
EOXQL;
*/

$stmt = $conn->prepareQuery($xql);

$stmt->bindVariable('priceDefinedByBindVariableMethod', 7.80);
$resultPool = $stmt->execute();
$results = $resultPool->getAllResults();
/*echo "Results: ";
var_dump($results);

if(count($results) == 0){
	echo "Empty";
}*/
header('Content-type: text/xml');
echo '<cdCatalog>';
foreach($results as $result)
{
	//echo "in foreach";
	echo $result;
}

echo '</cdCatalog>';
/*
for \$cd in /CD[./PRICE < \$priceDefinedByBindVariableMethod]
return \$cd
*/
