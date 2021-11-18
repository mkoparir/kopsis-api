<?php
$page = $_POST['id'];
require "index.php";

$url = "https://sinefy.com" . $page;

$data = curl($url, $e_id, $v_lang);

$json = [];
//preg_match_all("#<div id=\"not-loaded\" data-whatwehave=\"(.*?)\" data-lang=\"(.*?)\" data-money=\"1\">(.*?)</div>#", $data, $tit);
preg_match_all("#<h1 class=\"page-title\">(.*?)<span class=\"light-title\">(.*?)</span></h1>#", $data, $title);
preg_match_all("#<a class=\"ui image\" id=\"series-profile-image-wrapper\"><img class=\"series-profile-thumb lazyload\" (.*?) data-src=\"(.*?)\" (.*?) /></a>#", $data, $img);

preg_match_all("#<a class=\"ui image\" id=\"series-profile-image-wrapper\"><img class=\"series-profile-thumb\" src=\"(.*?)\"(.*?) /></a>#", $data, $altimg);
preg_match_all("#tv-series-desc\"(.*?)>(.*?)<span class=\"tv-more\"#", $data, $acik);
//preg_match_all("#tv-series-desc\">(.*?)<span class=\"tv-more\"#", $data, $acik1);
preg_match_all("#class=\"ui pointing secondary menu\">(.*?)</div>#", $data, $izli);
preg_match_all("#<table class=\"ui unstackable single line celled table\">(.*?)</table>#", $data, $table);
$inftab = $table[1];

preg_match_all("#<a id=\"first_episode\" title=\"(.*?)\" href=\"(.*?)\" data-navigo>#", $data, $diziilk); //dizi bölümlerinden link serilestirme
$ilkbolum = $diziilk[2]; //ilk dizi linki alma

//preg_match_all("#<section class=\"episodes-box\">(.*?)</section>#", $data, $diziseason);
//$bolum = $diziseason[1]; //film dizi başlık

preg_match_all("#<div class=\"ordilabel\"><a href=\"(.*?)/sezon-(.*?)/(.*?)\" data-navigo>(.*?)</a></div>#", $data, $diziseason);
$bolume = $diziseason[1]; //film dizi başlık
$bolumel = $diziseason[2]; //film dizi başlık
$bolumeli = $diziseason[3]; //film dizi başlık
$bolumead = $diziseason[4]; //film dizi başlık
$link = $bolume[1] . '/sezon-' . $bolumel[2] . '/' . $bolumeli[3];





$adi = $title[1]; //film dizi başlık
$altadi = $title[2]; //alt başlık
$aciklama = $acik[2]; //açıklama
$resi = $img[2]; //resim  ayarları


//dizi veya film resim kontrolü
if ($resi[0] == null) {
    $resim = $altimg[1];
} else {
    $resim = $img[2];
}

//dizi izleme linki
if ($ilkbolum[0] == null) {
    $serilink = $izli[1]; // izleme linkleri serileştiriliyor varsa

} else {
    $urlm = "https://sinefy.com" . $ilkbolum[0];
    $datam = curl($urlm, $e_id, $v_lang);
    preg_match_all("#class=\"ui pointing secondary menu\">(.*?)</div>#", $datam, $izli);
    $serilink = $izli[1];
}



for ($i = 0; $i < count($adi); $i++) {
    $seri = $serilink[$i];
    preg_match_all("#<a href=\"(.*?)\" class=\"ui pointing(.*?) title=\"(.*?)\" data-navigo><i class=\"mofylag (.*?) mr-xs\"></i>(.*?)</a>#", $seri, $seril);
    $izlelink = $seril[1];
    $izlelinktit = $seril[5];



    if (!isset($json[0])) {
        $json[0] = [
            "ilk" => $inftab[$i],
            "adi" => $adi[$i],
            "yil" => $altadi[$i],
            "resim" => $resim[$i],
            "aciklama" => $aciklama[$i],
            'bolume' => [],
            'values' => []
        ];
    }



    for ($in = 0; $in < count($izlelink); $in++) {

        $json[0]['values'][] = ['link' => $izlelink[$in], 'title' => $izlelinktit[$in]];
    }


    for ($iw = 0; $iw < count($bolume); $iw++) {
        $json[0]['bolume'][] = ['linkq' => $bolume[$iw], 'ad' => $bolumead[$iw], 'link' => $bolume[$iw] . '/sezon-' . $bolumel[$iw] . '/' . $bolumeli[$iw], 'link1' => $bolumel[$iw]];
    }
}


$json = json_encode($json, true);
echo $json;
