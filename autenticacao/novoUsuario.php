<?php
require_once __DIR__ . "/../definicoes.php";
require_once __DIR__ . "/../funcoes.php";

if (isset($_SESSION['usuario']['logado']) && $_SESSION['usuario']['logado']) {
	header('location: /ataqueDivino');
	die();
}

$numeroImagem = rand(1, 	6); // Número aleatório utilizado para definir a imagem de fundo.
$anoAtual = date('Y');
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
					<div class="field">
						<label for="user">Usuário</label>
						<input placeholder="Usuário" name="usuario" id="usuario" type="text">
					</div>

					<div class="field">
						<label for="email">E-mail</label>
						<input placeholder="E-mail" name="email" id="email" type="text">
					</div>
				</div>
				<br />
				<div class="two fields">
					<div class="field">
						<label for="senha">Senha</label>
						<input placeholder="Senha" name="senha" id="senha" type="password">
					</div>

					<div class="field">
						<label for="confirmarSenha">Confirmar Senha</label>
						<input placeholder="Repita senha" name="confirmarSenha" id="confirmarSenha" type="password">
					</div>
				</div>
				<h5>Data de Nascimento:</h5>
				<div class="three fields">
					<div class="field">
						<label for="diaNascimento">Dia</label>
						<input placeholder="Dia" name="diaNascimento" id="diaNascimento" type="number">
					</div>

					<div class="field">
						<label for="mesNascimento">Mês</label>
						<select class="ui fluid search dropdown" name="mesNascimento" id="mesNascimento" placeholder="Mês">
							<?php
							for ($numeroMes = 1; $numeroMes <= 12; $numeroMes++) {
								echo '<option value="' . $numeroMes . '">' . mesNome($numeroMes)  . '</option>';
							}
							?>
						</select>
					</div>

					<div class="field">
						<label for="anoNascimento">Ano</label>
						<input placeholder="Ano" name="anoNascimento"  id="anoNascimento" type="number">
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
<!--Parteu Ajax \o/-->
<script>
$(document).ready(function() {
	$('#botaoSubmit').click(function() {
		camposValidos = true;

		if (!$('#usuario').val()) {
			alert('Preencha o campo de usuário');
			camposValidos = false;
		} else if ($('#usuario').val().length > 25) {
			alert('Limite de 25 caracteres no campo de usuário');
			camposValidos = false;
		}

		if (!$('#email').val()) {
			alert('Preencha o campo de e-mail');
			camposValidos = false;
		} else if ($('#email').val().length > 100) {
			alert('Limite de 100 caracteres no campo de e-mail');
			camposValidos = false;
		}

		if (!$('#senha').val()) {
			alert('Preencha o campo de senha');
			camposValidos = false;
		}

		if (!$('#confirmarSenha').val()) {
			alert('Confirme sua senha');
			camposValidos = false;
		} else if ($('#confirmarSenha').val() != $('#senha').val()) {
			alert('Digite as senhas exatamente iguais');
			camposValidos = false;
		}

		if (!$('#diaNascimento').val()) {
			alert('Preencha o campo de dia');
			camposValidos = false;
		} else if ($('#diaNascimento').val() > 31) {
			alert($('#diaNascimento').val() + ' não é uma data válida');
			camposValidos = false;
		}

		if (!$('#anoNascimento').val()) {
			alert('Preencha o campo de ano');
			camposValidos = false;
		} else if ($('#anoNascimento').val() > <?= $anoAtual ?>) {
			alert($('#anoNascimento').val() + ' não é um ano válido');
			camposValidos = false;
		}

		if (camposValidos == true) {
			enviarFormulario();
		}
	});

	function enviarFormulario() {
		dadosFormulario = $('#formularioRegistro').serialize();
		$.post('validarRegistro.php', dadosFormulario, function(resultado) {
			alert(resultado);
		});
	}

});

</script>
