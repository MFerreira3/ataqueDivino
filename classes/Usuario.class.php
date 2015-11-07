<?php
class Usuario extends Record {

	const TABLE = 'Usuarios'; // Nome da tabela no banco de dados.
	const PK = 'codUsuario'; // Primary key da tabela.

	static function usuarioExistente($usuario = null, $email = null) {
		$usuarioExistente = false;

		if (!empty($usuario)) {
			$clausulas = array(
						'select' => 'codUsuario',
						'limit' =>  1
					);

			// Verifica se o usuário existe.
			$where = array("usuario = ?", $usuario);
			$usuarioExistente = Usuario::find($where, $clausulas);
		}

		if (!empty($email)) {
			$clausulas = array(
						'select' => 'codUsuario',
						'limit' =>  1
					);

			// Verifica se o email já foi utilizado.
			$where = array("email = ?", $email);
			$usuarioExistente = Usuario::find($where, $clausulas);
		}

		return $usuarioExistente;
	}

}
?>
