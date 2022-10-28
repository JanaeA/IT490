<?php
use LastFmApi\Api\AuthApi;
use LastFmApi\Api\ArtistApi;

class LastFm {
	private $apiKey;
	private $artistApi;

	public function __construct() {
		$this->apiKey = 'f199b01d3295f26ab3086c39aeedde8e';
		$auth = new AuthApi('setsession', array('apiKey' => $this->apiKey));
		$this->artistApi = new ArtistApi($auth);
	}
	public function getBio($artist) {
		$artistInfo = $this->artistApi->getInfo(array("artist" => $artist));
		return $artistInfo['bio'];
	}
}

function doSearch($artist) {







}


?>

