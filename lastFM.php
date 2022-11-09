<?php
class LastFM
{
	public $apiKey;
	function __construct($api)
	{
		$this->apiKey = $api;
	}
	function getInfo($artist)
	{
		$curl =  curl_init("http://ws.audioscrobbler.com/2.0/?method=artist.getInfo&artist=$artist&api_key=".$this->apiKey ."&format=json");
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_HEADER,0);
		curl_setopt($curl,CURLOPT_TIMEOUT,3);
		$data = curl_exec($curl);
		curl_close($curl);
		echo $data;
		return $data;
	}
	function getSimilar($artist)
        {
                $curl =  curl_init("http://ws.audioscrobbler.com/2.0/?method=artist.getSimilar&artist=$artist&api_key=".$this->apiKey . "format=json");
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl,CURLOPT_HEADER,0);
                curl_setopt($curl,CURLOPT_TIMEOUT,3);
                $data = curl_exec($curl);
                curl_close($curl);
                return $data;
        }

}
