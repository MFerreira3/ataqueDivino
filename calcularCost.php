<?php
/**
 * Calcula um cost ideal para o hardware utilizado como host e
 * grava o valor encontrado no ps.json. Rode este código
 * sempre que for necessário atualizar o cost.
 */
require_once "definicoes.php";

// Define um cost mínimo.
$cost = 8;
// Realiza o teste com um cost cada vez maior até que o tempo de criação seja maior ou igual a 50 milissegundos.
do {
    $cost++;
    $inicio = microtime(true);
    password_hash("AllYourPassAreBelongToUs@123", PASSWORD_DEFAULT, ["cost" => $cost]);
    $fim = microtime(true);
} while (($fim - $inicio) < 0.05);

// Registra o cost e armazena no ps.json.
$def_passes->costPadrao = $cost;
$diretorioPS = __DIR__ . '/ps.json';
file_put_contents ($diretorioPS, json_encode($def_passes));

?>
