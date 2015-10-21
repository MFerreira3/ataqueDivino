<?php
header ('Content-type: text/html; charset=UTF-8');

$barraLateralCor = array('Red' => rand(0, 255), 'Green' => rand(0, 255), 'Blue' => rand(0, 255));
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
		    background-color: rgb(<?= $barraLateralCor['Red'] . ", " . $barraLateralCor['Green'] . ", " . $barraLateralCor['Blue'] ?>);
		}
	</style>

	<script src="/ataqueDivino/js/jquery.js"></script>
	<script src="/ataqueDivino/Semantic/dist/semantic.js"></script>
	</head>