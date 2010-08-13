<?php
error_reporting(0);

define('THIS_DIR',realpath(dirname(__FILE__)));

if ($handle = opendir(THIS_DIR . '/html')) {
    while (false !== ($team = readdir($handle))) {
        if ($team != "." && $team != "..") {
            if ($teamhandle = opendir(THIS_DIR . '/html/' . $team)) {
                while (false !== ($year = readdir($teamhandle))) {
                    if ($year != '.' && $year != '..') {
                        $filepath = THIS_DIR . '/html/' . $team . '/' . $year;
                        $doc = new DOMDocument();
                        if (false === $doc->loadHTMLFile($filepath)) {
                            die("Couldn't load file: $filepath\n");
                        }

                        $tables = $doc->getElementsByTagName('table');
                        foreach ($tables as $table) {
                            if ($table->getAttribute('class') === 'data') {
                                $rows = $table->getElementsByTagName('tr');
                                foreach ($rows as $row) {
                                    if ($row->getAttribute('class') === 'datahead') {
                                    }
                                    else {
                                        $tds = $row->getElementsByTagName('td');

                                        $date = trim($tds->item(0)->nodeValue);
                                        $vs = trim($tds->item(1)->nodeValue);
                                        $result = trim($tds->item(2)->nodeValue);
                                        $awayStarter = trim($tds->item(3)->nodeValue);
                                        $homeStarter = trim($tds->item(4)->nodeValue);
                                        $line = trim($tds->item(5)->nodeValue);
                                        $overUnder = trim($tds->item(6)->nodeValue);

                                        echo "date: $date vs: $vs = $result line= $line o/u: $overUnder\n";
                                    }
                                }
                            }
                        }
                    }
                }
                closedir($teamhandle);
            }
        }
    }
    closedir($handle);
}
