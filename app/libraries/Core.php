<?

/*
* App Core Class
* Creates URL & loads core controller
* URL Format - /controller/method/params
*/

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        // print_r($this->getUrl());

        $url = $this->getUrl();

        if (!empty($url)) {
            $controllerName = ucwords($url[0]);
            $controllerFileName = '../app/controllers/' . $controllerName . '.php';

            // Look in controllers for first value
            if (file_exists($controllerFileName)) {
                // If exist set as controller
                $this->currentController = $controllerName;
                // Unset 0 index
                unset($url[0]);
            }

            // Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            // Instantiate controller class
            $this->currentController = new $this->currentController;

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
                    exit(-1);
                }
            }

            // Get params
            $this->params = $url ? array_values($url) : [];
        }

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], ['Hello', 'world']);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
     
