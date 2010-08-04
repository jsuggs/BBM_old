<?php

define('HTMLDIR',realpath(dirname(__FILE__) . '/html'));

if ($handle = opendir(HTMLDIR)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            $file = HTMLDIR . "/$file";
            echo $file . "\n";
            $doc = new DOMDocument();
            $doc->loadHTMLFile($file);
            continue;

            $table = $doc->getElementById('team_schedule');
            $tds = $table->getElementsByTagName('td');

            foreach ($tds as $td) {
                echo $td->nodeValue . "\n";
            }
        }
    }
}
