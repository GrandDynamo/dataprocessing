<?php

namespace classes\routing;

use ReflectionFunction;

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
        // echo "<pre>";
        // var_dump($this->request);
        // echo "</pre>";
    }

    function __call($operationType, $args)
    {
        $routeURL = $args[0];
        $method = $args[1];

        if (!in_array(strtoupper($operationType), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($operationType)}[$this->formatRoute($routeURL)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     *
     * @param route (string)
     * @return void
     */
    private function formatRoute($routeURL)
    {
        $result = rtrim($routeURL, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    private function badRequestHandler()
    {
        header("{$this->request->serverProtocol} 400 Bad Request");
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
     * Resolves a route including routes with variables.
     * 
     * @todo Break apart into smaller code using methods.
     *
     * @return void
     */
    function resolveRoute()
    {
        //Get all defined routes.
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        //Get formatted user received URL.
        $formattedRoute = $this->formatRoute($this->request->requestUri);
        //Explode URL send by a user into an Array.
        $receivedURLArray = explode('/', trim($formattedRoute, '/'));

        $variableArray = array();
        //Loop through de dictionary containing routes.
        foreach ($methodDictionary as $method => $value) {

            //Explode Routing URL into an Array.
            $routingURLArray = explode('/', trim($method, '/'));

            //Iterate through every routing URL key.
            foreach ($routingURLArray as $key => $value) {
                // Check if the recieved also array contains that key.
                if (isset($receivedURLArray[$key])) {
                    //Step into if statement when key are the same.
                    if ($routingURLArray[$key] === $receivedURLArray[$key]) {
                        //Break out of this iteration and lets loop go to next iteration.
                        continue;
                    } elseif (preg_match('/{(.*?)}/', $value)) {
                        //Stores user variable in array.
                        $variableArray[] = $receivedURLArray[$key];
                        //Replace variable inside the routing uri to a value recieved by the user.
                        $routingURLArray[$key] = $receivedURLArray[$key];
                    }
                }
            }

            //Step into if statement when the received and routing arrays match.
            if ($routingURLArray === $receivedURLArray) {
                //@test See if everything works when commented out.
                // $formattedRoute = "/" . implode("/", $routingURLArray);

                //Only go in if the route exists if the  Routes without variables wont go in here.
                if (isset($methodDictionary[$method])) {
                    //Go inside when the routing dictionary does not contain the changed uri. Routes without variables wont go in here. Routes with variables inside need this to change the route path.
                    if (!isset($methodDictionary[$formattedRoute])) {
                        //Replace uri in dictionary with changed uri.
                        $methodDictionary[$formattedRoute] = $methodDictionary[$method];
                        unset($methodDictionary[$method]);
                    }
                }
            }
        }

        //Checks if the URL send by a user was correct. If not, return corresponding error.
        if (isset($methodDictionary[$formattedRoute])) {
            $method = $methodDictionary[$formattedRoute];
            //Calls the function that is inside the route and returns the variables.
            //    call_user_func_array($method, $variableArray);
            if ($this->request->requestMethod === "POST") {
                call_user_func_array($method, array($this->request));
            }
            elseif($this->request->requestMethod === "GET"){
                call_user_func_array($method, $variableArray);
            }
        } elseif (!isset($methodDictionary[$formattedRoute])) {
            $this->badRequestHandler();
            return;
        } else {
            $this->defaultRequestHandler();
            return;
        }
    }

    function __destruct()
    {
        $this->resolveRoute();
    }
}
