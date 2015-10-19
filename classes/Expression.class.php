<?php
abstract class Expression {

	// operadores lógicos
	const OPERATOR_AND = 'AND ';
	const OPERATOR_OR = 'OR ';

	abstract function dump();

}
?>
