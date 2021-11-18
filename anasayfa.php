<?php
require "index.php";

$e_id = '';
$v_lang = '';
$url = "https://sinefy.com/_get_home?_=router";

$data = curl($url, $e_id, $v_lang);

//tag
preg_match_all("#<a href=\"/(.*?)\" class=\"ui tag label\" data-navigo>(.*?)</a>#", $data, $tag);
$taglink = $tag[1];
$tagad = $tag[2];
$tagadet="3";

//yakında gelecekler
preg_match_all("#<li class=\"\" data--yt-type=\"movie\" (.*?)<a href=\"(.*?)\" (.*?)<img class=\"lazyload\" (.*?) data-src=\"(.*?)\">(.*?)<h6>(.*?)</h6>(.*?)</li>#", $data, $tit);
$gellink = $tit[2];
$gelresim = $tit[5];
$geladi = $tit[7];

//izlemeye değer
preg_match_all("#<li class=\"segment-poster\">(.*?)<a href=\"(.*?)\"(.*?)data-src=\"(.*?)\">(.*?)<h4>(.*?)</h4>(.*?)truncate\">(.*?)</p>(.*?)</li>#", $data, $iddizi);
$igeladi = $iddizi[6];
$igellink = $iddizi[2];
$igelresim = $iddizi[4];
$igeltur = $iddizi[8];

preg_match_all("#<li class=\"segment-poster segment-poster\" (.*?)>(.*?)<a href=\"(.*?)\" (.*?)data-src=\"(.*?)\">(.*?)</svg> (.*?)</span>(.*?)<span class=\"item year\">(.*?)</span>(.*?)<h2 class=\"truncate\">(.*?)</h2>(.*?)<span class=\"genres\">(.*?)</span>(.*?)</li>#", $data, $list);

$link = $list[3];
$resim = $list[5];
$imdb = $list[7];
$yil = $list[9];
$adi = $list[11];
$tur = $list[13];

$json = [];
for ($i = 1; $i < $tagadet; $i++) {
    $json["tag"]['values'][] = [
        "adi" => $tagad[$i],
        "link" => $taglink[$i]
    ];
}
for ($i = 0; $i < count($geladi); $i++) {
    $json["yakinda"]['values'][] = [
        "link" => $gellink[$i],
        "resim" => $gelresim[$i],
        "adi" => $geladi[$i]
    ];
}
for ($i = 0; $i < count($igeladi); $i++) {
    $json["iddizi"]['values'][] = [
        "link" => $igellink[$i],
        "resim" => $igelresim[$i],
        "adi" => $igeladi[$i],
        "tur" => $igeltur[$i]
    ];
}
for ($i = 0; $i < count($adi); $i++) {
    $json["soneklenen"]['values'][] = [
        "adi" => $adi[$i],
        "link" => $link[$i],
        "resim" => $resim[$i],
        "tur" => $tur[$i],
        "imdb" => $imdb[$i],
        "yil" => $yil[$i],
        "pacem" => $i + 1
    ];
}

$json = json_encode($json, true);
echo $json;
