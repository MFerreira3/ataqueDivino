<?php
require_once __DIR__ . "/../definicoes.php";
require_once __DIR__ . "/PHPMailer/PHPMailerAutoload.php";

/**
 * Realiza o envio de uma mensagem eletrônica
 * a uma lista de endereços de email.
 * @param  string $assunto       Assunto da mensagem
 * @param  string $corpo         Corpo da mensagem
 * @param  mixed $destinatarios	 E-mails que receberão a mensagem, pode conter uma
 *                               String com um e-mail ou um array com uma lista.
 * @return mixed                 0 para sucesso ou a mensagem de falha em caso de erro.
 */
function enviarEmail($assunto, $corpo, $destinatarios) {
	global $def_passes;

	$mail = new PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->IsHTML(true);
	$mail->Username = $def_passes->email->username;
	$mail->Password = $def_passes->email->password;
	$mail->SetFrom($def_passes->email->username);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;

	if (is_array($destinatarios)) {
		foreach ($destinatarios as $destinatario) {
			$mail->AddAddress($destinatario);
		}
	} else {
		$mail->AddAddress($destinatarios);
	}

	if (!$mail->Send()) {
		return $mail->ErrorInfo;
	} else {
		return 0;
	}
}
?>
