<?PHP

class Matrix {

	const IDENTITY = "IDENTITY";
	const SCALE = "SCALE";
	const RX = "Ox_ROTATION";
	const RY = "Oy_ROTATION";
	const RZ = "Oz_ROTATION";
	const TRANSLATION = "TRANSLATION";
	const PROJECTION = "PROJECTION";

	static $verbose = false;
	private $_matrix = array();

	public function doc () {
		print(file_get_contents("Matrix.doc.txt"));
	}

	private function _print_line($nb, $str) {
		for ($i = 0; $i < 4; $i++) {
			$str = $str."| ".number_format($this->_matrix[$nb][$i], 2)." ";
		}
		if($nb != 3)
			$str = $str.PHP_EOL;
		return ($str);
	}

	public function __toString() {
		$str = "M | vtcX | vtcY | vtcZ | vtx0".PHP_EOL;
		$str = $str."-----------------------------".PHP_EOL;
		$str = $str."x ";
		$str = $this->_print_line(0, $str);
		$str = $str."y ";
		$str = $this->_print_line(1, $str);
		$str = $str."z ";
		$str = $this->_print_line(2, $str);
		$str = $str."w ";
		$str = $this->_print_line(3, $str);
		return($str);
	}
	public function __construct(array $kwargs) {
		$this->_init_base_matrix();
		$func = "_init_".$kwargs['preset'];
		$this->$func($kwargs);
		if (self::$verbose == true)
			print("Matrix ".$kwargs['preset']." preset instance constructed".PHP_EOL);
	}

	private function _init_base_matrix() {
		for ($i = 0; $i < 4; $i++) {
			$this->_matrix[$i] = array();
			for($j = 0; $j < 4; $j++) {
				$this->_matrix[$i][$j] = 0;
			}
		}
	}

	private function _init_IDENTITY (array $kwargs) {
		for ($i = 0; $i < 4; $i++) {
			$this->_matrix[$i][$i] = 1;
		}
	}

	private function _init_TRANSLATION(array $kwargs) {
		$vec = $kwargs['vtc'];
		$this->_init_IDENTITY($kwargs);
		$this->_matrix[0][3] = $vec->getX();
		$this->_matrix[1][3] = $vec->getY();
		$this->_matrix[2][3] = $vec->getZ();
	}

	private function _init_SCALE (array $kwargs) {
		$factor = $kwargs['scale'];
		$this->_init_IDENTITY($kwargs);
		for ($i = 0; $i < 3; $i++) {
			$this->_matrix[$i][$i] = $factor;
		}
	}

	private function _init_Ox_ROTATION($kwargs) {
		$ang = $kwargs['angle'];
		$this->_init_IDENTITY($kwargs);
		$this->_matrix[1][1] = cos($ang);
		$this->_matrix[1][2] = -sin($ang);
		$this->_matrix[2][1] = sin($ang);
		$this->_matrix[2][2] = cos($ang);
	}

	private function _init_Oy_ROTATION($kwargs) {
		$ang = $kwargs['angle'];
		$this->_init_IDENTITY($kwargs);
		$this->_matrix[0][0] = cos($ang);
		$this->_matrix[0][2] = sin($ang);
		$this->_matrix[2][0] = -sin($ang);
		$this->_matrix[2][2] = cos($ang);
	}

	private function _init_Oz_ROTATION($kwargs) {
		$ang = $kwargs['angle'];
		$this->_init_IDENTITY($kwargs);
		$this->_matrix[0][0] = cos($ang);
		$this->_matrix[0][1] = -sin($ang);
		$this->_matrix[1][0] = sin($ang);
		$this->_matrix[1][1] = cos($ang);
	}
}

?>
