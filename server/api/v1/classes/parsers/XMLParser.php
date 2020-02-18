<?php

namespace classes\parsers;

use SimpleXMLElement;

/**
 * Class that parses things into a XML format.
 */
class XMLParser extends Parser
{
    public function __construct()
    {
    }

    /**
     * Parse an array into a XML string.
     *
     * @param array $array
     * @return void
     */
    public function parseArray(array $content, array $nodeNames): void
    {
        var_dump($content);
        $xml = new SimpleXMLElement("<watched/>");
        for ($beginRowCount = 0; $beginRowCount < count($content); $beginRowCount++) {
            
            $node = $xml->addChild("Anime");
            $node->addChild("animeId", $content[$beginRowCount][0]);
            $node->addChild("watchCount", $content[$beginRowCount][1]);
            Header('Content-type: text/xml');
        }
        echo $xml->asXML();
    }

    /**
     * Returns the parsed content in a XML string.
     *
     * @return string
     */
    public function getParsedContent(): string
    {
        return "";
    }
}
