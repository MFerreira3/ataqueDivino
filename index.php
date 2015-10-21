<?php
require_once "autoload.php";
require_once "definicoes.php";

$numeroImagem = rand(1, 6); // Número aleatório utilizado para definir a imagem de fundo.
?>
<body style="background: url('imagens/<?= $numeroImagem ?>.jpg') fixed; background-size: cover;">
<div class="ui inverted segment" style="height: 99px; background: rgba(0, 0, 0, 0.75);">
	<p style="font-size: 40; display: inline; float: left; margin-top: 4px">Ataque Divino</p>
	<div class="huge ui red secondary pointing menu" style="display: inline-flex; margin-left: 500px; opacity: 0.6; margin-top: 28px;">
		<a class="active item">
			Home
		</a>
		<a class="item" style="color: white;">
			Placeholder
		</a>
		<a class="item" style="color: white;">
			Placeholder
		</a>
	</div>
	<div class="ui inverter segment" style="display: inline; float: right; margin-top: -6px; margin-right: -20px; background: rgba(0, 0, 0, 0.75);">

		<div class="mini violet ui vertical labeled icon buttons" style="float: right; margin-top: 2px; margin-right: -10px">
			<button class="ui button">
				<i class="sign in icon"></i>
				Login
			</button>
			<button class="ui button">
				<i class="add user icon"></i>
				Registrar
			</button>
		</div>

		<div class="ui mini input focus">
			<input type="text" placeholder="Usuário" name="user">
		</div>
		<br />
		<div class="ui mini input focus">
			<input type="password" placeholder="Senha" name="senha">
		</div>
	</div>
</div>

<div class="ui inverted segment" style="width: 1000px; margin: 0 auto; margin-top: 250px; height: 100%; background: transparent;">
	<div class="ui attached tabular inverted four item menu aba">
		<a class="item aba" data-tab="sicro">Jogo</a>
			<a class="item active aba" data-tab="importar">Placeholder</a>
			<a class="item aba" data-tab="tres">Placeholder</a>
			<a class="item aba" data-tab="quatro">Placeholder</a>
	</div>

	<div class="ui inverted bottom attached raised tab segment" data-tab="sicro" style="height: 100%;">
			<p>Ai você fala o seguinte: "- Mas vocês acabaram isso?" Vou te falar: -"Não, está em andamento!" Tem obras que "vai" durar pra depois de 2010. Agora, por isso, nós já não desenhamos, não começamos a fazer projeto do que nós "podêmo fazê"? 11, 12, 13, 14... Por que é que não?</p>
		</div>

		<div class="ui inverted bottom attached tab raised segment active" data-tab="importar" style="height: 100%;">
			<p>No meu xinélo da humildade eu gostaria muito de ver o Neymar e o Ganso. Por que eu acho que.... 11 entre 10 brasileiros gostariam. Você veja, eu já vi, parei de ver. Voltei a ver, e acho que o Neymar e o Ganso têm essa capacidade de fazer a gente olhar.</p>

			<p>Ai você fala o seguinte: "- Mas vocês acabaram isso?" Vou te falar: -"Não, está em andamento!" Tem obras que "vai" durar pra depois de 2010. Agora, por isso, nós já não desenhamos, não começamos a fazer projeto do que nós "podêmo fazê"? 11, 12, 13, 14... Por que é que não?</p>

			<p>Eu dou dinheiro pra minha filha. Eu dou dinheiro pra ela viajar, então é... é... Já vivi muito sem dinheiro, já vivi muito com dinheiro. -Jornalista: Coloca esse dinheiro na poupança que a senhora ganha R$10 mil por mês. -Dilma: O que que é R$10 mil?</p>

			<p>Se hoje é o dia das crianças... Ontem eu disse: o dia da criança é o dia da mãe, dos pais, das professoras, mas também é o dia dos animais, sempre que você olha uma criança, há sempre uma figura oculta, que é um cachorro atrás. O que é algo muito importante!</p>

			<p>A população ela precisa da Zona Franca de Manaus, porque na Zona franca de Manaus, não é uma zona de exportação, é uma zona para o Brasil. Portanto ela tem um objetivo, ela evita o desmatamento, que é altamente lucravito. Derrubar arvores da natureza é muito lucrativo!</p>

			<p>Primeiro eu queria cumprimentar os internautas. -Oi Internautas! Depois dizer que o meio ambiente é sem dúvida nenhuma uma ameaça ao desenvolvimento sustentável. E isso significa que é uma ameaça pro futuro do nosso planeta e dos nossos países. O desemprego beira 20%, ou seja, 1 em cada 4 portugueses.</p>

			<p>Todos as descrições das pessoas são sobre a humanidade do atendimento, a pessoa pega no pulso, examina, olha com carinho. Então eu acho que vai ter outra coisa, que os médicos cubanos trouxeram pro brasil, um alto grau de humanidade.</p>

			<p>A única área que eu acho, que vai exigir muita atenção nossa, e aí eu já aventei a hipótese de até criar um ministério. É na área de... Na área... Eu diria assim, como uma espécie de analogia com o que acontece na área agrícola.</p>
		</div>

		<div class="ui inverted bottom attached tab raised segment" data-tab="tres" style="height: 100%;">
		</div>

		<div class="ui inverted bottom attached tab raised segment" data-tab="quatro" style="height: 100%;">
</div>
</body>

<script>
$(document).ready(function() {
	$('.aba').tab();
});
</script>