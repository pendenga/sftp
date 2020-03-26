<?php

namespace Pendenga\Sftp;

use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;
use Psr\Log\LoggerAwareInterface;

/**
 * Interface SftpLoaderInterface
 * The intention is to abstract the RSA setup so it can be done in a consistent way. Your organization is likely to
 * have some policies around storage of sensitive keys. Use an implementation of this interface to hide all that and
 * make all the code do it consistently. See /test/IniLoader.php for an example implementation.
 * @package Pendenga\Sftp
 */
interface SftpLoaderInterface extends LoggerAwareInterface
{
    /**
     * @return SFTP
     * @throws SftpException
     */
    public function getSFTP(): SFTP;

    /**
     * @param RSA $rsa
     * @throws SftpException
     */
    public function setKey(RSA $rsa): void;
}
