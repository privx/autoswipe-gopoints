<?php

/**
 * An Auto Swipe form GO-POINTS on GO-JEK
 *
 * PHP version 5
 *
 * @category	Auto Based
 * @package		Auto Swipe GO-POINTS
 * @author		BIMA_GATES <akujuga@mailnesia.com>
 * @source    https://www.go-jek.com/go-points/
 */

$headers = headers(); // Do not touch anything you see here, edit the full headers down there

/**
 * Executing the programs
 *
 * @notes			You need to change your Headers right down there
 *
 * @param string	$headers    The Headers
 * @return object	The Auto's payload as a PHP object
 * @uses			jsonDecode
 * @uses			Looping while/for
*/

$tokenleft = json_decode(checkWallet($headers),True)['tokens_balance'];

for($a=0;$a<$tokenleft;$a++){
	
	$cW = json_decode(checkWallet($headers),True);
	$cP = json_decode(checkPoints($headers),True);
	$no = $a+1;
	
	$result						= array();	
	$result['no']				= $no;
	$result['redeem_points']	= "Points ".$cW['points_balance']." - ".$cW['tokens_balance']." tokens left";
	$result['info']				= "Poin ".$cP['data']['points'];
	$result['status']			= redeemPoints($headers,$cP['data']['points_token_id']);
	print_r($result);
	echo PHP_EOL;
}

function checkWallet($headers){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://api.gojekapi.com/gopoints/v1/wallet/points-balance');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		$hasil = 'Error:' . curl_error($ch);
	}else{
		$hasil = $result;
	}
	curl_close($ch);
	return $hasil;
}

function checkPoints($headers){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://api.gojekapi.com/gopoints/v2/next-points-token');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		$hasil = 'Error:' . curl_error($ch);
	}else{
		$hasil = $result;
	}
	curl_close($ch);
	return $hasil;
}

function redeemPoints($headers,$id){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://api.gojekapi.com/gopoints/v1/redeem-points-token');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"points_token_id\":\"$id\"}");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		$hasil = 'Error:' . curl_error($ch);
	}else{
		$hasil = $result;
	}
	curl_close($ch);
	return $hasil;
}

function headers(){
	$headers = array();
	$headers[] = 'X-Appversion: 3.30.2';
	$headers[] = 'X-UniqueId: 3fb2d2562795bd47';
	$headers[] = 'X-Platform: Android';
	$headers[] = 'X-Appid: com.gojek.app';
	$headers[] = 'Accept: application/json';
	$headers[] = 'Content-Type: application/json';
	return $headers;
}