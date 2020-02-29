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
    public function __construct()
    {
        $this->groupedNodeName = null;
        $this->XMLTree = null;
    }

    /**
     * Parse an array into XML.
     *
     * @param array $array
     * @return void
     */
    public function parseArrayToXML(array $content, string $groupedNodeName): void
    {
        $this->groupedNodeName = $groupedNodeName;
       
        $this->XMLTree = $this->generateXMLTree($content);
        
    }

    // echo $xml->asXML();
    // $this->arrayToXml($content);
   

    private function generateXMLTree($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml;

        // When root isnt defined use predefined root.
        if ($_xml === null) {
            $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
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
