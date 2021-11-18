<?php
require "index.php";

$kelime = $_POST['qr'];

$e_id = '';
$v_lang = '';
$url = "https://sinefy.com/search?qr=".$kelime;

$data = curl($url, $e_id, $v_lang);


echo $data;
