<?php
/**
* @Minerva
* Recebe uma variável e imprime informações sobre ela.
*
* @param  mixed  &$valor   Variável a ser debugada. É importante
*                          que seja utilizado uma variável nesse
*                          parâmetro e não um dado.
* @param  boolean $popup   Define se as informações devem ser
*                          ou não exibidas dentro de um pop-up.
* @param  boolean $exit    Define se a execução do código
*                          deve ser parada no fim dessa função
*/
function debug(&$valor, $popup = false, $exit = false, $titulo = null) {
	global $perfil;
	$header = "";

	if ($perfil != 'minerva') {
		// Define o texto de acordo com o tipo de dado.
		if (isset($valor)) {
			if (is_array($valor)) {
				$header = 'A variável contém um Array:';

			} else if (is_object($valor)) {
				$header = 'A variável contém um Objeto:';

			} else if (is_string($valor)) {
				$header = 'A variável contém uma String:';

			} else if (is_integer($valor) || is_numeric($valor)) {
				$header = 'A variável contém um número:';
			}

			$texto = print_r($valor, true);
		} else {
			$texto = "<div class='red'><i class='icon Remove'></i>A variável não contém nenhum dado atribuido a ele.</div>";
		}

		// Define o titulo personalizado caso algum tenha sido especificado.
		$header = isset($titulo) ? $titulo : $header;

		// Organiza a mensagem caso não seja exibido o modal.
		$corpo = "<div class='ui message' style='font-size:10px; width:90%; margin-left: 50px;'><pre><hr size='0'>";
		$corpo = isset($header) ? $corpo . '<div class="header">' . $header . '</div><hr size="0">': $corpo;
		$corpo = $corpo . $texto;
		$corpo = $corpo . "<hr size='0'/></pre></div>";

		// Verifica se houve a chamada do modal.
		if ($popup) {
			echo <<<END
			<script>
			$(document).ready(function() {
				$('.ui.modal') .modal('show');
			});
			</script>

			<div class="ui modal">
				<div class="header">
					$header
				</div>
				<div class="content">
					<div class="description">
						<pre>$texto</pre>
					</div>
				</div>
				<div class="actions">
					<div class="ui black deny button">
						Fechar
					</div>
				</div>
			</div>
END;
		} else {
			echo $corpo;
		}

		// Finaliza a execução do código se for pedido.
		if ($exit) {
			exit();
		}
	}
}

/**
* Retorna uma notificação específica para evitar a repetição de texto
* no código
* @param String          $indice Identificador da notificação.
* @return  String         Mensagem correspondente ao identificador.
*/
function notificacoes($indice) {

# Erros

// Erros especiais.
$mensagem['json'] = json_last_error_msg();

return $mensagem[$indice];
}


/*
* Em algumas versões do PHP não é encontrada a função json_last_error_msg(),
* o teste condicional abaixo verifica se a função existe,
* caso não, a função será recriada.
*/
if (!function_exists('json_last_error_msg')) {
	function json_last_error_msg() {
		static $ERRORS = array(
		JSON_ERROR_NONE => 'No error',
		JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
		JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
		JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
		JSON_ERROR_SYNTAX => 'Syntax error',
		JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
		);

		$error = json_last_error();
		return isset($ERRORS[$error]) ? $ERRORS[$error] : 'Unknown error';
	}
}
?>
