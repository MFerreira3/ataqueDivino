<?php
$def_imprimirHTML = false;
require_once "../definicoes.php";
require_once "../restricaoAjax.php";

const SECRET_KEY = "6LchDBATAAAAALY7KMB15GjZukkd3wYj-oZmboJv"; // Secret key do google reCAPTCHA

// Impede que uma pessoa já logada realize a criação de uma nova conta.
if (!empty($_SESSION['usuario'])) {
	retornarResultado("g0a");
}

/* Validações para o campo usuario
* 1. usuario não foi preenchido ou não é string?
* 2. usuario ultrapassa o limite de caracteres?
* 3. usuario não contém caracteres suficiente?
* 4. usuario não contém caracteres inválidos?
*/
if (empty($_POST['usuario']) || !is_string($_POST['usuario'])) {
	retornarResultado('c0a');
} else if (strlen($_POST['usuario']) > 25) {
	retornarResultado('c0b');
} else if (strlen($_POST['usuario']) < 3) {
	retornarResultado('c0c');
} else if (preg_replace("/[^a-zA-Z0-9\/_-]/", "", $_POST['usuario']) !== $_POST['usuario']) {
	retornarResultado('c0d');
}

/* Validações para o campo email
* 1. email não foi preenchido, não é string ou não é considerado válido?
* 2. email ultrapassa o limite de caracteres?
*/
if (empty($_POST['email']) || !is_string($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	retornarResultado('c1a');
} else if (strlen($_POST['email']) > 100) {
	retornarResultado('c1b');
}

/* Validações para o campo senha
* 1. senha não foi preenchida?
* 2. senha ultrapassa o limite de caracteres?
* 3. senha não contém caracteres suficiente?
*/
if (empty($_POST['senha'])) {
	retornarResultado('c2a');
} else if (strlen($_POST['senha']) > 32) {
	retornarResultado('c2b');
} else if (strlen($_POST['senha']) < 8) {
	retornarResultado('c2c');
}

/* Validações para os campos de data
* 1. diaNascimento, mesNascimento ou anoNascimento não foram preenchidos?
* 2. Juntos os valores formam uma data válida?
* 3. O usuário tem 13 ou mais anos de idade?
*/
if (empty($_POST['diaNascimento']) || empty($_POST['mesNascimento']) || empty($_POST['anoNascimento'])) {
	retornarResultado('c3a');
} else if (!checkdate($_POST['mesNascimento'], $_POST['diaNascimento'], $_POST['anoNascimento'])) {
	retornarResultado('c3b');
} else {
	$dataServidor = new DateTime(date("Y-m-d")); // Instancia um novo objeto date com a data atual.
	$dataUsuario = new DateTime($_POST['anoNascimento'] . '-' . $_POST['mesNascimento'] . '-' . $_POST['diaNascimento']); // Faz o mesmo com a data enviada pelo usuário.
	$intervalo = $dataServidor->diff($dataUsuario); // Obtém a diferença entre as duas datas.

	if ($intervalo->y < 13) {
		retornarResultado('c3c');
	}
}

/* Validações do reCAPTCHA
* 1. O g-response foi enviado?
* 2. A verificação foi validada pelo google?
*/
if (empty($_POST['g-response'])) {
	retornarResultado('c4a');
} else {
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRET_KEY . "&response=" . $_POST['g-response'] . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
	$response = json_decode($response);

	if (!$response->success) {
		retornarResultado('c4b');
	}
}

// Se nenhum dado for considerado inválido, será enviado um código de sucesso.
retornarResultado(0);

function retornarResultado($resultado = 0) {
	$retorno = array('resultado' => $resultado);
	echo json_encode($retorno);
	exit;
}

?>
