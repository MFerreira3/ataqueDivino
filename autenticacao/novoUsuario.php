<?php
require_once __DIR__ . "/../definicoes.php";
require_once __DIR__ . "/../funcoes.php";

if (isset($_SESSION['usuario']['logado']) && $_SESSION['usuario']['logado']) {
	header('location: /ataqueDivino');
	die();
}

$numeroImagem = rand(1, 6); // Número aleatório utilizado para definir a imagem de fundo.;
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
				<div class="two fields">
					<div class="field" id="fieldUsuario">
						<label for="user">Usuário</label>
						<input placeholder="Usuário" name="usuario" id="usuario" type="text" data-content="Preencha o campo com no máximo 25 caracteres" data-position="left center">
					</div>

					<div class="field" id="fieldEmail">
						<label for="email">E-mail</label>
						<input placeholder="E-mail" name="email" id="email" type="text" data-content="Preencha o campo com um endereço válido" data-position="right center">
					</div>
				</div>
				<br />
				<div class="two fields">
					<div class="field" id="fieldSenha">
						<label for="senha">Senha</label>
						<input placeholder="Senha" name="senha" id="senha" type="password" data-content="Digite uma senha" data-position="left center">
					</div>

					<div class="field" id="fieldConfirmarSenha">
						<label for="confirmarSenha">Confirmar Senha</label>
						<input placeholder="Repita senha" name="confirmarSenha" id="confirmarSenha" type="password" data-content="As senhas digitadas não coincidem" data-position="right center">
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
				<div class="ui divider"></div>
			</form>
			<button class="ui violet  labeled icon button" id="botaoSubmit">
				<i class="add user icon"></i>
				Registrar
			</button>
		</div>
	</div>
</div>
</body>
<?php /* Parteu Ajax \o/ */ ?>
<script>
$(document).ready(function() {
	$('#botaoSubmit').click(function() {
		//Setando variaveis de verificação de campos;
		camposValidos = true;
		anoAtual = <?= date('Y') ?>;
		mesAtual = <?= date('m') ?>;
		diaAtual = <?= date('d') ?>;
		diasMesMaximo = mesDiaMaximo($('#mesNascimento').val());

		//Resetando popup de campos, fazendo com que não apareçam novamente caso tenham sido preenchidos ou reapareçam caso apagados;
		//Adicionando classes error nos campos que não passarem pela pré validação;
		$('#fieldUsuario, #fieldEmail, #fieldSenha, #fieldConfirmarSenha, #fieldDiaNascimento, #fieldMesNascimento, #fieldAnoNascimento').removeClass('error');
		$('#usuario, #Email, #senha, #confirmarSenha, #diaNascimento, #mesNascimento, #anoNascimento').popup('hide');
		$('#usuario, #Email, #senha, #confirmarSenha, #diaNascimento, #mesNascimento, #anoNascimento').popup('destroy');

		//Pré-validação do campo e-mail, usando regex para que os campos possuam ao menos um "@ algumacoisa.com/.br/.uk/.jp etc";
		function validarEmail(email) {
			regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return regex.test(email);
		}

		//Pre-validação de idade com um mínimo de 13 anos para poder validar;
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

		//Pré-validação dos campos, exibe alertas caso não passem pela pré-validação;
		if (!$('#usuario').val() || $('#usuario').val().length > 25) {
			$('#usuario').popup({on: 'focus'});
			$('#usuario').popup('show');
			$('#fieldUsuario').addClass('error');
			camposValidos = false;
		}

		if (!$('#email').val() || $('#email').val().length > 100 || !validarEmail($('#email').val())) {
			$('#email').popup({on: 'focus'});
			$('#email').popup('show');
			$('#fieldEmail').addClass('error');
			camposValidos = false;
		}

		if (!$('#senha').val()) {
			$('#senha').popup({on: 'focus'});
			$('#senha').popup('show');
			$('#fieldSenha').addClass('error');
			camposValidos = false;
		}

		if (!$('#confirmarSenha').val() || $('#confirmarSenha').val() != $('#senha').val()) {
			$('#confirmarSenha').popup({on: 'focus'});
			$('#confirmarSenha').popup('show');
			$('#fieldConfirmarSenha').addClass('error');
			camposValidos = false;
		}

		if (!$('#anoNascimento').val() || !validarIdade($('#diaNascimento').val(), $('#mesNascimento').val(), $('#anoNascimento').val()) || $('#anoNascimento').val() <= anoAtual - 100) {
			$('#anoNascimento').popup({on: 'focus'});
			$('#anoNascimento').popup('show');
			$('#fieldAnoNascimento').addClass('error');
			camposValidos = false;
		}

		if (!$('#mesNascimento') || !validarIdade($('#diaNascimento').val(), $('#mesNascimento').val(), $('#anoNascimento').val())) {
			$('#mesNascimento').popup({on: 'focus'});
			$('#mesNascimento').popup('show');
			$('#fieldMesNascimento').addClass('error');
			camposValidos = false;
		}

		if (!$('#diaNascimento').val() || $('#diaNascimento').val() < 1 || $('#diaNascimento').val() > diasMesMaximo || !validarIdade($('#diaNascimento').val(), $('#mesNascimento').val(), $('#anoNascimento').val())) {
			$('#diaNascimento').popup({on: 'focus'});
			$('#diaNascimento').popup('show');
			$('#fieldDiaNascimento').addClass('error');
			camposValidos = false;
		}

		//Envia os dados para a validação;
		if (camposValidos) {
			enviarFormulario();
		}
	});

	//Envia os dados para a página de validação e recebe os resultados WIP;
	function enviarFormulario() {
		dadosFormulario = $('#formularioRegistro').serialize();
		$.post('validarRegistro.php', dadosFormulario, function(resultado) {
			alert(resultado);
		});
	}

});

</script>
