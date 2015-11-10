<?php
class Usuario extends Record {

	const TABLE = 'Usuarios'; // Nome da tabela no banco de dados.
	const PK = 'codUsuario'; // Primary key da tabela.

	/**
	 * Verifica se uma conta específica já foi
	 * registrada a partir de seu nome de usuário ou e-mail.
	 * @param  string $usuario Nome de usuário da conta.
	 * @param  string $email   Endereço de e-mail da conta.
	 * @return mixed           Conterá um array como resultado ou false
	 *                         em caso de pesquisa sem retorno.
	 */
	static function usuarioExistente($usuario = null, $email = null) {
		$usuarioExistente = false;

		if (!empty($usuario)) {
			$clausulas = array(
						'select' => 'codUsuario',
						'limit' =>  1
					);

			// Pesquisa pelo usuário especificado.
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
