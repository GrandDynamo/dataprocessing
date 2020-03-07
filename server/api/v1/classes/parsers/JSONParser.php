<?php

namespace classes\parsers;

/**
 * Class for parsing things into a JSON format.
 */
class JSONParser extends Parser
{
    private ?string $JSONString;
    public function __construct()
    {
        $this->JSONString = null;
    }

    /**
     * Parses an array into a JSON string.
     *
     * @param array $array
     * @return void
     */
    public function parseArray(array $array): void
    {
        $this->JSONString = json_encode($array);
    }

    /**
     * Returns the parsed contents in a JSON string.
     *
     * @return void
     */
    public function getParsedContent(): string
    {
        return $this->JSONString;
    }
}
