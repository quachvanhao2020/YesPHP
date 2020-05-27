<?php


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

function objectToArray($d) {
    if (is_object($d)) {

        $d = get_object_vars($d);
    }

    if (is_array($d)) {

        return array_map(__FUNCTION__, $d);
    }
    else {

        return $d;
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