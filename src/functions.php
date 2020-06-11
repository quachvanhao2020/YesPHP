<?php

use YesPHP\ArraySerializable;

/**
 * Class casting
 *
 * @param string|object $destination
 * @param object $sourceObject
 * @return object
 */
function cast($destination, $sourceObject,$recursive = false)
{
    if (is_string($destination)) {
        $destination = new $destination();
    }
    $sourceReflection = new ReflectionObject($sourceObject);
    $destinationReflection = new ReflectionObject($destination);
    $sourceProperties = $sourceReflection->getProperties();
    foreach ($sourceProperties as $sourceProperty) {

        $sourceProperty->setAccessible(true);
        $name = $sourceProperty->getName();

        $value = $sourceProperty->getValue($sourceObject);

        if($recursive && is_object($value)){
            //var_dump($value);
            $value = cast($destination,$value,$recursive);
        } 

        if ($destinationReflection->hasProperty($name)) {
            $propDest = $destinationReflection->getProperty($name);
            $propDest->setAccessible(true);
            $propDest->setValue($destination,$value);
        } else {
            $destination->$name = $value;
        }
    }
    return $destination;
}

function array_to_xml($array, &$xml) { 
    
    if($xml instanceof SimpleXMLElement){
    
        foreach($array as $key => $value) {               
            if(is_array($value)) {            
                if(!is_numeric($key)){
                    $subnode = $xml->addChild($key);
                    array_to_xml($value, $subnode);
                } else {
                    //$subnode = $xml->addChild($key);
                    array_to_xml($value, $xml);
                }
            } else {
                $xml->addChild($key, $value);
            }
        }

    }    
}

function array_to_xml2($student_info, $xml_student_info) {
    foreach($student_info as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_student_info->addChild("$key");
                array_to_xml($value, $subnode);
            }
            else{
                $subnode = $xml_student_info->addChild("person");
                array_to_xml($value, $subnode);
            }
        }
        else { 
            $xml_student_info->addChild("$key","$value");
        }
    }
}

function object2array($object) { return @json_decode(@json_encode($object),1); } 

/**
* @param SimpleXMLElement $xml
* @return array
*/
function xmlToArray(SimpleXMLElement $xml): array
{
    $parser = function (SimpleXMLElement $xml, array $collection = []) use (&$parser) {
        $nodes = $xml->children();
        $attributes = $xml->attributes();

        if (0 !== count($attributes)) {
            foreach ($attributes as $attrName => $attrValue) {
                $collection['attributes'][$attrName] = strval($attrValue);
            }
        }

        if (0 === $nodes->count()) {
            $collection['value'] = strval($xml);
            return $collection;
        }

        foreach ($nodes as $nodeName => $nodeValue) {
            if (count($nodeValue->xpath('../' . $nodeName)) < 2) {
                $collection[$nodeName] = $parser($nodeValue);
                continue;
            }

            $collection[$nodeName][] = $parser($nodeValue);
        }

        return $collection;
    };

    return [
        $xml->getName() => $parser($xml)
    ];
}

function array2xml($array, $tag) {

    function ia2xml($array) {
        $xml="";
        foreach ($array as $key=>$value) {
            if (is_array($value)) {
                $xml.="<$key>".ia2xml($value)."</$key>";
            } else {
                $xml.="<$key>".$value."</$key>";
            }
        }
        return $xml;
    }

    $string = "<$tag>".ia2xml($array)."</$tag>";

    var_dump($string);

    return simplexml_load_string($string);
} 

function is_writable_r($dir) {
    if (is_dir($dir)) {
        if(is_writable($dir)){
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (!is_writable_r($dir."/".$object)) return false;
                    else continue;
                }
            }   
            return true;   
        }else{
            return false;
        }
       
    }else if(file_exists($dir)){
        return (is_writable($dir));
       
    }
}

function safeDir($dir){

    if(!is_writable_r($dir)){

        if(mkdir($dir,0777,true)){


        }

    }

    return $dir;


}

function enClassString($class){

    return str_replace("\\","_",$class);

}

function deClassString($value,$default = ""){

    return isset($value) ? $value : $default;
}

function non($value,$default = ""){

    return isset($value) ? $value : $default;
}

function compress_htmlcode($codedata) 
{
    $searchdata = array(
    '/\>[^\S ]+/s', // remove whitespaces after tags
    '/[^\S ]+\</s', // remove whitespaces before tags
    '/(\s)+/s' // remove multiple whitespace sequences
    );
    $replacedata = array('>','<','\\1');
    $codedata = preg_replace($searchdata, $replacedata, $codedata);
    return $codedata;
}
function objectToArray($ob,$recursive = false) {

    if($ob instanceof ArraySerializable){

        $ob = $ob->toArray();

        if($recursive){
            foreach ($ob as $key => $value) {
                $ob[$key] = objectToArray($value,$recursive);
            }
        }

        return $ob;

    }

    if (is_object($ob)) {
        $ob = get_object_vars($ob);
    }
    if (is_array($ob)) {
        return array_map(__FUNCTION__, $ob);
    }
    else {
        return $ob;
    }
}
function arrayToObject($d) {
    if (is_array($d)) {
        return (object) array_map(__FUNCTION__, $d);
    }
    else {
        return $d;
    }
}

