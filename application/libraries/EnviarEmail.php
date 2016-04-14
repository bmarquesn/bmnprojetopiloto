<?php
class EnviarEmail {
	public function enviar_email($From,$FromName,$addNameAddress,$AddAddress,$Subject,$Body,$AltBody = null,$addCC = null) {
		require_once("PHPMailer/PHPMailerAutoload.php");
		
		// Inicia a classe PHPMailer
		$mail = new PHPMailer();
		$mail->IsSMTP(); // Define que a mensagem será SMTP

		// Define os dados do servidor e tipo de conexão
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->Host = 'smtp.googlemail.com'; // Endereço do servidor SMTP
		$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
		//$mail->SMTPDebug = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465; 
		//$mail->Port = 587;
		$mail->Username = 'developer.bmn@gmail.com'; // Usuário do servidor SMTP
		$mail->Password = 'bruno696'; // Senha do servidor SMTP

		// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->From = $From; // Seu e-mail
		$mail->FromName = $FromName; // Seu nome

		// Define os destinatário(s)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->AddAddress('fulano@dominio.com.br', 'Fulano da Silva');
		$mail->AddAddress($AddAddress, $addNameAddress);
		
		if(!empty($addCC)) {
			foreach($addCC as $key => $value) {
				$mail->AddCC($value['email'], $value['nome']); // Copia
			}
		}
		//$mail->AddBCC('developer@crosshost.com.br', 'Developer Crosshost'); // Cópia Oculta

		// Define os dados técnicos da Mensagem
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

		// Define a mensagem (Texto e Assunto)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->Subject  = $Subject; // Assunto da mensagem
		$mail->Body = utf8_decode(nl2br($Body));
		
		if(!empty($AltBody)) {
			$mail->AltBody = utf8_decode($AltBody);
		} else {
			$mail->AltBody = strip_tags($mail->Body);
		}

		// Define os anexos (opcional)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

		// Envia o e-mail
		/*if($mail->Send()) {
			$enviado = true;
		} else {
			$enviado = false;
			var_dump('Mailer Error: ' . $mail->ErrorInfo);
			die;
		}*/
		$enviado = true;
		$mail->Send();

		// Limpa os destinatários e os anexos
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();
		
		return $enviado;
	}
}
?>