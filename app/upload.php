<?php

Class UploadFiles
{
    protected $titles;
    protected $persons;

    /**
     * UploadFiles constructor.
     */
    public function __construct()
    {
        $this->persons = [];
        $this->titles = ['Mr', 'Ms', 'Mrs', 'Mister', 'Miss', 'Dr', 'Doctor', 'Prof'];
    }

    /**
     * Loads the base html template
     */
    public function init()
    {
        echo file_get_contents('../views/index.html');
    }

    public function process(array $data)
    {
        try {
            if (!empty($data['file']['tmp_name'])) {
                $lines = $this->getCleanArray($data);
                return $this->outputContentByLines($lines);
            }
        } catch(Exception $e){

        }
    }

    /**
     * Returns a clean array with the content
     * by lines.
     *
     * @param array $data
     * @return array
     */
    protected function getCleanArray(array $data): array
    {
        $content = file_get_contents($data['file']['tmp_name']);
        $lines = explode(',', $content);
        unset($lines[0]); // remove first line
        unset($lines[count($lines)]); // remove last line

        return $lines;
    }

    /**
     * @param array $lines
     * @return array
     */
    protected function outputContentByLines(array $lines): array
    {
        // Check if the input has one or two people
        foreach($lines as $fileLine) {
            if (stripos($fileLine, 'and') || stripos($fileLine, '&')) {

                if (stripos($fileLine, '&')) {
                    $personsToSave = explode(' & ', $fileLine);
                } else {
                    $personsToSave = explode(' and ', $fileLine);
                }

                // Generate the main person
                $personTwo = $this->getPersonArray(explode(' ', $personsToSave[1]));

                // Generate secondary person
                $personOne = $this->getPersonArray(explode(' ', $personsToSave[0]));

                // Add, if needed, data from main person to the secondary
                if (is_null($personOne['last_name'])) {
                    $personOne['last_name'] = $personTwo['last_name'];
                }

                array_push($this->persons, [
                    'personOne' => $personOne,
                    'personTwo' => $personTwo,
                ]);

            } else {
                array_push($this->persons, $this->getPersonArray(explode(' ', $fileLine)));
            }
        }
        return $this->persons;
    }

    /**
     * @param array $personElements
     * @return null[]
     */
    protected function getPersonArray(array $personElements): array
    {
        $newPerson = [
            'title'         => null,
            'initial'       => null,
            'first_name'    => null,
            'last_name'     => null,
        ];

        foreach($personElements as $key => $element) {
            $element = trim(preg_replace('/\s\s+/', ' ', $element));

            if (in_array($element, $this->titles)) {
                $newPerson['title'] = $element;
            } else {
                // Not a title, check for the rest of elements
                if (
                    strlen($element) === 1 ||
                    (strlen($element) === 2 && strpos($element, '.') !== false)
                ) {
                    $newPerson['initial'] = $element;
                } else {
                    // Not the title or the initial of the person, check the last two options
                    if ($key === count($personElements)-1) { // if last in array surname
                        $newPerson['last_name'] = $element;
                    } else {
                        $newPerson['first_name'] = $element;
                    }
                }
            }

        }
        return $newPerson;
    }

}
