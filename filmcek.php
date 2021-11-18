<?php

$page = $_POST['id'];
require "index.php";

$url = "https://sinefy.com" . $page;

$data = curl($url, $e_id, $v_lang);

preg_match_all("#<div id=\"not-loaded\" data-whatwehave=\"(.*?)\" data-lang=\"(.*?)\" data-money=\"1\">#", $data, $tit);
$inftab = $tit[1];
$inftab1 = $tit[2];


for ($i = 0; $i < count($inftab); $i++) {
    $e_id = $inftab[$i];
    $v_lang = $inftab1[$i];
    
    
    $url = "https://sinefy.com/ajax/service";
    
    $data = curl($url, $e_id, $v_lang);
    
    
    echo $data;
}