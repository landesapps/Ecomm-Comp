<?php namespace Ecom\System\Router;

/**
 * Map class
 *
 * The Map class represents a collection point for URI routes
 *
 * @package    Atom
 * @subpackage Router
 */
class Route
{
	/**
	 * A collection of Routes assigned to this Map
	 *
	 * @var    array
	 */
	private $routes = [
		'GET'    => [],
		'POST'   => [],
		'PUT'    => [],
		'DELETE' => [],
	];

	/**
	 * A collection of short-cut regex variables for routes
	 *
	 * @var   array
	 */
	private $choices = [
		':num'       => '([0-9]+)',
		':alpha_num' => '([0-9a-zA-Z]+)',
		':alpha'     => '([a-zA-Z]+)',
		':any'           => '(.*)',
	];

	/**
	 * Adds a route to the router
	 *
	 * @param    string|array     HTTP methods to respond to
	 * @param    string|array     The route to match
	 * @param    string|Closure   Either an object name or callback closure
	 * @return   void             No value is returned
	 */
	public function add($methods, $routes, $action)
	{
		$methods = (array) $methods;
		$routes  = (array) $routes;

		foreach($methods as $method)
		{
			$method = strtoupper($method);

			foreach($routes as $route)
			{
				$route = '/'.trim($route, '/');

				if(isset($this->routes[$method]))
				{
					$this->routes[$method][] = [$route => $action];
				}
				elseif($method == 'ANY')
				{
					foreach($this->routes as $choice => $arr)
					{
						$this->routes[$choice][] = [$route => $action];
					}
				}
			}
		}
	}

	/**
	 * Dispatches the idea route based on a uri
	 *
	 * @param    string           The URI to dispatch
	 * @return   string|false     Returns the content of the dispatch, otherwise
	 *                            false
	 * @throw    RuntimeException
	 */
	public function dispatch($uri)
	{
		if(($action = $this->match($this->requestType(), $uri)) !== false)
		{
			$call       = $action['__action'];
			unset($action['__action']);

			if($this->requestType() !== 'GET')
			{
				$action[] = $_POST;
			}

			if(is_string($call))
			{
				$method = substr($call, strrpos($call, '\\')+1);
				$class  = substr($call, 0, strrpos($call, '\\'));

				return call_user_func_array([$class, $method], $action);
			}
			elseif($call instanceof \Closure)
			{
				return call_user_func_array($call, $action);
			}
			else
			{
				throw \RuntimeException('Encountered poorly formatted route');
			}
		}

		throw new \RuntimeException('Could not find route');
	}

	/**
	 * Searches for a route that matches a defined uri and method
	 *
	 * @param    string           An HTTP method
	 * @param    string           A uri
	 * @return   array|boolean    A matching array, otherwise false
	 */
	public function match($method, $uri)
	{
		foreach($this->routes[$method] as $actions)
		{
			foreach($actions as $route => $action)
			{
				foreach($this->choices as $find => $replace)
				{
					$route = preg_replace('#'.$find.'#is', $replace, $route);
				}

				$matches = [];

				if($route == '(.+)')
				{
					return ['__action' => $action];
				}
				elseif(preg_match('#^'.$route.'$#i', $uri, $matches))
				{
					$params = [];

					for($i = 1; $i < count($matches); $i++)
					{
						$params[] = $matches[$i];
					}

					$params['__action'] = $action;

					return $params;
				}
			}
		}

		return false;
	}

	/**
	 * Returns the route array
	 *
	 * @return   array           An array of all routes
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Determines the HTTP request method
	 *
	 * @return   string           GET, POST, PUT, or DELETE
	 */
	private function requestType()
	{
		if(isset($_POST) and is_array($_POST) and isset($_POST['__spoofer']))
		{
			$_POST['__spoofer'] = strtoupper($_POST['__spoofer']);

			if(in_array($_POST['__spoofer'], ['PUT', 'DELETE']))
			{
				return $_POST['__spoofer'];
			}
		}

		return $_SERVER['REQUEST_METHOD'];
	}
}