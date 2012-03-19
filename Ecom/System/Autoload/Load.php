<?php namespace Ecom\System\Autoload;

/**
 * Loader class
 *
 * The Loader class is an implementation of the "universal" autoloader for
 * PHP 5.3 namespaces. It is capable of loading standard classes that use:
 *
 * 1. The PSR-0 technical interoperability standard for PHP 5.3 namespaces and
 *    class names.
 * 2. The PEAR naming convention for classes
 *
 * If a class does not fall into one of the two standards, a third option is
 * provided for direct class name to file location, allowing non-standard
 * classes to still be autoloaded.
 *
 * @package    Atom
 * @subpackage Autoload
 */
class Load
{
	/**
	 * A map of class name prefixes to directory paths
	 *
	 * @var    array
	 */
	private $paths = [];

	/**
	 * A map of exact class names to their file paths
	 *
	 * @var    array
	 */
	private $classes = [];

	/**
	 * A load of paths that have been attempted during load(), used for
	 * debuggin
	 *
	 * @var    array
	 */
	private $triedPaths = [];

	/**
	 * Classes and interfaces loaded by the autoloader; the key is the class
	 * name with the value being the file name
	 *
	 * @var    array
	 */
	private $loaded = [];

	/**
	 * Registers this autoloader with SPL
	 *
	 * @param    boolean         True to prepend the autoload stack
	 * @return   void            No value is returned
	 */
	public function register($prepend = false)
	{
		spl_autoload_register([$this, 'load'], true, (bool) $prepend);
	}

	/**
	 * Unregister this autolaoder from SPL
	 *
	 * @return   void            No value is returned
	 */
	public function unregister()
	{
		spl_autoload_unregister([$this, 'load']);
	}

	/**
	 * Adds a prefix and directory path
	 *
	 * @param    string          The class prefix, either as a namespace or
	 *                           prepended value
	 * @param    string|array    A directoy path, or an array of directory paths
	 * @return   void            No value is returned
	 */
	public function add($prefix, $paths)
	{
		if(!isset($this->paths[$prefix]))
		{
			$this->paths[$prefix] = [];
		}

		foreach((array) $paths as $path)
		{
			// Normalizes directory separators
			$path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
			$this->paths[$prefix][] = rtrim($path, DIRECTORY_SEPARATOR);
		}
	}

	/**
	 * Sets all class name prefixes and their paths. This overwrites the
	 * existing mappings
	 *
	 * @param    array           An associative array of prefixes and paths
	 * @return   void            No value is returned
	 */
	public function setPaths(array $prefixes)
	{
		$this->paths = [];

		foreach($prefixes as $prefix => $paths)
		{
			$this->add($prefix, $paths);
		}
	}

	/**
	 * Returns the list of all class name prefixes and their paths
	 *
	 * @return   array           An associative array with prefixes as keys and
	 *                           possible directories as values
	 */
	public function getPaths()
	{
		return $this->paths;
	}

	/**
	 * Sets the exact file path for an exact class name
	 *
	 * @param    string           Exact class name
	 * @param    string           The file path to that class
	 * @return   void             No value is returned
	 */
	public function setClass($class, $path)
	{
		$this->classes[$class] = (array) $path;
	}

	/**
	 * Sets all file paths for all class names; this overwrites all previous
	 * exact mappings
	 *
	 * @param    array            An array of class-to-file mappings where the
	 *                            key is the class name and the value is the
	 *                            file path
	 * @return   void             No value is returned
	 */
	public function setClasses(array $classes)
	{
		$this->classes = [];

		foreach($classes as $class => $path)
		{
			$this->setClass($class, $path);
		}
	}

	/**
	 * Get all the class names and their paths
	 *
	 * @return   array            An array of class-to-file mappings
	 */
	public function getClasses()
	{
		return $this->classes;
	}

	/**
	 * Get the list of classes and interfaces loaded by the autoloader
	 *
	 * @return   array            An array of key-value pairs where the key is
	 *                            the class name and the value is the file name
	 */
	public function getLoaded()
	{
		return $this->loaded;
	}

	/**
	 * Get the list of tried paths for loading classes
	 *
	 * @return   array            A list of tried paths for loading classes
	 */
	public function getTriedPaths()
	{
		return $this->triedPaths;
	}

	/**
	 * Loads a class or interface using the class name, prefix and path, falling
	 * back to the include path if not found
	 *
	 * @param    string           The class or interface to load
	 * @return   void             No value is returned
	 */
	public function load($spec)
	{
		if($this->exists($spec) === true)
		{
			return;
		}

		$file = $this->find($spec);

		if(empty($file))
		{
			return false;
		}

		require $file;

		if($this->exists($spec) === false)
		{
			return false;
		}

		$this->loaded[$spec] = $file;

		return true;
	}

	/**
	 * Check whether a class or interface exists without attempting to autoload
	 * it
	 *
	 * @param    string           The class or interface to check
	 * @return   boolean          True if exists, otherwise false
	 */
	private function exists($spec)
	{
		return (class_exists($spec, false) or interface_exists($spec, false));
	}

	/**
	 * Finds the path to a class or interface using the class prefix paths and
	 * include-path
	 *
	 * @param    string           The class or interface to find
	 * @return   string|null      The absolute path to the class or interface,
	 *                            otherwise null
	 */
	public function find($spec)
	{
		if(!isset($this->triedPaths[$spec]))
		{
			$this->triedPaths[$spec] = [];
		}

		if(isset($this->classes[$spec]))
		{
			$this->triedPaths[$spec][] = $this->classes[$spec];
			return $this->classes[$spec];
		}

		$ctf = $this->classToFile($spec);

		foreach($this->paths as $prefix => $paths)
		{
			$length = strlen($prefix);

			if(substr($spec, 0, $length) !== $prefix)
			{
				continue;
			}

			foreach($paths as $path)
			{
				$file = $path.DIRECTORY_SEPARATOR.$ctf;
				$this->triedPaths[$spec][] = $file;

				if(is_readable($file))
				{
					return $file;
				}
			}
		}

		if(!($file = stream_resolve_include_path($ctf)))
		{
			return;
		}

		return $file;
	}

	/**
	 * PSR-0 compliant class-to-file inflector
	 *
	 * @param    string           The name of the class or interface to inflect
	 * @return   string           The filename version of the class or interface
	 */
	public function classToFile($spec)
	{
		if(($pos = strrpos($spec, '\\')) === false)
		{
			$namespace = '';
			$class     = $spec;
		}
		else
		{
			$namespace = substr($spec, 0, $pos);
			$namespace = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
			$class     = substr($spec, $pos + 1);
		}

		return $namespace.str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';
	}
}