<?php
require "index.php";
$case = $_POST['sayfa'];
$sayfa = $_POST['link'];
$page = $_POST['page'];

$pagem = "?page=" . $page;
    
$e_id = '';
$v_lang = '';


$sabit = "https://sinefy.com/" . $sayfa . $pagem;

$data = curl($sabit, $e_id, $v_lang);

$go = $case;
switch ($go) {
    case "gozatfilm";

        preg_match_all("#<li class=\"segment-poster\" (.*?)>(.*?)<a href=\"(.*?)\" (.*?)<img class=\"lazyload\" (.*?) data-src=\"(.*?)\">(.*?)<h2 class=\"truncate\">(.*?)</h2>(.*?)<span class=\"genres\">(.*?)</span>(.*?)</li>#", $data, $tag);
        $adi3 = $tag[3];
        $adi10 = $tag[6];
        $adi5 = $tag[8];
        $adi7 = $tag[10];

        break;
    case "gozatdizi";

        preg_match_all("#<div class=\"poster-with-subject\"><a href=\"(.*?)\" data-navigo><img class=\"lazyload\" (.*?) data-src=\"(.*?)\">(.*?)<h2 class=\"truncate\">(.*?)</h2>(.*?)<span class=\"genres\">(.*?)</span><span class=\"rating\"><svg class=\"mofycon\">(.*?)</svg>(.*?)</span>(.*?)</div>#", $data, $tag);
        $adi3 = $tag[1]; //link
        $adi10 = $tag[3]; //resim
        $adi5 = $tag[5]; //adi
        $adi7 = $tag[7]; //bolum

        break;
    case "film";

        preg_match_all("#<li class=\"segment-poster\" (.*?)>(.*?)<a href=\"(.*?)\" (.*?)<img class=\"lazyload\" (.*?) data-src=\"(.*?)\">(.*?)<h2 class=\"truncate\">(.*?)</h2>(.*?)<span class=\"genres\">(.*?)</span>(.*?)</li>#", $data, $tag);
        $adi3 = $tag[3];
        $adi10 = $tag[6];
        $adi5 = $tag[8];
        $adi7 = $tag[10];

        break;
    case "dizi";

        preg_match_all("#<li class=\"segment-poster-sm(.*?)\">(.*?)<a href=\"(.*?)\" (.*?)<h2 class=\"truncate\">(.*?)</h2>(.*?)<p class=\"poster-meta\"><span class=\"episode-no\">(.*?)</span>(.*?)<img class=\"lazyload\" (.*?) data-src=\"(.*?)\">(.*?)</li>#", $data, $tag);
        $adi3 = $tag[3];
        $adi5 = $tag[5];
        $adi7 = $tag[7];
        $adi10 = $tag[10];
        break;
    case "netfilm";

        preg_match_all("#<li class=\"segment-poster\"(.*?)>(.*?)<a href=\"(.*?)\" (.*?)<img class=\"lazyload\" (.*?) data-src=\"(.*?)\">(.*?)<h2 class=\"truncate\">(.*?)</h2>(.*?)<span class=\"genres\">(.*?)</span>(.*?)</li>#", $data, $tag);
        $adi3 = $tag[3];
        $adi10 = $tag[6];
        $adi5 = $tag[8];
        $adi7 = $tag[10];

        break;
}
$json = [];
for ($i = 0; $i < count($adi3); $i++) {
    $json[] = [
        "adi" => $adi5[$i],
        "link" => $adi3[$i],
        "bolum" => $adi7[$i],
        "resim" => $adi10[$i],
        "daha" => $page,
        "adi2" => $adi2[$i],
        "adi4" => $adi4[$i],
        "adi6" => $adi6[$i],
        "adi8" => $adi8[$i],
        "adi9" => $adi9[$i]
    ];
}

$json = json_encode($json, true);
echo $json;
