<?php
require "index.php";
$gelen = $_POST['link'];

$e_id = '';
$v_lang = '';

$url = "https://sinefy.com/" . $gelen;

$data = curl($url, $e_id, $v_lang);
preg_match_all("#<div class=\"default text\">(.*?)</div><div class=\"menu\">(.*?)</div>#", $data, $list);
$liste = $list[2];
$list = $list[1];
$json = [];
for ($i = 0; $i < count($liste); $i++) {
    $lis = $liste[$i];

    preg_match_all("#<a href=\"(.*?)\" class=\"item\" (.*?)>(.*?)</a>#", $lis, $listt);
    $adi = $listt[3];
    $url = $listt[1];
    for ($in = 0; $in < count($adi); $in++) {

        $category = $list[$i];
        $categoryurl = $liste[$i];
        if ($category == "Türler") {
            if (!isset($json[$category])) {
                $json[$category] = ['category' => $category, 'values' => []];
            }


            $json[$category]['values'][] = ['adi' => $adi[$in], 'link' => $url[$in]];
        }
    }
}



$json = json_encode($json, true);
echo $json;
