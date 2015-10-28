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
<script>
/**
 * Recebe um mês e retorna a quantia de dias máximo para tal;
 * @param	integer	$numeroMes	Váriavel de valor para o mês;
 * @return	integer	Retorna a quantia máxima de dias para o mês;
 */
function mesDiaMaximo(numeroMes) {
	mesParOuImpar = numeroMes % 2;

	if (numeroMes == 2) {
		return 29;
	} else if (mesParOuImpar == 0 && numeroMes < 7) {
		return 30;
	} else if (mesParOuImpar == 1 && numeroMes <=7) {
		return 31;
	} else if (mesParOuImpar == 0 && numeroMes > 7) {
		return 31;
	} else {
		return 30;
	}
}

</script>
