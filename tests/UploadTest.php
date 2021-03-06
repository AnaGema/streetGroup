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
