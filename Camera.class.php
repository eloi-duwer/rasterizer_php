<?PHP

require_once("Matrix.class.php");

class Camera {

	static $verbose = false;

	private $_tT;
	private $_tR;
	private $_viewMatrix;
	private $_proj;
	private $_origin;
	private $_width;
	private $_height;
	private $_ratio;

	public function __construct(array $kwargs) {
		$this->_origin = $kwargs['origin'];
		$orientation = $kwargs['orientation'];
		$fov = $kwargs['fov'];
		$near = $kwargs['near'];
		$far = $kwargs['far'];
		if (array_key_exists("ratio", $kwargs)) {
			$this->_height = 480;
			$this->_width = $height * $kwargs['ratio'];
			$this->_ratio = $kwargs['ratio'];
		}
		else {
			$this->_width = $kwargs['width'];
			$this->_height = $kwargs['height'];
			$this->_ratio = $this->_width / $this->_height;
		}
		$vec = new Vector(array("dest" => $this->_origin));
		$vec = $vec->opposite();
		$this->_tT = new Matrix(array('preset' => MATRIX::TRANSLATION, 'vtc' => $vec));
		$this->_tR = $orientation->invertDiag();
		$this->_viewMatrix = $this->_tR->mult($this->_tT);
		$this->_proj = new Matrix(array('preset' => MATRIX::PROJECTION, 'fov' => $fov, 'ratio' => $this->_ratio, 'near' => $near, 'far' => $far));
		if (self::$verbose == true)
			print ("Camera instance constructed".PHP_EOL);
	}

	public function __destruct() {
		if (self::$verbose == true)
			print("Camera instance destructed".PHP_EOL);
	}

	public function __toString() {
		return("Camera(".PHP_EOL."+ Origine: ".$this->_origin.PHP_EOL."+ tT:".PHP_EOL.$this->_tT.PHP_EOL."+ tR:".PHP_EOL.$this->_tR.PHP_EOL."+ tR->mult( tT ):".PHP_EOL.$this->_viewMatrix.PHP_EOL."+ Proj:".PHP_EOL.$this->_proj);
	}

	static function doc() {
		print (file_get_contents("Camera.doc.txt"));
	}

	public function watchVertex(Vertex $worldVertex) {
		$camVertex = $this->_viewMatrix->transformVertex($worldVertex);
		$ndcVertex = $this->_proj->transformVertex($camVertex);
		$x = (1 + $ndcVertex->getX()) * $this->_width / 2;
		$y = (1 + $ndcVertex->getY()) * $this->_height / 2;
		$z = $ndcVertex->getZ();
		$res = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
		return ($res);
	}
}

?>
