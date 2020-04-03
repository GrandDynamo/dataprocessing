<?php

namespace classes\routing;


class Request
{
  function __construct()
  {
    $this->bootstrapSelf();
  }

  /**
   * Copies $_SERVER properties and values to the Request class properties.
   *
   * @return void
   */
  private function bootstrapSelf()
  {
    foreach ($_SERVER as $key => $value) {
      $this->{$this->toCamelCase($key)} = $value;
    }
  }

  private function toCamelCase($string)
  {
    $result = strtolower($string);

    preg_match_all('/_[a-z]/', $result, $matches);

    foreach ($matches[0] as $match) {
      $c = str_replace('_', '', strtoupper($match));
      $result = str_replace($match, $c, $result);
    }

    return $result;
  }

  public function getBody()
  {
    if ($this->requestMethod === "GET") {
      return;
    }

    if ($this->requestMethod === "POST") {
      $body = array();
      foreach ($_POST as $key => $value) {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        //Commented out, this can also be used. I need to look into the safety of using this instead of filter_input() function.
        // $body[$key] = $value;
      }
      return $body;
    }
    if ($this->requestMethod === "PUT") {
      parse_str(file_get_contents('php://input'), $_PUT);
      $body = array();
      foreach ($_PUT as $key => $value) {

        $body[$key] = $value;
      }
      return $body;
    }
    if ($this->requestMethod === "DELETE") {
      return;
    }
  }
}
