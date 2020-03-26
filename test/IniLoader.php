<?php

namespace Pendenga\Sftp\Test;

use Pendenga\File\FileNotFoundException;
use Pendenga\File\Ini;
use Pendenga\Sftp\SftpException;
use Pendenga\Sftp\SftpLoaderInterface;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class IniLoader
 * An example implementation of a SftpLoaderInterface. In a secure environment, you'd want to use Vault or something
 * else to keep these keys. In this example, we'll just be getting them from an ini file, just to show the abstraction.
 * See usage in /demo/domo.php
 * @package Pendenga\Sftp\Test
 */
class IniLoader implements SftpLoaderInterface
{
    use LoggerAwareTrait;

    /**
     * @var RSA
     */
    protected $key;

    /**
     * @var SFTP
     */
    protected $sftp;

    /**
     * IniLoader constructor.
     * @param LoggerInterface|null $logger
     * @throws SftpException
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->setLogger($logger ?? new NullLogger());
        $this->logger->debug(__METHOD__);
        $this->setKey(new RSA());
    }

    /**
     * @inheritDoc
     */
    public function getSFTP(): SFTP
    {
        $this->logger->debug(__METHOD__);
        try {
            $remote_path = Ini::get('SFTP_REMOTE_PATH');
            $remote_user = Ini::get('SFTP_USERNAME');
            $this->sftp = new SFTP($remote_path);
            if (!$this->sftp->login($remote_user, $this->key)) {
                throw new SftpException(sprintf('FTP Login Failed for %s@%s', $remote_user, $remote_path));
            }
        } catch (FileNotFoundException $e) {
            throw new SftpException($e->getMessage());
        }

        return $this->sftp;
    }

    /**
     * @inheritDoc
     */
    public function setKey(RSA $key): void
    {
        $this->logger->debug(__METHOD__);
        $this->key = $key;
        try {
            // if ($password = Ini::get('RSA_PASSWORD')) {
            //     // password is optional
            //     $this->key->setPassword($password);
            // }

            $base64_rsa = Ini::get('RSA_KEY_BASE64');
            $this->logger->debug('rsa key: ' . $base64_rsa);
            // if ($base64_rsa = Ini::get('RSA_KEY_BASE64')) {
                // load Base64 Key
                $this->key->loadKey(base64_decode($base64_rsa));
            // } elseif ($text_rsa = Ini::get('RSA_PRIVATE_KEY')) {
            //     // load key
            //     $this->key->loadKey($text_rsa);
            // } else {
            //     throw new SftpException('RSA Key not loaded');
            // }
        } catch (FileNotFoundException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
