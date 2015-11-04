<?php
require_once __DIR__ . "/../definicoes.php";
require_once __DIR__ . "/../funcoes.php";

if (isset($_SESSION['usuario']['logado']) && $_SESSION['usuario']['logado']) {
	header('location: /ataqueDivino');
	die();
}

const SITE_KEY = "6LchDBATAAAAAAa0ChytPll41ArGnhdsdL4IN_-t"; //Constante do site para implementação do reCAPTCHA;

$numeroImagem = rand(1, 6); // Número aleatório utilizado para definir a imagem de fundo;
?>

<style>
label {
	float: left;
}

.form-holder {
	background: rgba(0, 0, 0, 0.85);
	margin-top: 12%;
	border-radius: 20px;
	box-shadow: 0px 0px 20px  rgb(0, 0, 0);
}
body {
	color: #DFDFD7;
}
</style>

<body style="background: url('/ataqueDivino/imagens/<?= $numeroImagem ?>.jpg') fixed; background-size: cover;">
<div class="ui one column blurring center aligned grid" id="frameLogin">
	<div class="column six wide form-holder" id="areaLogin">
		<div class="ui inverted form">
			<form name="formularioRegistro" id="formularioRegistro">
				<input type="hidden" name="g-response" id="grecaptcha-response" />
				<div class="two fields">
					<div class="field" id="fieldUsuario">
						<label for="user">Usuário</label>
						<input placeholder="Usuário" name="usuario" id="usuario" type="text" data-position="left center">
					</div>

					<div class="field" id="fieldEmail">
						<label for="email">E-mail</label>
						<input placeholder="E-mail" name="email" id="email" type="text" data-position="right center">
					</div>
				</div>
				<br />
				<div class="two fields">
					<div class="field" id="fieldSenha">
						<label for="senha">Senha</label>
						<input placeholder="Senha" name="senha" id="senha" type="password" data-position="left center">
					</div>

					<div class="field" id="fieldConfirmarSenha">
						<label for="confirmarSenha">Confirmar Senha</label>
						<input placeholder="Repita senha" id="confirmarSenha" type="password" data-position="right center">
					</div>
				</div>

				<h5>Data de Nascimento: (Mínimo de 13 anos)</h5>
				<div class="three fields">
					<div class="field" id="fieldDiaNascimento">
						<label for="diaNascimento">Dia</label>
						<input placeholder="Dia" name="diaNascimento" id="diaNascimento" type="number" data-content="Preencha o campo com uma data válida" data-position="left center">
					</div>

					<div class="field" id="fieldMesNascimento">
						<label for="mesNascimento">Mês</label>
						<select class="ui fluid search dropdown" name="mesNascimento" id="mesNascimento" placeholder="Mês" data-content="Escolha um mês válido" data-position="bottom center">
							<?php
							for ($numeroMes = 1; $numeroMes <= 12; $numeroMes++) {
								echo '<option value="' . $numeroMes . '">' . mesNome($numeroMes)  . '</option>';
							}
							?>
						</select>
					</div>

					<div class="field" id="fieldAnoNascimento">
						<label for="anoNascimento">Ano</label>
						<input placeholder="Ano" name="anoNascimento"  id="anoNascimento" type="number" data-content="Preencha o campo com um ano válido" data-position="right center">
					</div>
				</div>
			</form>
			<div class="ui divider"></div>
			<div class="g-recaptcha" data-sitekey="<?= SITE_KEY ?>" id="reCAPTCHA" data-theme="dark" data-content="Faça a verificação de reCAPTCHA" data-position="left center"></div>
			<br />

			<button class="ui violet  labeled icon button" id="botaoSubmit">
				<i class="add user icon"></i>
				Registrar
			</button>
		</div>
	</div>
</div>
</body>

<?php /* Parteu Ajax \o/ */ ?>

