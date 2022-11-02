<?php
class Serp {

	public $apiKey;
	function __construct($api) {
		$this->apiKey = $api;

	}
	function getEvents($location) {
		$curl = curl_init("https://serpapi.com/search.json?engine=google_events&q=Concerts+in+$location&hl=en&gl=us&api_key=".$this->apiKey);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT, 3);
		$data = curl_exec($curl);
		curl_close($curl);
		print_r($data);
		return $data;
	}
}
