<?php

use YesPHP\Cache\SimpleStorage;
use YesPHP\Can;
use YesPHP\Logic\Entity\EntityHandler;
use YesPHP\Model\Entity;
use YesPHP\Model\EntityInfo;
use YesPHP\Model\EntityNormal;
use YesPHP\Dynamic;
use YesPHP\Logic\Entity\EntityManager;
use YesPHP\Model\EntityArrow;
use YesPHP\Model\RefEntity;
use YesPHP\Model\Storage\EntityArrowStorage;
use YesPHP\Logic\Entity\EntityNormalManager;
use YesPHP\Model\Storage\EntityStorage;

require_once "vendor/autoload.php";

$handler = new EntityHandler;
$infor = new EntityInfo;

$entityManager = new EntityNormalManager(new SimpleStorage,$handler);
$entityManager->setCan(new Can());



$ej = [
  "id" => 323,
  "ref" => 2,
  "parent" => [
    "id" => 33,
    "info" => [
    ],
    "parent" => [
      "id" => 44,
    ]
  ],
  "info" => [
    "class" => "YesPHP\Model\Entity",
  ]
];

$ej = new EntityNormal(222);
$ej->setRef(2);
$ej->setParent(new EntityNormal(77));
$ej->setInfo((new EntityInfo)->setClass("YesPHP\Model\Entity"));
$ej->setChilds(new EntityStorage([
  new Entity(6),new Entity(7),
]));

$arrow = new EntityArrow("a");

$arrow->setValue($ej);

$entityManager->setItem($arrow);

$arrow1 = new EntityArrow("a");

$arrow1->setPrototype(new EntityArrowStorage([
  (new EntityArrow("info"))->setValue(new EntityInfo(22)),
  (new EntityArrow("parent"))->setValue(new Entity()),
]));

$entityManager->setItem($arrow1);

//var_dump($entityManager);

$item = $entityManager->getItem($arrow);
//var_dump($item);

//var_dump($entityManager->getItem($arrow1));

return;

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