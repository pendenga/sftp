<?php

namespace Pendenga\Sftp\Test;

use Pendenga\Domo\Push;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * Class PushTest
 * @package Pendenga\Sftp\Test
 */
class PushTest extends TestCase
{
    // This is a test dataset in Domo
    protected $dataset_id = '9243d221-7070-4446-8338-1bf86d91fb8a';
    protected $local_file = '/tmp/sftp-example.csv';
    protected $local_csv = "letter,number\na,1\nb,2\nc,3";

    /**
     * @throws \Exception
     */
    public function testPush()
    {
        // write to file, because push expects file
        $fh = fopen($this->local_file, 'w');
        fwrite($fh, $this->local_csv);
        $this->assertFileExists($this->local_file);

        // push to Domo
        // $push = new Push($this->dataset_id, new Dev(), new NullLogger());
        // $push->pushFromDev(true);
        // $this->assertTrue($push->push($this->local_file));

        // clean up file
        unlink($this->local_file);
    }
}
