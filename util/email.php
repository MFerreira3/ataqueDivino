<?php
require_once __DIR__ . "/../definicoes.php";
require_once __DIR__ . "/PHPMailer/PHPMailerAutoload.php";

function enviarEmail($assunto, $corpo, $destinatarios) {
	global $def_passes;

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465;
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
