<?php
class Filter extends Expression {

	private $field;
	private $operator;
	private $value;

	/**
	 * Cria um filtro a partir dos valores passados como parâmetro.
	 *
	 * Por exemplo, para criar um filtro que retorne os registros que tem valor
	 * menor que 5, usa-se:
	 *
	 * $filter = new Filter('valor', '<', 5);
	 *
	 * @param string $field nome do campo
	 * @param string $operator operador de comparação (<, >, =, LIKE, <=, >=)
	 * @param mixed $value valor do campo
	 */
	function __construct($field, $operator, $value) {
		$this->field = $field;
		$this->operator = $operator;
		$this->value = $this->transform($value);
	}

	static function transform($value) {
		if (is_array($value)) {
			$tmp = array();

			foreach ($value as $x) {
				$tmp[] = self::transform($x);
			}

			$result = '(' . implode(', ', $tmp) . ')';
		} else if (is_string($value)) {
			$value = htmlspecialchars($value);
			$value = addslashes($value);
			$result = "'$value'";
		} else if (is_null($value)) {
			$result = 'NULL';
		} else if (is_bool($value)) {
			$result = $value ? 'TRUE' : 'FALSE';
		} else {
			$result = $value;
		}

		return $result;
	}

	function dump() {
		return "{$this->field} {$this->operator} {$this->value}";
	}

}
?>
