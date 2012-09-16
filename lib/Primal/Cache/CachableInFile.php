<?php 

namespace Primal\Cache;

/**
 * Primal\Cache\CachableInFile - Subclass for storing Cachable data in files on the local system.
 *
 * @package Primal.Cache
 * @author Jarvis Badgley
 * @copyright 2012 Jarvis Badgley
 */

class CachableInFile extends Cachable implements Cache {

	private $path;

	/**
	 * Class constructor
	 *
	 * @param string $key Unique identifier for the cache
	 * @param integer $expires Lifespan of the cached data, in seconds. Defaults to 5 minutes
	 * @param string $directory Path to the file system directory in which to store the cached data
	 */
	function __construct($key, $expires = 300, $directory = null) {
		parent::__construct($key, $expires);

		$this->path = realpath((string)$directory.'/'.sha1($this->key).".cachable");
		//casting the directory allows us to support SPLFileObjects
	}
	

/**

*/

	protected function cacheIsValid() {
		return file_exists($this->path) && time() - filemtime($this->path) < $this->expires;
	}
	
	protected function cacheRetrieve() {
		return unserialize(file_get_contents($this->path));
	}
	
	protected function cacheStore($value) {
		file_put_contents($this->path, serialize($value));
	}
	
	
}