<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
$(document).ready(function() {
	$('#botaoSubmit').click(function() {
		if (!$('#botaoSubmit').hasClass('disabled') || !$('#botaoSubmit').hasClass('loading')) {
			$('#botaoSubmit').addClass('loading');
			$('#botaoSubmit').addClass('disabled');
			// Setando variáveis de verificação de campos.
			camposInvalidos = new Array();
			anoAtual = <?= date('Y') ?>; // Variável de ano do servidor.
			mesAtual = <?= date('m') ?>; // Variável de mês do servidor.
			diaAtual = <?= date('d') ?>; // Variável de dia do servidor.
			diasMesMaximo = mesDiaMaximo($('#mesNascimento').val()); // Chamando a função que determina a quantia máxima de dias que certo mês pode ter.

			grecaptchaResponse = grecaptcha.getResponse(); // Obtendo a resposta do reCAPTCHA.
			$('#grecaptcha-response').val(grecaptchaResponse); // Guarda a validação do reCAPTCHA para envio via formulário;
			camposNomes =  [ // Dá nome para todos os campos;
				"usuario",
				"email",
				"senha",
				"confirmarSenha",
				"anoNascimento",
				"mesNascimento",
				"diaNascimento",
				"reCAPTCHA"
			];

			// Resetando popup de campos, fazendo com que não apareçam novamente caso tenham sido preenchidos ou reapareçam caso apagados.
			// Adicionando classe error nos campos que não passarem pela pré-validação.
			$('#fieldUsuario, #fieldEmail, #fieldSenha, #fieldConfirmarSenha, #fieldDiaNascimento, #fieldMesNascimento, #fieldAnoNascimento').removeClass('error');
			$('#usuario, #Email, #senha, #confirmarSenha, #diaNascimento, #mesNascimento, #anoNascimento, #reCAPTCHA').popup('hide');
			$('#usuario, #Email, #senha, #confirmarSenha, #diaNascimento, #mesNascimento, #anoNascimento, #reCAPTCHA').popup('destroy');

			// Pré-validação do campo e-mail, usando regex para que os campos possuam ao menos um "@ algumacoisa.com/.br/.uk/.jp etc".
			function validarEmail(email) {
				regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return regex.test(email);
			}

			// Pré-validação de idade com um mínimo de 13 anos para ser aceito.
			function validarIdade(diaNascimento, mesNascimento, anoNascimento) {
				if (anoNascimento > anoAtual - 13) {
					return false;
				} else if (anoNascimento < anoAtual - 13) {
					return true;
				}

				if (mesNascimento > mesAtual) {
					return false;
				} else if (mesNascimento < mesAtual) {
					return true;
				}

				if (diaNascimento > diaAtual) {
					return false;
				}

				return true;
			}

			// Pré-validação dos campos, exibe alertas caso não passem pela pré-validação;
			if (!$('#usuario').val()) {
				$('#usuario').attr('data-content', "Preencha o campo de usuário");
				$('#fieldUsuario').addClass('error');
				camposInvalidos[0] = true;
			} else if ($('#usuario').val().length > 25) {
				$('#usuario').attr('data-content', "Preencha o campo de usuário com no máximo 25 caracteres");
				$('#fieldUsuario').addClass('error');
				camposInvalidos[0] = true;
			} else if ($('#usuario').val().length < 3) {
				$('#usuario').attr('data-content', "Preencha o campo de usuário com no mínimo 3 caracteres");
				$('#fieldUsuario').addClass('error');
				camposInvalidos[0] = true;
			}

			if (!$('#email').val()) {
				$('#email').attr('data-content', "Preencha o campo de E-mail");
				$('#fieldEmail').addClass('error');
				camposInvalidos[1] = true;
			} else if ($('#email').val().length > 100) {
				$('#email').attr('data-content', "Preencha o campo de E-mail com no máximo 100 caracteres");
				$('#fieldEmail').addClass('error');
				camposInvalidos[1] = true;
			} else if (!validarEmail($('#email').val())) {
				$('#email').attr('data-content', "Preencha o campo com um E-mail válido");
				$('#fieldEmail').addClass('error');
				camposInvalidos[1] = true;
			}

			if (!$('#senha').val()) {
				$('#senha').attr('data-content', "Preencha o campo de senha");
				$('#fieldSenha').addClass('error');
				camposInvalidos[2] = true;
			} else if ($('#senha').val().length < 8) {
				$('#senha').attr('data-content', "Preencha o campo de senha com no mínimo 8 caracteres");
				$('#fieldSenha').addClass('error');
				camposInvalidos[2] = true;
			}

			if (!$('#confirmarSenha').val()) {
				$('#confirmarSenha').attr('data-content', "Repita sua senha");
				$('#fieldConfirmarSenha').addClass('error');
				camposInvalidos[3] = true;
			} else if ($('#confirmarSenha').val() != $('#senha').val()) {
				$('#confirmarSenha').attr('data-content', "As senhas digitadas não coincidem");
				$('#fieldConfirmarSenha').addClass('error');
				camposInvalidos[3] = true;
			}

			if (!$('#anoNascimento').val() || !validarIdade($('#diaNascimento').val(), $('#mesNascimento').val(), $('#anoNascimento').val()) || $('#anoNascimento').val() <= anoAtual - 100) {
				$('#fieldAnoNascimento').addClass('error');
				camposInvalidos[4] = true;
			}

			if (!$('#mesNascimento') || !validarIdade($('#diaNascimento').val(), $('#mesNascimento').val(), $('#anoNascimento').val())) {
				$('#fieldMesNascimento').addClass('error');
				camposInvalidos[5] = true;
			}

			if (!$('#diaNascimento').val() || $('#diaNascimento').val() < 1 || $('#diaNascimento').val() > diasMesMaximo || !validarIdade($('#diaNascimento').val(), $('#mesNascimento').val(), $('#anoNascimento').val())) {
				$('#fieldDiaNascimento').addClass('error');
				camposInvalidos[6] = true;
			}

			if (!grecaptchaResponse) {
				camposInvalidos[7] = true;
			}

			// Verifica quais campos foram setados como true, e adiciona o popup de erro para cada campo que deu erro.
			for (campos = 0; campos < 8; campos++) {
				if (camposInvalidos[campos]) {
					$('#' + camposNomes[campos]).popup({on: 'focus'});
					$('#' + camposNomes[campos]).popup('show');
				}
			}

			// Envia os dados para a validação.
			if (camposInvalidos.length < 1) {
				enviarFormulario();
			} else {
				$('#botaoSubmit').removeClass('loading');
				$('#botaoSubmit').removeClass('disabled');
			}
		}
	});

	// WIP: Envia os dados para a página de validação e recebe os resultados.
	function enviarFormulario() {
		dadosFormulario = $('#formularioRegistro').serialize();

		$.post('validarRegistro.php', dadosFormulario, function(resultado) {
			$('#botaoSubmit').removeClass('loading');
			alert(resultado);

			if (resultado != 0) {
				$('#botaoSubmit').removeClass('disabled');
				return false;
			}
		}).fail(function() {
			alert("Tempo de conexão esgotado, tente novamente mais tarde");
			$('#botaoSubmit').removeClass('loading');
			$('#botaoSubmit').removeClass('disabled');
			return false;
		});
	}
});
</script>
