<?php
/**
 * ============================================================================
 * Arquivo de configuração do Sistema Ataque Divino
 * ============================================================================
 */

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
$conexoes['ataqueDivino']['host'] = 'sql5.freemysqlhosting.net';
$conexoes['ataqueDivino']['db'] = 'sql592092';
$conexoes['ataqueDivino']['user'] = 'sql592092';
$conexoes['ataqueDivino']['pass'] = 'fK1%lB7*';

/**
 * Conexão com o banco de desenvolvimento (development).
 */
$conexoes['dev'] = array();
$conexoes['dev']['host'] = 'localhost';
$conexoes['dev']['db'] = 'ataquedivino';
$conexoes['dev']['user'] = 'ataquedivino';
$conexoes['dev']['pass'] = 'zj7dqvKhe4NtG88X';

setlocale(LC_ALL, 'pt_BR.utf8');
setlocale(LC_NUMERIC, 'en_US.utf8');
date_default_timezone_set('America/Sao_Paulo');
?>
