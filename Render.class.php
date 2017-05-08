<?PHP

class Render {

	const VERTEX = "vertex";
	const EDGE = "edge";
	const RASTERIZE = "rasterize";

	private $_width;
	private $_height;
	private $_filename;
	private $_img;
	private $_zBuffer;

	static $verbose = false;

	public function __construct($width, $height, $name) {
		$this->_width = (int)$width;
		$this->_height = (int)$height;
		$this->_filename = $name;
		$this->_img = imagecreatetruecolor($width, $height);
		$this->_zBuffer = $this->create_zBuffer($height, $width);
		if (self::$verbose == true)
			print("Render instance constructed".PHP_EOL);
	}

	public function __destruct() {
		if (self::$verbose == true)
			print ("Render instance destructed".PHP_EOL);
	}

	public function __toString() {
		return ("Render class: Width: ".$this->_width.", Height: ".$this->_height.", File: ".$this->_filename.PHP_EOL);
	}

	private function create_zBuffer($height, $width) {
		for ($i = 0; $i < $height; $i++) {
			for ($j = 0; $j < $width; $j++) {
				$tab[$i][$j] = 0;
			}
		}
		return ($tab);
	}

	public function renderVertex(Vertex $pt) {
		$x = (int)$pt->getX();
		$y = (int)$pt->getY();
		$z = ($pt->getZ() + 1) / 2;
		print ("x ".$x." y ".$y." z ".$z.PHP_EOL);
		if ($x >= 0 && $x <= $this->_width && $y > 0 && $y <= $this->_height /*&& $z >= 0 && $z <= 1 && $z >= $this->_zBuffer[$x][$y]*/) {
			$this->_zBuffer[$x][$y] = $z;
			$color = $pt->getColor();
			$color = imagecolorallocate($this->_img, $color->red, $color->green, $color->blue);
			imagesetpixel($this->_img, $x, $y, $color);
		}
	}

	public function renderTriangle(Triangle $triangle, $mode) {
		$A = $triangle->getA();
		$B = $triangle->getB();
		$C = $triangle->getC();
		if ($mode == self::VERTEX) {
			$this->renderVertex($A);
			$this->renderVertex($B);
			$this->renderVertex($C);
		}
		else if ($mode == self::EDGE) {
			
		}
	}

	public function renderMesh($mesh, $mode) {
		foreach($mesh as $triangle) {
			$this->renderTriangle($triangle, $mode);
		}
	}

	public function develop() {
		imagepng($this->_img, $this->_filename);
	}
}

?>
