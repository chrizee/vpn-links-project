<?php
class Routes {
	/**
	* @var array $_listUri List of URI's to match against
	*/
	private $_listUri = array();
	public static $errors =array();
	/**
	* @var string $_trim Class-wide items to clean
	*/
	private $_trim = '/\^$';
		
	/**
	* add - Adds a URI and Function to the two lists
	*
	* @param string $uri A path such as about/system
	* @param object $function An anonymous function
	*/
	public function add($uri) {
		$uri = trim($uri, $this->_trim);
		$this->_listUri[] = $uri;
	}
	
	/**
	* submit - Looks for a match for the URI and runs the related function
	*/
	public function submit() {	
		$uri = isset($_REQUEST['uri']) ? $_REQUEST['uri'] : '/';
		$uri = trim($uri, $this->_trim);

		/**
		* List through the stored URI's
		*/
		foreach ($this->_listUri as $listKey => $listUri) {
			/**
			* See if there is a match
			*/
			$chunk = explode('=', $uri);
			//print_r($chunk);
			if($uri == '') $chunk[0] = "dashboard";
			if (preg_match("#^$listUri$#", $chunk[0])) {
				/**
				* load the file if it exists
				*/
				if(file_exists($chunk[0].'.php')) {
					return $chunk;
				} else{
					require_once('404');
				}
			}
			
		}	
	}
}