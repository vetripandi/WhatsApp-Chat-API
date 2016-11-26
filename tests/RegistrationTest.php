<?php

class RegistrationTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        // create the directory to store the identity file
        mkdir(__DIR__ . '/_files');
    }

    protected function tearDown()
    {
        if (file_exists(__DIR__ . '/_files/id.1234567890.dat')) {
            unlink(__DIR__ . '/_files/id.1234567890.dat');
        }
        rmdir(__DIR__ . '/_files');
    }

    /**
     * This is the current behaviour, when no filepath is provided
     *
     * @covers Registration::__construct
     * @covers Registration::buildIdentity
     */
    public function testRegistrationIdentityfileCanBeCreatedWithoutArguments()
    {
        $number = '1234567890';

        require_once __DIR__ . '/../src/Registration.php';
        $registration = new Registration($number, false, false);

        require_once __DIR__ . '/../src/Constants.php';
        $expectedFile = sprintf('%s%s%sid.%s.dat', __DIR__ . '/../src', DIRECTORY_SEPARATOR, Constants::DATA_FOLDER.DIRECTORY_SEPARATOR, $number);

        $this->assertTrue(file_exists($expectedFile));
    }

    /**
     * This is the current behaviour, when the filepath is the id file
     * instead of a directory (a common workaround for custom files)
     *
     * @covers Registration::__construct
     * @covers Registration::buildIdentity
     */
    public function testRegistrationIdentityfileCanBeCreatedWithFile()
    {
        $number = '1234567890';
        $filePath = __DIR__ . '/_files/id.' . $number . '.dat';

        require_once __DIR__ . '/../src/Registration.php';
        $registration = new Registration($number, false, $filePath);

        $expectedFile = $filePath;

        $this->assertTrue(file_exists($expectedFile));
    }

    /**
     * The current behaviour, now creating the identity file when
     * only the path was provided (as the code flow suggests).
     *
     * @covers Registration::__construct
     * @covers Registration::buildIdentity
     */
    public function testRegistrationIdentityfileCanBeCreatedWithPath()
    {
        $number = '1234567890';
        $filePath = __DIR__ . '/_files';

        require_once __DIR__ . '/../src/Registration.php';
        $registration = new Registration($number, false, $filePath);

        $expectedFile = sprintf('%s/id.%s.dat', $filePath, $number);

        $this->assertTrue(file_exists($expectedFile));
    }
}
