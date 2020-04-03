<?php

namespace classes\parsers;

use SimpleXMLElement;

/**
 * Class that parses things into a XML format.
 */
class XMLParser extends Parser
{
    private ?string $groupedNodeName;
    private ?string $XMLTree;
    private string $rootNodeName;
    private ?string $schemaName;

    public function __construct(string $rootNodeName, string $groupedNodeName, ?string $schemaName)
    {
        $this->groupedNodeName = null;
        $this->XMLTree = null;
        $this->schemaName = $schemaName;
        $this->rootNodeName = $rootNodeName;
        $this->groupedNodeName = $groupedNodeName;
    }


    /**
     * Parse an array into XML.
     *
     * @param array $array
     * @return void
     */
    public function parseArray(array $array): void
    {
        $this->XMLTree = $this->generateXMLTree($array);
    }

    private function generateXMLTree($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml;

        if ($_xml === null) {
            // When root isnt defined use predefined root name (used in recursion).
            $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<' . $this->rootNodeName . '/>');
            $_xml->addAttribute("xmlns:xmlns:xsi", "http://www.w3.org/2001/XMLSchema/");

            // Check if schema name is set. 
            if ($this->schemaName) {
                $_xml->addAttribute("xsi:schemaLocation", "http://localhost/dataprocessing/server/api/v1/schemas/xsd/" . $this->schemaName . ".xsd");
            }
        }

        // Visit all key value pair 
        foreach ($array as $k => $v) {
            // If there is nested array then 
            if (is_array($v)) {
                $k = $this->groupedNodeName;
                // Call function for nested array 
                $this->generateXMLTree($v, $k, $_xml->addChild($k));
            } else {
                // Simply add child element.  
                $_xml->addChild($k, $v);
            }
        }
        return $_xml->asXML();
    }

    /**
     * Returns the parsed content in a XML string.
     *
     * @return string
     */
    public function getParsedContent(): string
    {
        return $this->XMLTree;
    }
}
