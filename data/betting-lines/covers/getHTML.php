<?php

echo "Getting covers data\n\n";

define('THIS_DIR',realpath(dirname(__FILE__)));

$teams = array();

if (($handle = fopen(THIS_DIR . '/teamMap.csv','r')) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) { 
        $teams[$data[0]] = $data[1];
    }
}
fclose($handle);

for ($year = 1999; $year <= 2010; $year++) {
    echo "Getting year $year\n";
    foreach ($teams as $team => $map) {
        $url = "http://www.covers.com/pageLoader/pageLoader.aspx?page=/data/mlb/teams/pastresults/{$year}/team{$map}.html&t=0";
        //$url = 'http://www.google.com';
        $file = THIS_DIR . '/html/' . $team . '/' . $year;

        if (($fh = fopen($file,'wb')) === FALSE) {
            die('invalid file: ' . $file);
        }
        $curl = curl_init($url);

        curl_setopt($curl,CURLOPT_FILE,$fh);
        curl_setopt($curl,CURLOPT_HEADER, false);

        curl_exec($curl);
        curl_close($curl);

        fclose($fh);
        echo "$url => $file\n";
        sleep(1);
    }
}
