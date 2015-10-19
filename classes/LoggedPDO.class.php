<?php
function startsWith($haystack, $needle) {
	return stripos($haystack, $needle) === 0;
}

function logSQL($statement) {
	if (!isset($_SESSION)) {
		// caso o usuário não esteja logado ainda, não é necessário fazer o
		// registro de alteração de usuário e senha no momento do login
		return;
	}
	if (startsWith($statement, 'INSERT')
			|| startsWith($statement, 'UPDATE')
			|| startsWith($statement, 'DELETE')) {
		MySQLLogger::log($_SERVER['REMOTE_ADDR'], $_SESSION['codPessoa'], $statement);
	}
}

class LoggedPDO extends PDO {

	public function exec($statement) {
		logSQL($statement);

		return parent::exec($statement);
	}

	public function query($statement) {
		logSQL($statement);

		return parent::query($statement);
	}

}

final class MySQLLogger {

	private static $mysqli;

	static function init($host, $user, $pass, $db) {
		self::$mysqli = new mysqli($host, $user, $pass, $db);
		self::$mysqli->set_charset('utf8');
	}

	static function log($ip, $codUsuario, $consulta) {
		$stmt = self::$mysqli->prepare('INSERT INTO Logs (ip, codUsuario, consulta, dataHora) VALUES (?, ?, ?, NOW())');
		$stmt->bind_param('sis', $ip, $codUsuario, $consulta);
		$stmt->execute();
	}

}
?>
