<?php

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://www.nytimes.com',
    CURLOPT_USERAGENT => 'mozilla firefox'
]);
$curl_scraped_page = curl_exec($curl);
$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($curl_scraped_page);
$xpath = new DOMXPath($doc);
$hrefs = $xpath->query('//a[@href]');
$hostname='localhost';
$username='user';
$password='password';

$conn = new PDO("mysql:host=$hostname;dbname=dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach($hrefs as $href) {
var_dump($href->getAttribute('href'));  
$link = $href->getAttribute('href');
echo "\nvisiting link: $link... \n\n";	// use curl again, but this time to get the html document from a link that was on yahoo
	curl_setopt_array($curl, [
    	CURLOPT_RETURNTRANSFER => 1,
    	CURLOPT_URL => $link,
    	CURLOPT_USERAGENT => 'mozirra firefucks'
	]);
	$curl_scraped_page = curl_exec($curl);	
	$doc->loadHTML($curl_scraped_page);	
	$xpath = new DOMXPath($doc);	
	$hrefs2 = $xpath->query('//a[@href]');	echo "\tthe links contained on the page: $link are:\n";
	
	foreach ($hrefs2 as $href2) {
		$link = $href2->getAttribute('href');
		echo "\t\t".$link."\n";
		$stmt = $conn->prepare("insert into links (linkName) values (?)");	
		$stmt->execute([$link]);
	}		

}
curl_close($curl);

