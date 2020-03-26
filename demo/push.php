<?php

use Pendenga\File\Ini;
use Pendenga\Log\EchoLogger;
use Pendenga\Sftp\Push;
use Pendenga\Sftp\Test\IniLoader;

include_once __DIR__ . '/../vendor/autoload.php';

try {
    // create local file to push
    $local_file = '/tmp/sftp-example.csv';
    $local_data = "letter,number\na,1\nb,2\nc,3";
    file_put_contents($local_file, $local_data);
    chmod($local_file, 0777);

    // get these values from ini
    $domo_dataset_id = Ini::get('DOMO_DATASET_ID');

    // send to domo using normal push
    $logger = new EchoLogger();
    $ini = new IniLoader($logger);
    $push = new Push($ini, new EchoLogger());
    $push->push($local_file, $domo_dataset_id . 'csv');
    print "Ok\n";
} catch (Exception $e) {
    print "Failed: " . $e->getMessage() . "\n";
}
