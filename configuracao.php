<?php
/**
 * ============================================================================
 * Arquivo de configuração do Ataque Divino
 * ============================================================================
 */

/**
 * Carrega todas as credenciais necessárias para a execução do Ataque Divino.
 */
$diretorioPS = __DIR__ . '/ps.json';
if (file_exists($diretorioPS)) {
	$def_passes = file_get_contents($diretorioPS);
	$def_passes = json_decode($def_passes);
} else {
	die('Ocorreu um erro ao executar o Ataque Divino: Arquivo PS não encontrado.');
}
unset($diretorioPS);

/**
 * Perfil ativo atualmente. Pode ser qualquer um dos definidos no
 * array $conexoes (development ou test).
 */
$perfil = 'dev';

/**
 * Pasta do sistema no servidor. Se o servidor é acessado via
 * http://servidor.com/ataqueDivino, a variável deve conter '/ataqueDivino'.
 */
$url = '/ataqueDivino';

/**
 * locale que deve ser usado para o sistema. Esta configuração não afeta
 * a formatação de números.
 */
$locale = 'pt_BR.utf8';

/**
 * Array com as informações das conexões com o banco de dados.
 */
$conexoes = array();

/**
 * ID utilizado no cookie para iniciar a sessão do Ataque Divino
 */
$def_sessionName = md5($_SERVER['REMOTE_ADDR'].'atqDvn'.$_SERVER['HTTP_USER_AGENT']);

/**
 * Conexão com o banco principal.
 */
$conexoes['ataqueDivino'] = array();
$conexoes['ataqueDivino']['host'] = $def_passes->bdAtaqueDivino->host;
$conexoes['ataqueDivino']['db'] = $def_passes->bdAtaqueDivino->db;
$conexoes['ataqueDivino']['user'] = $def_passes->bdAtaqueDivino->user;
$conexoes['ataqueDivino']['pass'] = $def_passes->bdAtaqueDivino->pass;

/**
 * Conexão com o banco de desenvolvimento (development).
 */
$conexoes['dev'] = array();
$conexoes['dev']['host'] = $def_passes->bdDev->host;
$conexoes['dev']['db'] = $def_passes->bdDev->db;
$conexoes['dev']['user'] = $def_passes->bdDev->user;
$conexoes['dev']['pass'] = $def_passes->bdDev->pass;

setlocale(LC_ALL, 'pt_BR.utf8');
setlocale(LC_NUMERIC, 'en_US.utf8');
date_default_timezone_set('America/Sao_Paulo');
?>
