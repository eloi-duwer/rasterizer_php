<?PHP

require_once("Color.class.php");

class Vertex {

	static $verbose = false;
	private $_x;
	private $_y;
	private $_z;
	private $_w = 1.0;
	private $_color;

	public function __construct (array $kwargs) {
		$this->_x = $kwargs['x'];
		$this->_y = $kwargs['y'];
		$this->_z = $kwargs['z'];
		if (array_key_exists("w", $kwargs))
			$this->_w = $kwargs['w'];
		if (array_key_exists("color", $kwargs))
			$this->_color = $kwargs['color'];
		else
			$this->_color = new Color(array("rgb" => 16777215));
		if (self::$verbose == true)
	print ("Vertex( x:".$this->_x.", y:".$this->_y.", z:".$this->_z.", w:".$this->_w." ".$this->_color." ) constructed".PHP_EOL);
	}
	
	public function __destruct () {
		if (self::$verbose == true)
			print ("Vertex( x:".$this->_x.", y:".$this->_y.", z:".$this->_z.", w:".$this->_w." ".$this->_color." ) destructed".PHP_EOL);
	}
	
	public function __toString() {
		if (self::$verbose == false)
			return ("Vertex( x:".$this->_x.", y:".$this->_y.", z:".$this->_z.", w:".$this->_w." )");
		else
			return("Vertex( x:".$this->_x.", y:".$this->_y.", z:".$this->_z.", w:".$this->_w." ".$this->_color." )");
	}
	
	public function doc() {
			print(file_get_contents("Vertex.doc.txt"));
	}
	
	public function setValues(array $kwargs) {
		if (array_key_exists("x", $kwargs))
			$this->_x = $kwargs['x'];
		if (array_key_exists("y", $kwargs))
			$this->_y = $kwargs['y'];
		if (array_key_exists("z", $kwargs))
			$this->_z = $kwargs['z'];
		if (array_key_exists("w", $kwargs))
			$this->_w = $kwargs['w'];
		if (array_key_exists("color", $kwargs))
			$this->_color = $kwargs['color'];
	}
	
	public function getX() {
		return($this->_x);
	}
	
	public function getY() {
		return($this->_y);
	}
	
	public function getZ() {
		return($this->_z);
	}
	
	public function getW() {
		return($this->_w);
	}
	
	public function getColor() {
		return($this->_color);
	}
}

?>
