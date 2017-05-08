<?PHP

class Matrix {

	const IDENTITY = "IDENTITY";
	const SCALE = "SCALE";
	const RX = "Ox_ROTATION";
	const RY = "Oy_ROTATION";
	const RZ = "Oz_ROTATION";
	const TRANSLATION = "TRANSLATION";
	const PROJECTION = "PROJECTION";
	const CUSTOM = "CUSTOM";

	static $verbose = false;
	protected $_matrix = array();

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
		$str = "M | vtcX | vtcY | vtcZ | vtxO".PHP_EOL;
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
		$this->_matrix = $this->_init_base_matrix();
		$func = "_init_".$kwargs['preset'];
		$this->$func($kwargs);
		if (self::$verbose == true)
			print("Matrix ".$kwargs['preset']." preset instance constructed".PHP_EOL);
	}

	public function __destruct() {
		if (self::$verbose == true)
			print("Matrix instance destructed".PHP_EOL);
	}

	private function _init_base_matrix() {
		$matrix = array();
		for ($i = 0; $i < 4; $i++) {
			$matrix[$i] = array();
			for($j = 0; $j < 4; $j++) {
				$matrix[$i][$j] = 0;
			}
		}
		return($matrix);
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

	private function _init_PROJECTION(array $kwargs) {
		$fov = $kwargs['fov'];
		$ratio = $kwargs['ratio'];
		$near = $kwargs['near'];
		$far = $kwargs['far'];
		$this->_matrix[1][1] = 1 / tan(0.5 * deg2rad($fov));
		$this->_matrix[0][0] = $this->_matrix[1][1] / $ratio;
		$this->_matrix[2][2] = -($far + $near) / ($far - $near);
		$this->_matrix[2][3] = - (2 * $far * $near) / ($far - $near);
		$this->_matrix[3][2] = -1;
	}

	private function _init_CUSTOM(array $kwargs) {
		$this->_matrix = $kwargs['mat'];
	}

	public function mult(Matrix $matrix) {
		$res = $this->_init_base_matrix();
		for($i = 0; $i < 4; $i++) {
			for($j = 0; $j < 4; $j++) {
				for($k = 0; $k < 4; $k++) {
					$res[$i][$j] += $this->_matrix[$i][$k] * $matrix->_matrix[$k][$j];
				}
			}
		}
		$mat = new Matrix (array('preset' => Matrix::CUSTOM, 'mat' => $res));
		return ($mat);
	}

	public function transformVertex(Vertex $vertex) {
		$res = array();
		for($i = 0; $i < 4; $i++) {
			$res[$i] = $this->_matrix[$i][0] * $vertex->getX() + $this->_matrix[$i][1] * $vertex->getY() + $this->_matrix[$i][2] * $vertex->getZ() + $this->_matrix[$i][3] * $vertex->getW();
		}
		if ($res[3] == 0)
			$res[3] = 1;
		return( new Vertex(array('x' => ($res[0] / $res[3]), 'y' => ($res[1] / $res[3]), 'z' => ($res[2] / $res[3]), 'color' => $vertex->getColor())));
	}

	public function transformMesh(array $mesh) {
		$i = 0;
		foreach ($mesh as $triangle) {
			$A = $this->transformVertex($triangle->getA());
			$B = $this->transformVertex($triangle->getB());
			$C = $this->transformVertex($triangle->getC());
			$tab[$i] = new Triangle($A, $B, $C);
			$i++;
		}
		return ($tab);
	}

	public function invertDiag() {
		$mat = array();
		for ($i = 0; $i < 4; $i++) {
			$mat[$i] = array();
			for($j = 0; $j < 4; $j++) {
				$mat[$i][$j] = $this->_matrix[$j][$i];
			}
		}
		$mat = new Matrix(array('preset' => MATRIX::CUSTOM, 'mat' => $mat));
		return ($mat);
	}
}

?>
