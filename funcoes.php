<?php
/**
 * Recebe um valor de mês e retorna o seu respectivo nome;
 * @param	integer 	$numeroMes	Variável de valor para o mês;
 * @return	string 		Retorna o nome do mês;
 */
function mesNome($numeroMes) {
	$mes = array(
		1 => 'Janeiro',
		2 => 'Fevereiro',
		3 => 'Março',
		4 => 'Abril',
		5 => 'Maio',
		6 => 'Junho',
		7 => 'Julho',
		8 => 'Agosto',
		9 => 'Setembro',
		10 => 'Outubro',
		11 => 'Novembro',
		12 => 'Dezembro'
	);

	return $mes[$numeroMes];
}
?>
