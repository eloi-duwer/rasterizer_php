<?PHP

require_once ("Vertex.class.php");

class Vector {
	
	private $_x;
	private $_y;
	private $_z;
	private $_w = 0.0;
	static $verbose = false;
	
	public function doc () {
		print(file_get_contents("Vector.doc.txt"));
	}
	
	public function __construct (array $kwargs) {
		$dest = $kwargs['dest'];
		if (array_key_exists('orig', $kwargs))
			$orig = $kwargs['orig'];
		else
			$orig = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0));
		$this->_x = $dest->getX() - $orig->getX();
		$this->_y = $dest->getY() - $orig->getY();
		$this->_z = $dest->getZ() - $orig->getZ();
		if (self::$verbose == true)
			print("Vector: x ".$this->_x." y ".$this->_y." z ".$this->_z." constructed".PHP_EOL);
	}
	
	public function __destruct () {
		if (self::$verbose == true)
			print("Vector: x ".$this->_x." y ".$this->_y." z ".$this->_z." destructed".PHP_EOL);
	}
	
	public function __toString () {
		return("Vector: x ".$this->_x." y ".$this->_y." z ".$this->_z.PHP_EOL);
	}
	
	public function getX() {
		return ($this->_x);
	}
	
	public function getY() {
		return ($this->_y);
	}
	
	public function getZ() {
		return ($this->_z);
	}
	
	public function getW() {
		return ($this->_w);
	}
	
	public function magnitude () {
		return (sqrt(pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2) + pow($this->_w, 2)));
	}
	
	public function normalize() {
		$mag = $this->magnitude();
		$pt = new Vertex (array('x' => $this->_x / $mag, 'y' => $this->_y / $mag, 'z' => $this->_z / $mag));
		$vec = new Vector(array('dest' => $pt));
		return ($vec);
	}
	
	public function add(Vector $vec) {
		$X = $this->_x + $vec->getX();
		$Y = $this->_y + $vec->getY();
		$Z = $this->_z + $vec->getZ();
		$pt = new Vertex (array('x' => $X, 'y' => $Y, 'z' => $Z));
		$vec = new Vector (array('dest' => $pt));
		return ($vec);
	}
	
	public function sub(Vector $vec) {
		$X = $this->_x - $vec->getX();
		$Y = $this->_y - $vec->getY();
		$Z = $this->_z - $vec->getZ();
		$pt = new Vertex (array('x' => $X, 'y' => $Y, 'z' => $Z));
		$vec = new  Vector (array('dest' => $pt));
		return ($vec);
	}
	
	public function opposite () {
		$X = - $this->_x;
		$Y = - $this->_y;
		$Z = - $this->_z;
		$pt = new Vertex (array('x' => $X, 'y' => $Y, 'z' => $Z));
		$vec = new Vector(array('dest' => $pt));
		return ($vec);
	}
	
	public function scalarProduct ($k) {
		$X = $this->_x * $k;
		$Y = $this->_y * $k;
		$Z = $this->_z * $k;
		$pt = new Vertex (array('x' => $X, 'y' => $Y, 'z' => $Z));
		$vec = new Vector(array('dest' => $pt));
		return ($vec);
	}
	
	public function dotProduct(Vector $vec) {
		return($this->_x * $vec->getX() + $this->_y * $vec->getY() +$this->_z * $vec->getZ() +$this->_w * $vec->getW());
	}
	
	public function cos($vec) {
		$vec1 = $this->normalize();
		$vec2 = $vec->normalize();
		return ($vec1->dotProduct($vec2));
	}
	
	public function crossProduct(Vector $vec) {
		$X = $this->_y * $vec->getZ() - $vec->getY() * $this->_z;
		$Y = $this->_z * $vec->getX() - $vec->getZ() * $this->_x;
		$Z = $this->_x * $vec->getY() - $vec->getX() * $this->_y;
		$pt = new Vertex (array('x' => $X, 'y' => $Y, 'z' => $Z));
		$vec = new Vector(array('dest' =>  $pt));
		return ($vec);
	}
}

?>
