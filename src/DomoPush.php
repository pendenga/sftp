<?php

namespace Pendenga\Sftp;

use phpseclib\Net\SFTP;
use phpseclib\Crypt\RSA;
use Psr\Log\LoggerInterface;

/**
 * Class DomoPush
 * @package Pendenga\Sftp
 */
class DomoPush extends Push
{
    /**
     * @param $dataset_id
     * @return string
     */
    public function getRemoteFilename($dataset_id):string {
        return $dataset_id . '.csv';
    }
}
