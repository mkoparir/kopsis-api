<?php
function curl($url, $eid, $vlang)
{
	$data = "e_id=".$eid . "&v_lang=".$vlang."&type=get_whatwehave";
	$useragent = "Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/W.X.Y.Z‡ Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)";

	$ct = curl_init();
	
	curl_setopt_array($ct, Array(
		CURLOPT_URL => $url,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array("X-Requested-With: XMLHttpRequest"),
		CURLOPT_REFERER => $url,
		CURLOPT_USERAGENT =>  $useragent,
		CURLOPT_HEADER => false,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => 'schn=csrf',
		CURLOPT_POSTFIELDS => $data
	));
	
	$html = curl_exec($ct);
	
	$dochtml = new DOMDocument();
	@$dochtml->loadHTML($html);
	$xpath = new DOMXpath($dochtml);
	
	// Auth
	if(isset($xpath->query("//input[@name='r']/@value")->item(0)->textContent)){
	
		$action = $url . $xpath->query("//form/@action")->item(0)->textContent;
		$r = $xpath->query("//input[@name='r']/@value")->item(0)->textContent;
		$jschl_vc = $xpath->query("//input[@name='jschl_vc']/@value")->item(0)->textContent;
		$pass = $xpath->query("//input[@name='pass']/@value")->item(0)->textContent;
	 
		// Generate curl post data
		$post_data = array(
			'r' => $r,
			'jschl_vc' => $jschl_vc,
			'pass' => $pass,
			'jschl_answer' => ''
		);
	
		curl_close($ct); // Close curl
	
		return $html;
	
		$ct = curl_init();
		
		// Post cloudflare auth parameters
		curl_setopt_array($ct, Array(
			CURLOPT_HTTPHEADER => array(
				'Accept: application/json, text/javascript, */*; q=0.01',
				'Accept-Language: ro-RO,ro;q=0.8,en-US;q=0.6,en-GB;q=0.4,en;q=0.2',
				'Referer: '. $url,
				'Origin: '. $url, 
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'X-Requested-With: XMLHttpRequest'
			),
			CURLOPT_URL => $action,
			CURLOPT_REFERER => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => $useragent,
			CURLOPT_POSTFIELDS => http_build_query($post_data)
	
		));
	
		$html_reponse = curl_exec($ct);

		curl_close($ct); // Close curl
	
	}else{

		// Already auth
		//return $html;
	return str_replace(["\t","\r","\n"],null,$html);
	}
	
}    

