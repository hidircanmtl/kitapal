<?php

try {

    $db=new PDO("mysql:host=localhost;dbname=kitapal;charset=utf8",'root','');
    //echo "veritabanı bağlantısı başarılı";
}

catch (PDOExpception $e) {

    echo $e->getMessage();
}

function seflink($text){
    $find = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
    $degis = array("G","U","S","I","O","C","g","u","s","i","o","c");
    $text = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$text);
    $text = preg_replace($find,$degis,$text);
    $text = preg_replace("/ +/"," ",$text);
    $text = preg_replace("/ /","-",$text);
    $text = preg_replace("/\s/","",$text);
    $text = strtolower($text);
    $text = preg_replace("/^-/","",$text);
    $text = preg_replace("/-$/","",$text);
    return $text;
}