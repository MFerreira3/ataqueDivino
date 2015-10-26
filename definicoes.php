<?php
header('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/debug.php';

# Definições padrões
if (!isset($_SESSION)) {
	session_id($def_sessionName); // Dá um id único para a sessão.
	session_name($def_sessionName); // Dá um nome único para a sessão.
	session_start();
}

$def_barraLateralCor = array('Red' => rand(0, 255), 'Green' => rand(0, 255), 'Blue' => rand(0, 255)); // Define uma cor aleatória para cada acesso na página.
$def_imprimirHTML = isset($def_imprimirHTML) ? $def_imprimirHTML : true; // Define se este arquivo imprimirá o conteúdo HTML que modela o padrão de páginas.

if ($def_imprimirHTML) {
?>
<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=0.5, user-scalable=no">
	<title>Ataque Divino</title>

	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" type="text/css" href="/ataqueDivino/Semantic/dist/semantic.css" />

	<style>
		/* Cor do indicador de rolagem - ao passar o mouse */
		::-webkit-scrollbar-thumb:vertical:hover,
		::-webkit-scrollbar-thumb:horizontal:hover {
		    background-color: rgb(<?= $def_barraLateralCor['Red'] . ", " . $def_barraLateralCor['Green'] . ", " . $def_barraLateralCor['Blue'] ?>);
		}
	</style>

	<script src="/ataqueDivino/js/jquery.js"></script>
	<script src="/ataqueDivino/Semantic/dist/semantic.js"></script>
	</head>

<?php
}
?>