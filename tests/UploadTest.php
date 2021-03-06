<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class UploadTest extends TestCase
{
    /**
     * Test that getting a raw line from the file, the
     * output is an array with the content in the
     * correct places.
     */
    public function testOutputContentByLines(): void
    {
        $upload = new UploadFiles();

        $this->assertEquals([ 0 => [
            'title'       => 'Ms',
            'initial'     => 'A',
            'forename'    => 'Ana',
            'surname'     => 'Carrasco'
        ]],
            $upload->outputContentByLines(['Ms A Ana Carrasco'])
        );
    }

    public function testOutputContentByLinesExampleTwo(): void
    {
        $upload = new UploadFiles();

        $this->assertEquals([
            0 => [
                "personOne"=> [
                    "title" => "Ms",
                    "initial" => "A",
                    "forename" => "Ana",
                    "surname" => "Carrasco"
                ],
                "personTwo" => [
                    "title" => "Mr",
                    "initial" => null,
                    "forename" => NULL,
                    "surname" => "Smith"
                ]
            ]
        ],
            $upload->outputContentByLines(['Ms A Ana Carrasco & Mr Smith'])
        );
    }

    public function testOutputContentByLinesExampleThree(): void
    {
        $upload = new UploadFiles();

        $this->assertEquals([
            0 => [
                "personOne"=> [
                    "title" => "Ms",
                    "initial" => "A",
                    "forename" => "Ana",
                    "surname" => "Carrasco"
                ],
                "personTwo" => [
                    "title" => "Mr",
                    "initial" => null,
                    "forename" => NULL,
                    "surname" => "Carrasco"
                ]
            ]
        ],
            $upload->outputContentByLines(['Ms A Ana Carrasco & Mr'])
        );
    }

    public function testOutputContentByLinesExampleFour(): void
    {
        $upload = new UploadFiles();

        $this->assertEquals([ 0 => [
            'title'       => null,
            'initial'     => 'A',
            'forename'    => 'Ana',
            'surname'     => 'Carrasco'
        ]],
            $upload->outputContentByLines(['A Ana Carrasco'])
        );
    }

    public function testOutputContentByLinesExampleFive(): void
    {
        $upload = new UploadFiles();

        $this->assertEquals([ 0 => [
            'title'       => null,
            'initial'     => null,
            'forename'    => null,
            'surname'     => 'Carrasco'
        ]],
            $upload->outputContentByLines(['Carrasco'])
        );
    }

    /**
     * Tests that the previous method uses correctly this one
     * which transforms an array with elements of the raw file
     * line into an organized array with the elements.
     */
    public function testGetPersonArray(): void
    {
        $upload = new UploadFiles();

        $this->assertEquals(
            [
                'title'       => 'Ms',
                'initial'     => 'A',
                'forename'    => 'Ana',
                'surname'     => 'Carrasco'
            ],
            $upload->getPersonArray(['Ms', 'A', 'Ana', 'Carrasco'])
        );
    }
}
