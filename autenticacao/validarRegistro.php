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



/*
Lista de validação
Usuario = Ta preenchido? Tem menos q 25 caracteres? Caracteres válidos? STR?

Email = Ta preenchido? Tem menos q 100 caracteres? É e-mail?

Senha = Ta preenchida? min 8 caracteres? Max 32?

Datas de Nascimento = Tão preenchidas? N tem caractere retardado? N é menor q 1? N é maior q o mês permite? Juntas dão mais q 13 anos?

reCAPTCHA = Ta preenchido? Validado pelo Google?
 */
$def_imprimirHTML = true;
require_once "../definicoes.php";
require_once "../restricaoAjax.php";

// Impede que uma pessoa já logada realize a criação de uma nova conta
if (!empty($_SESSION['usuario'])) {
	retornarResultado("g0");
}

/* Validações para o campo usuario
* 1. usuario não foi preenchido ou não é string?
* 2. usuario ultrapassa o limite de caracteres
* 3. usuario não contém caracteres suficiente
*/
if (empty($_POST['usuario']) || !is_string($_POST['usuario'])) {
	retornarResultado('c0');
} else if (strlen($_POST['usuario']) > 25) {
	retornarResultado('c1');
} else if (strlen($_POST['usuario']) < 3) {
	retornarResultado('c2');
} else if (preg_replace("/[^a-zA-Z0-9\/_-]/", "", $_SESSION['usuario']) !== $_SESSION['usuario']) {
	# code...
}


function retornarResultado($resultado = 0) {
	$retorno = array('resultado' => $resultado);
	echo json_encode($retorno);
	exit;
}

?>
