<?php

namespace classes\routing;

class Router
{
    private $request;
    private $supportedHttpMethods = array(
        "GET",
        "POST"
    );

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    function __call($name, $args)
    {
        //BAKA!! <///////////> code.
        // list($route, $method) = $args;



        //GUCCI code
        $route = $args[0];
        $method = $args[1];
        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            echo "yeeeeeeee";
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * 
     * @param route (string)
     */
    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
    }

    /**
     * Resolves a route
     */
    function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);


        //<<<<<<<<<<<<<<<<<<<<MY TESTING CODE>>>>>>>>>>>>>>>>>>>>>>>>
        $arr1 = array(0 => "numberzero", 1 => "numberone", 5 => "numberfive", 6 => "numberzes");
        $arr2 = array(0 => "numberzero", 1 => "numberone", 7 => "numberfive", 6 => "numberzes");

        if ($arr1 === $arr2) {
            var_dump("GELIJK");
        }

        //Loops through de dictionary.
        $uriArray = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $newMethod = "";
        foreach ($methodDictionary as $method => $value) {
            // echo "<br>";
            // echo '<b>FOREACH $methodDictionary</b>';
            // echo "<br>";
            // echo "<pre>";
            // var_dump($method);
            // echo "</pre>";
            // echo "<br>";

            // echo '<b>$uriArray</b>';
            // echo "<pre>";
            // var_dump($uriArray);
            // echo "</pre>";
            // echo "<br>";

            // echo '<b>$routedArray</b>';
            // echo "<pre>";
            $routedArray = explode('/', trim($method, '/'));
            // echo "<pre>";
            // var_dump($routedArray);
            // echo "</pre>";

            $i = 0;
            foreach ($routedArray as $key => $value) {
                // $i++;
                // if($i > 100){
                //     // return;
                //     // exit;
                //     continue;
                // }

                if ($routedArray[$key] === $uriArray[$key]) {
                    echo " <b>Key:</b> " . $key . " <b>Value:</b> " . $value;
                    echo " | Same key value <br>";
                    // continue;
                // break;
                } elseif (preg_match('/{(.*?)}/', $value)) {
                    echo " <b>Key:</b> " . $key . " <b>Value:</b> " . $value;
                    echo " | FOUND variable value <br>";
                    $routedArray[$key] = $uriArray[$key];
                }

                // if (preg_match('/{(.*?)}/', $value)) {
                //     // array_push($replacementItemsArr, $key => $value);
                //     // array_replace($routedArray, $key => $value);
                //     $routedArray[$key] = $uriArray[$key];
                //     // echo "yeet";
                // }
                /**
                 * @todo Fixen dat elke method exploded word en key voor key compared wordt tegen de user ingevoerde exploded url. 
                 * dan checked die per index value elke interation. Wanneer die bij een {} uitkomt wordt het sws true tenzij de user url natuurlijk leeg is.
                 * Als er iets op false komt exit die deze iteratie en gaat die door de naar volgende.
                 * 
                 */
            }
            if ($routedArray === $uriArray) {

                echo "<h1>GELIJK</h1>";
                // echo " <b>Key:</b> " . $key . " <b>Value:</b> " . $value;
                $routedArray = implode("/", $routedArray);
                $formatedRoute = "/" . $routedArray;
                // echo "<br>";
                // echo $routedArray;
                // echo "<br>";
                // $methodDictionary[$formatedRoute] = $methodDictionary["/dataprocessing/api/v1/animes"];
                echo "<br>";
                echo "<h2>Method dictionary before</h2>";
                echo "<pre>";
                var_dump($methodDictionary);
                echo "</pre>";
                echo "<br>";
                //Checked if the key exists. Routes without variables wont go in here.
                if (isset($methodDictionary[$method])) {
                    if ($methodDictionary[$formatedRoute] != $methodDictionary[$method]) {
                        $methodDictionary[$formatedRoute] = $methodDictionary[$method];
                        var_dump($method);
                        unset($methodDictionary[$method]);
                    }
                }


                echo "<br>";
                echo "<h2>Method dictionary after</h2>";
                echo "<pre>";
                var_dump($methodDictionary);
                echo "</pre>";
                echo "<br>";


                // var_dump($formatedRoute);
                break;
            }
            // echo "<hr><h2>RoutedArray After loop</h2>";
            // var_dump($routedArray);
            // echo "<hr>";
            // echo "<hr><h2>RoutedArray After loop</h2>";
            // var_dump($uriArray);
            // echo "<hr>";
        }


        // $matches  = preg_match('/{(.*?)}/', $routedArray);

        // // print_r($matches);
        // echo "<br>";
        // echo "<br>";
        // echo '<b>$uriArray</b>';
        // echo "<br>";
        // echo "<pre>";
        // var_dump($uriArray);
        // echo "</pre>";
        // echo '<b>$methodDictionary</b>';
        // echo "<br>";
        // echo "<pre>";
        // var_dump($methodDictionary);
        // echo "</pre>";
        // echo '<b>$formatedRoute</b>';
        // echo "<br>";
        // var_dump($formatedRoute);

        $method = $methodDictionary[$formatedRoute];
        // echo "<br>";
        // echo "</pre>";
        // echo '<b>$method</b>';
        // echo "<br>";
        // echo "<pre>";
        // echo var_dump($methodDictionary);
        // echo "</pre>";
        if (is_null($method)) {
            $this->defaultRequestHandler();
            return;
        }

        echo call_user_func_array($method, array($this->request));
    }

    function __destruct()
    {
        $this->resolve();
    }
}
