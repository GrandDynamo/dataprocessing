<?php

header ("Content-Type:text/xml");

$student_info = array(
    array(
        'name' => "John",
        'lastname' => "Don",
        'pesel' => "987987",
    ),
    array(
        'name' => "Mike",
        'lastname' => "Evans",
        'pesel' => "89779",
    )
);



$xml_student_info = new SimpleXMLElement("<?xml version=\"1.0\"?><student_info></student_info>");

function array_to_xml($student_info, $xml_student_info) {
    foreach($student_info as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_student_info->addChild("$key");
                array_to_xml($value, $subnode);
            }
            else{
                $subnode = $xml_student_info->addChild("person");
                array_to_xml($value, $subnode);
            }
        }
        else { 
            $xml_student_info->addChild("$key","$value");
        }
    }
}

array_to_xml($student_info, $xml_student_info);
echo $xml_student_info->asXML();