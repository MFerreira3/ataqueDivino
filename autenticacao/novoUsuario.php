<?php
require_once __DIR__ . "/../definicoes.php";
if (isset($_SESSION['usuario']['logado']) && $_SESSION['usuario']['logado']) {
	header('location: /ataqueDivino');
	die();
}
$numeroImagem = rand(1, 6); // Número aleatório utilizado para definir a imagem de fundo.
$bg_color = array('Red' => rand(0, 255), 'Green' => rand(0, 255), 'Blue' => rand(0, 255)); // Define uma cor aleatória para cada acesso na página.
?>
<style>
label {
	color: white;
	float: left;
}

.form-holder {
	background: rgba(0, 0, 0, 0.85);
	margin-top: 12%;
	border-radius: 20px;
	box-shadow: 0px 0px 20px  rgb(0, 0, 0);
}
button {
	width: 50%;
}
</style>

<body style="background: url('/ataqueDivino/imagens/<?= $numeroImagem ?>.jpg') fixed; background-size: cover;">

<div class="ui one column blurring center aligned grid" id="frameLogin">
	<div class="column six wide form-holder" id="areaLogin">
		<div class="ui inverted form">
			<div class="two fields">
				<div class="field">
					<label for="user">Usuário</label>
					<input placeholder="Usuário" name="usuario" type="text">
				</div>
				<div class="field">
					<label for="email">E-mail</label>
					<input placeholder="E-mail" name="email" type="text">
				</div>
			</div>
			<br />
			<div class="two fields">
				<div class="field">
					<label for="senha">Senha</label>
					<input placeholder="Senha" name="senha" type="password">
				</div>
				<div class="field">
					<label for="confirmarSenha">Confirmar Senha</label>
					<input placeholder="Repita senha" name="confirmarSenha" type="password">
				</div>
			</div>
			<p >Data de Nascimento:</p>
			<div class="ui center aligned fields">
				<div class="field">
					<label for="diaNascimento">Dia</label>
					<input placeholder="Dia" name="diaNascimento" type="number">
				</div>
				<div class="field">
					<label for="mesNascimento">Mês</label>
					<select class="ui fluid search dropdown" name="mesNascimento">
						<option value="">Mês</option>
						<option value="1">Janeiro</option>
						<option value="2">Fervereiro</option>
						<option value="3">Março</option>
						<option value="4">Abril</option>
						<option value="5">Maio</option>
						<option value="6">Junho</option>
						<option value="7">Julho</option>
						<option value="8">Agosto</option>
						<option value="9">Setembro</option>
						<option value="10">Outrubro</option>
						<option value="11">Novembro</option>
						<option value="12">Dezembro</option>
					</select>
				</div>
				<div class="field">
					<label for="anoNascimento">Ano</label>
					<input placeholder="Ano" name="anoNascimento" type="number">
				</div>
			</div>
			<br />
			<br />
			<br />
			<div class="ui  labeled icon buttons" >
				<button class="ui violet button">
					<i class="add user icon"></i>
					Registrar
				</button>
				<button class="ui red button">
					<i class="undo icon"></i>
					Cancelar
				</button>
		</div>
	</div>
</div>
</body>