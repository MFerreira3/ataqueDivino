<?php
final class ConnectionFactory {

	private static $cache = array();

	private function __construct() {
		// não permite que a classe seja instanciada
	}

	/**
	 * Cria a conexão com o banco de dados.
	 * @return PDO
	 */
	static function getConnection($perfil = null) {
		// conexões do arquivo de configuração
		global $conexoes;

		// caso o perfil esteja vazio, busca no arquivo de configuração
		if (empty($perfil)) {
			global $perfil;
		}

		// só cria uma nova conexão caso a mesma ainda não exista
		if (empty(self::$cache[$perfil])) {
			$config = $conexoes[$perfil];

			// se não existir, lança uma exceção
			if (empty($config)) {
				throw new Exception('Perfil de conexão ' . $perfil . ' não é valido');
			}

			// cria o objeto PDO
			$host = $config['host'];
			$banco = $config['db'];
			$usuario = $config['user'];
			$senha = $config['pass'];
			$conexao = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);

			// define que o encoding de todas as consultas é UTF-8
			$conexao->exec("SET NAMES 'utf8'");
			$conexao->exec('SET character_set_connection=utf8');
			$conexao->exec('SET character_set_client=utf8');
			$conexao->exec('SET character_set_results=utf8');

			// caso ocorra algum erro de SQL, lança uma exceção
			$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// armazena a conexão no cache
			self::$cache[$perfil] = $conexao;
		}

		return self::$cache[$perfil];
	}

}
?>
