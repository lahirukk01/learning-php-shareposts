<?

/*
* App Core Class
* Creates URL & loads core controller
* URL Format - /controller/method/params
*/

class Core {
    protected $currentController = null;
    protected $currentControllerName = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        if (!empty($url)) {
            $controllerName = ucwords($url[0]);
            $controllerFileName = '../app/controllers/' . $controllerName . '.php';

            // Look in controllers for first value
            if (file_exists($controllerFileName)) {
                // If exist set as controller
                $this->currentControllerName = $controllerName;
                // Unset 0 index
                unset($url[0]);
            } else {
                die('Invalid path');
            }

            // Require the controller
            require_once '../app/controllers/' . $this->currentControllerName . '.php';

            // Instantiate controller class
            $this->currentController = new $this->currentControllerName;

            // Check for second part of the url
            if (isset($url[1])) {
                // Check to see if the method exists in controller
                if (method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                } else {
                    //Send 404 response to client.
                    http_response_code(404);

                    //Include custom 404.php message
                    // include 'error/404.php';

                    //Kill the script.
                    die('Invalid url');
                }
            }
            // Get params
            $this->params = $url ? array_values($url) : [];
        }

        if ($this->currentController == null) {
            $this->currentController = new $this->currentControllerName;
        }

        try {
            $ref = new ReflectionMethod($this->currentControllerName, $this->currentMethod);
            $numberOfParamsOfMethod = $ref->getNumberOfParameters();

            if ($numberOfParamsOfMethod != count($this->params)) {
                die('Invalid number of parameters');
            }

            // Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } catch (ReflectionException $e) {
            die($e->getMessage());
        }
    }

    private function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
     