function runPhpString($php){

    preg_match_all( '/<\?php(.+?)\?>/is', $php, $blocks );

    $b0 = $blocks[0];
    $b1 = $blocks[1];

    foreach ($b1 as $key => $value) {

        $value = eval($value);

        $php = str_replace($b0[$key],$value,$php);

    }

    return $php;

}

function dump_debug($input, $collapse=false){

    if(is_object($input)){

        $input = json_encode($input,JSON_PRETTY_PRINT);

        //file_put_contents(DUMP.__FUNCTION__.".json",$input);

        $input = json_decode($input,true);
    }

    return _dump_debug($input,$collapse);

}

function _dump_debug($input, $collapse=false) {
    $recursive = function($data, $level=0) use (&$recursive, $collapse) {
        global $argv;

        $isTerminal = isset($argv);

        if (!$isTerminal && $level == 0 && !defined("DUMP_DEBUG_SCRIPT")) {
            define("DUMP_DEBUG_SCRIPT", true);

            echo '<script language="Javascript">function toggleDisplay(id) {';
            echo 'var state = document.getElementById("container"+id).style.display;';
            echo 'document.getElementById("container"+id).style.display = state == "inline" ? "none" : "inline";';
            echo 'document.getElementById("plus"+id).style.display = state == "inline" ? "inline" : "none";';
            echo '}</script>'."\n";
        }

        $type = !is_string($data) && is_callable($data) ? "Callable" : ucfirst(gettype($data));
        $type_data = null;
        $type_color = null;
        $type_length = null;

        switch ($type) {
            case "String":
                $type_color = "green";
                $type_length = strlen($data);
                $type_data = "\"" . htmlentities($data) . "\""; break;

            case "Double":
            case "Float":
                $type = "Float";
                $type_color = "#0099c5";
                $type_length = strlen($data);
                $type_data = htmlentities($data); break;

            case "Integer":
                $type_color = "red";
                $type_length = strlen($data);
                $type_data = htmlentities($data); break;

            case "Boolean":
                $type_color = "#92008d";
                $type_length = strlen($data);
                $type_data = $data ? "TRUE" : "FALSE"; break;

            case "NULL":
                $type_length = 0; break;

            case "Array":
                $type_length = count($data);
        }

        if (in_array($type, array("Object", "Array"))) {
            $notEmpty = false;

            foreach($data as $key => $value) {
                if (!$notEmpty) {
                    $notEmpty = true;

                    if ($isTerminal) {
                        echo $type . ($type_length !== null ? "(" . $type_length . ")" : "")."\n";

                    } else {
                        $id = substr(md5(rand().":".$key.":".$level), 0, 8);

                        echo "<a href=\"javascript:toggleDisplay('". $id ."');\" style=\"text-decoration:none\">";
                        echo "<span style='color:#666666'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>";
                        echo "</a>";
                        echo "<span id=\"plus". $id ."\" style=\"display: " . ($collapse ? "inline" : "none") . ";\">&nbsp;&#10549;</span>";
                        echo "<div id=\"container". $id ."\" style=\"display: " . ($collapse ? "" : "inline") . ";\">";
                        echo "<br />";
                    }

                    for ($i=0; $i <= $level; $i++) {
                        echo $isTerminal ? "|    " : "<span style='color:black'>|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }

                    echo $isTerminal ? "\n" : "<br />";
                }

                for ($i=0; $i <= $level; $i++) {
                    echo $isTerminal ? "|    " : "<span style='color:black'>|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                echo $isTerminal ? "[" . $key . "] => " : "<span style='color:black'>[" . $key . "]&nbsp;=>&nbsp;</span>";

                call_user_func($recursive, $value, $level+1);
            }

            if ($notEmpty) {
                for ($i=0; $i <= $level; $i++) {
                    echo $isTerminal ? "|    " : "<span style='color:black'>|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                if (!$isTerminal) {
                    echo "</div>";
                }

            } else {
                echo $isTerminal ?
                        $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "  " :
                        "<span style='color:#666666'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>&nbsp;&nbsp;";
            }

        } else {
            echo $isTerminal ?
                    $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "  " :
                    "<span style='color:#666666'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>&nbsp;&nbsp;";

            if ($type_data != null) {
                echo $isTerminal ? $type_data : "<span style='color:" . $type_color . "'>" . $type_data . "</span>";
            }
        }

        echo $isTerminal ? "\n" : "<br />";
    };

    call_user_func($recursive, $input);
}