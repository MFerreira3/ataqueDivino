<?php
//Carrega as classes e suas funções no cabeçalho
require_once __DIR__ . '/configuracao.php';

spl_autoload_register(function($class) {
	if (file_exists(__DIR__ . '/classes/' . $class . '.class.php')) {
		require __DIR__ . '/classes/' . $class . '.class.php';
	}
});
?>
