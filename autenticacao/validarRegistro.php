<?php
/**
 * Recebe dados enviados por POST e realiza a verificação e criação da nova conta.a
 *
 * Valores recebidos:
 * usuario, email, senha, anoNascimento, mesNascimento, diaNascimento e g-response.
 *
 * Valores retornados:
 * mixed	resultado 	Contém o codigo identificador do resultado
 * 						da operação.
 * string	notificacao	Contém a notificação correspondente ao resultado.
 */
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
* 5. usuario já está em uso?
*/
if (empty($_POST['usuario']) || !is_string($_POST['usuario'])) {
	retornarResultado('c0a');
} else if (strlen($_POST['usuario']) > 25) {
	retornarResultado('c0b');
} else if (strlen($_POST['usuario']) < 3) {
	retornarResultado('c0c');
} else if (preg_replace("/[^a-zA-Z0-9\/_-]/", "", $_POST['usuario']) !== $_POST['usuario']) {
	retornarResultado('c0d');
} else if (Usuario::usuarioExistente($_POST['usuario'])) {
	retornarResultado('c0f');
}

/* Validações para o campo email
* 1. email não foi preenchido, não é string ou não é considerado válido?
* 2. email ultrapassa o limite de caracteres?
* 3. email já está sendo utilizado?
*/
if (empty($_POST['email']) || !is_string($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	retornarResultado('c1a');
} else if (strlen($_POST['email']) > 100) {
	retornarResultado('c1b');
} else if (Usuario::usuarioExistente(null, $_POST['email'])) {
	retornarResultado('c1c');
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
* 2. A verificação foi validada pelo Google?
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


/* O laço abaixo gera um novo hash para a senha e, apesar das chances disso acontecer serem remotas, verifica
se o mesmo já está sendo utilizado, em caso de repetição, ele irá gerar um novo hash */
do {
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT, array('cost' => $def_passes->costPadrao));
} while (Usuario::hashExistente($senha));


// Realiza a mesma operação de verificação feita na senha para gerar um codConfirmação
do {
    $codConfirmacao = base64_encode(openssl_random_pseudo_bytes(8));
} while (Usuario::codConfirmacaoExistente($codConfirmacao));


// Construção da mensagem de confirmação.
require_once "../util/email.php";

$titulo = <<<END
			Seja bem vindo ao Ataque Divino!
END;

$corpo = <<<END
			Olá $_POST[usuario], <br />
			para começar a jogar você só precisa validar sua nova conta <a href="$def_passes->urlRaiz$url/contas/confirmarConta.php?acc=$codConfirmacao">clicando aqui</a>.<br />
			Ataque Divino.
END;

// Envia o e-mail e retorna erro caso não seja possível.
if (enviarEmail($titulo, $corpo, $_POST['email'])) {
	retornarResultado('c1d');
}

// Inicia o processo de gravação.
$usuario = new Usuario();
$usuario->usuario = $_POST['usuario'];
$usuario->email = $_POST['email'];
$usuario->senha = base64_encode($senha);
$usuario->dataNascimento = $_POST['anoNascimento'] . '-' . $_POST['mesNascimento'] . '-' . $_POST['diaNascimento'];
$usuario->confirmado = "0";
$usuario->dataCriacao = date("Y-m-d");
$usuario->codConfirmacao = $codConfirmacao;
$usuario->store();

// Se nenhum dado for considerado inválido, será enviado um código de sucesso.
retornarResultado(0);

function retornarResultado($resultado = 0) {
	$retorno = array('resultado' => $resultado, 'notificacao' => notificacoes($resultado));
	echo json_encode($retorno);
	exit;
}

?>
