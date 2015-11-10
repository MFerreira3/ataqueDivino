<?php
/**
 * Importar esse arquivo em uma página fará com que o acesso à mesma seja limitado
 * ao uso de Ajax.
 */

$def_imprimirHTML = true;

require_once __DIR__ . "/definicoes.php"; // Garante que os códigos de formatação tenham sido importados.

// Verifica se o request vem de um algoritmo Ajax e depois se o mesmo vem do próprio host.
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$host = isset($_SERVER['HTTP_REFERER']) ? strpos($_SERVER['HTTP_REFERER'], getenv('HTTP_HOST')) : "";
if(!$ajax || $host === false) {
	die('Acesso restrito');
}
?>