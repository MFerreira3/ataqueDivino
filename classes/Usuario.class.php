<?php
class Usuario extends Record {

	const TABLE = 'Usuarios'; // Nome da tabela no banco de dados.
	const PK = 'codUsuario'; // Primary key da tabela.

	/**
	 * Verifica se uma conta específica já foi
	 * registrada a partir de seu nome de usuário ou e-mail.
	 * WIP.
	 *
	 * @param  string $usuario Nome de usuário da conta.
	 * @param  string $email   Endereço de e-mail da conta.
	 * @return mixed           Conterá um array como resultado ou false
	 *                         em caso de pesquisa sem retorno.
	 */
	static function usuarioExistente($usuario = null, $email = null) {
		$usuarioExistente = false;

		// Define que será retornado um único resultado.
		$clausulas = array(
						'select' => 'codUsuario',
						'limit' =>  1
					);

		// Pesquisa pelo usuário especificado.
		if (!empty($usuario)) {
			$where = array("usuario = ?", $usuario);
			$usuarioExistente = Usuario::find($where, $clausulas);
		}

		// Pesquisa pelo e-mail especificado.
		if (!empty($email)) {
			$where = array("email = ?", $email);
			$usuarioExistente = Usuario::find($where, $clausulas);
		}

		return $usuarioExistente;
	}


	/**
	 * Valida a criação de uma nova conta
	 * @param  string $codConfirmacao Código identificador da conta ainda não
	 *                                confirmada.
	 * @return mixed                  Retorna o resultado da operação
	 */
	static function confirmaRegistro($codConfirmacao = "") {
		$clausulas = array(
						'select' => 'codUsuario',
						'limit' =>  1
					);

		$where = array("codConfirmacao = ?", $codConfirmacao);
		$usuario = Usuario::find($where, $clausulas);

		if ($usuario) {
			// Remove o codConfirmacao usado e adiciona 1 no campo confirmado do usuário encontrado.
			$usuario = new Usuario($usuario[0]->codUsuario);
			$usuario->codConfirmacao = "NULL";
			$usuario->confirmado = 1;
			$usuario->store();

			return 0;
		} else {
			return "c5a";
		}
	}

	/**
	 * Verifica se algum hash específico já está sendo utilizado
	 * em alguma conta.
	 *
	 * @param  string $hash Hash gerado da senha.
	 * @return boolean
	 */
	static function hashExistente($hash) {
		// Define que será retornado um único resultado.
		$clausulas = array(
						'select' => 'senha',
						'limit' =>  1
					);
		$where = array("senha = ?", $hash);
		$usuarioExistente = Usuario::find($where, $clausulas);

		return ($usuarioExistente === array()) ? false : true;
	}

	/**
	 * Verifica se algum codConfirmação específico já está sendo utilizado
	 * em alguma conta.
	 *
	 * @param  string $codConfirmacao Código identificador da conta.
	 * @return boolean
	 */
	static function codConfirmacaoExistente($codConfirmacao) {
		// Define que será retornado um único resultado.
		$clausulas = array(
						'select' => 'codConfirmacao',
						'limit' =>  1
					);
		$where = array("codConfirmacao = ?", $codConfirmacao);
		$usuarioExistente = Usuario::find($where, $clausulas);

		return ($usuarioExistente === array()) ? false : true;
	}

}
?>
