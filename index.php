<?php
require_once "vendor/autoload.php";

libxml_use_internal_errors(true);

$myXMLData =
"<?xml version='1.0' encoding='UTF-8'?>
<document>
<user>John Doe</wronguser>
<email>john@example.com</wrongemail>
</document>";

$dir = __DIR__."/tests/Logic/Entity/_files";

$myXMLData = file_get_contents($dir."/manager.xml");


$xml = simplexml_load_string($myXMLData);
if ($xml === false) {
  echo "Failed loading XML: ";
  foreach(libxml_get_errors() as $error) {
    echo "<br>", $error->message;
  }
} else {

    $xmlArray = xmlToArray($xml);

    var_dump($xmlArray);

    $xmlArrayy = array(
        array(
            'name' => "John",
            'lastname' => "Don",
            'pesel' => "987987",
        ),
        array(
            'name' => "Mike",
            'lastname' => "Evans",
            'pesel' => "89779",
        )
    );

    $xml = new SimpleXMLElement('<Projects/>'); 

    array_to_xml($xmlArray,$xml);

    var_dump($xml->asXML());

}