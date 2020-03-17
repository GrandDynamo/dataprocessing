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
    public abstract function parseArray(array $array): void;

    /**
     * Get the parsed content.
     *
     * @return string
     */
    public abstract function getParsedContent(): string;
}
 