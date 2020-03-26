<?php

use Pendenga\File\Ini;
use phpDocumentor\Reflection\Types\Object_;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;

include_once __DIR__ . '/../vendor/autoload.php';

try {

    // create local file to push
    $local_file = '/tmp/sftp-example.csv';
    $local_data = "letter,number\na,1\nb,2\nc,3";
    file_put_contents($local_file, $local_data);
    chmod($local_file, 0777);

    // get these values from ini
    $sftp_remote_path = Ini::get('SFTP_REMOTE_PATH');
    $sftp_username = Ini::get('SFTP_USERNAME');
    $rsa_password = Ini::get('RSA_PASSWORD');
    $rsa_key_base64 = Ini::get('RSA_KEY_BASE64');
    $domo_dataset_id = Ini::get('DOMO_DATASET_ID');
    $remote_file = $domo_dataset_id . '.csv';

    // do it manually
    $sftp = new SFTP($sftp_remote_path);
    $rsa = new RSA();
    $rsa->setPassword($rsa_password);
    $rsa->loadKey(base64_decode($rsa_key_base64));
    $sftp->login($sftp_username, $rsa);
    $sftp->put($remote_file, $local_file, SFTP::SOURCE_LOCAL_FILE);

    print "Ok\n";
} catch (Exception $e) {
    print "Failed: " . $e->getMessage() . "\n";
}
