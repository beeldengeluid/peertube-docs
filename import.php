<?php

	$api_url = 'https://peertube.beeldengeluid.nl/api/v1';

	function get_curl($url) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$json = curl_exec($ch);
		curl_close($ch);

		$array = json_decode($json, TRUE);

		return $array;

	}

	function post_curl($url, $array_data, $auth_header) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array_data));
		$json = curl_exec($ch);
		curl_close($ch);

		$array = json_decode($json, TRUE);

		return $array;

	}

	// Get client 

	$url = $api_url.'/oauth-clients/local';

	$array_client = get_curl($url);
	$client_id = $array_client['client_id'];
	$client_secret = $array_client['client_secret'];

	// Get user token

	$url = $api_url.'/users/token';

	$array_user['client_id'] = $client_id;
	$array_user['client_secret'] = $client_secret;
	$array_user['grant_type'] = 'password';
	$array_user['response_type'] = 'code';

	$array_user['username'] = 'nisv';
	$array_user['password'] = 'openbeelden';

	$array_token = post_curl($url, $array_user, '');

	$auth_header = 'Authorization: '.$array_token['token_type'].' '.$array_token['access_token'];

	// Upload video

	$url = $api_url.'/videos/imports'; 

	$array_video['name'] = 'Test2';
	$array_video['channelId'] = 2;
	$array_video['targetUrl'] = 'https://www.openbeelden.nl/files/56/56216.56205.BG_9541.ogv';
	$array_video['language'] = 'nl';
	$array_video['licence'] = '7';
	$array_video['privacy'] = '1';
	$array_video['commentsEnabled'] = '1';
	$array_video['description'] = "Weeknummer 34-05\nBioscoopjournaals waarin Nederlandse onderwerpen van een bepaalde week worden gepresenteerd.\n\nVoorbereidingen voor carnaval in de dierenwereld: een paard imiteert Charlie Chaplin. -Div. shots als Charlie Chaplin vermomd paard; -div. titel(s)/tussentitel(s).\n\nPolygoon-Profilti (producent) / Nederlands Instituut voor Beeld en Geluid (beheerder)";

	//$array_video['originallyPublishedAt'] = '1934-01-29';


	// https://www.openbeelden.nl/files/11/53/1153654.1153651.WEEKNUMMER483-HRE0001B08B_2810800_2962360.mp4; https://www.openbeelden.nl/files/11/53/1153656.1153651.WEEKNUMMER483-HRE0001B08B_2810800_2962360.mp4; https://www.openbeelden.nl/files/11/53/1153651.WEEKNUMMER483-HRE0001B08B_2810800_2962360.mp4; https://www.openbeelden.nl/files/11/53/1153658.1153651.WEEKNUMMER483-HRE0001B08B_2810800_2962360.webm; https://www.openbeelden.nl/files/11/53/1153660.1153651.WEEKNUMMER483-HRE0001B08B_2810800_2962360.ogv; https://www.openbeelden.nl/files/11/53/1153662.1153651.WEEKNUMMER483-HRE0001B08B_2810800_2962360.ogv; https://www.openbeelden.nl/files/11/53/1156397.1153651.WEEKNUMMER483_HRE0001B08B_2810800_2962360.m3u8; https://www.openbeelden.nl/images/1153894/Wereldconferentie_der_Kerken_openingsdienst_in_de_Nieuwe_Kerk_zitting_in_het_Concertgebouw_%281_15%29.png


	// https://www.openbeelden.nl/files/56/56219.56205.BG_9541.mp4; https://www.openbeelden.nl/files/56/56213.56205.BG_9541.ogv; https://www.openbeelden.nl/files/56/56216.56205.BG_9541.ogv; https://www.openbeelden.nl/files/56/56225.56205.BG_9541.m3u8; https://www.openbeelden.nl/files/56/56222.56205.BG_9541.ts; https://www.openbeelden.nl/files/56/56209.56205.BG_9541.mpeg; https://www.openbeelden.nl/files/56/56205.BG_9541.mpg; https://www.openbeelden.nl/images/604258/Persoonlijke_kampioenschappen_beugelen_in_Stramproy_%280_41%29.png

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

	// Loop items on same cURL handler

	curl_setopt($ch, CURLOPT_POSTFIELDS, $array_video);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array($auth_header));
	$json = curl_exec($ch);
	
	$array = json_decode($json, TRUE);
	print_r($array);

	// End loop

	curl_close($ch);

?>