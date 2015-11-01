<?php
/*
Dados recebidos:
usuario
email
senha
diaNascimento
mesNascimento
anoNascimento
captcha

Dados retornados:
resultado
 */

$def_imprimirHTML = true;

require_once "../definicoes.php";
require_once "../restricaoAjax.php";


if (!empty($_SESSION['usuario'])) {
	retornarResultado("g0");
}


function retornarResultado($resultado = 0) {
	$retorno = array('resultado' => $resultado);
	echo json_encode($retorno);
	exit;
}

?>