<?php

namespace Pendenga\Sftp;

use phpseclib\Net\SFTP;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Push
 * @package Pendenga\Sftp
 */
class Push
{
    use LoggerAwareTrait;

    /**
     * @var SftpLoaderInterface
     */
    protected $sftp;

    /**
     * Push constructor.
     * @param SftpLoaderInterface  $sftp
     * @param LoggerInterface|null $logger
     */
    public function __construct(SftpLoaderInterface $sftp, LoggerInterface $logger = null)
    {
        $this->setLogger($logger ?? new NullLogger());
        $this->sftp = $sftp;
        $this->sftp->setLogger($logger);
    }

    /**
     * @param string $local_filename
     * @param string $remote_filename
     * @return void
     * @throws SftpException
     */
    public function push(string $local_filename, string $remote_filename): void {
        $this->logger->debug("SFTP PUT: {$local_filename} -> {$remote_filename}");
        if (!$this->sftp->getSFTP()->put($remote_filename, $local_filename, SFTP::SOURCE_LOCAL_FILE)) {
            throw new SftpException();
        }
        $this->logger->debug("SFTP Done");
    }
}
