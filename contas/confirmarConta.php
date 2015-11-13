<?php
require_once "../definicoes.php";

$operacao = Usuario::confirmaRegistro($_GET['acc']);

if ($operacao) {
	echo notificacoes($operacao);
}
?>
