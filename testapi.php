#!/usr/bin/php
<?php
$q = "bells";
$target_url='http://ws.audioscrobbler.com/2.0/format=json&method=tag.gettopartists&api_key=....&tag=' . $q . '';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$return = curl_exec($ch);

echo $return;
