<?php

namespace classes\parsers;

abstract class Parser
{
    public function __construct()
    {
    }

    /**
     * Parse an array.
     *
     * @param array $array
     * @return void
     */
    public abstract function parseArrayToXML(array $array, string $groupedNode): void;

    /**
     * Get the parsed content.
     *
     * @return void
     */
    public abstract function getParsedContent(): string;
}
 