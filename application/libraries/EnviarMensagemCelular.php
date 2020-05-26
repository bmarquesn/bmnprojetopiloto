<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Librarie para Envio de Push Notifications para Celulares
 * <pre>12/02/2016</pre>
 * Classe para encio de Push Notifications para Celulares cadastrados no site
 * 
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @name EnviarMensagemCelular
 * @license BrunoMarquesNogueira
 * @package EnviarMensagemCelular
 * @date 12/02/2016
 */
class EnviarMensagemCelular {
	public function enviar($mensagem, $destinatarios, $dispositivo, $SERVIDOR) {
		$errors = array();
		$retornos = array();
		if(!empty($destinatarios)) {
			if($dispositivo == 'android') {
				$url = 'https://android.googleapis.com/gcm/send';
				foreach($destinatarios as $key => $value) {
					$fields = array(
						'registration_ids' => array(''.$value['token'].''),
						'data' => array("message" => $mensagem)
					);
					$headers = array(
						'Authorization: key=AIzaSyAFj21dapyzsbxOIayf4mgutao3WRaJll0',
						'Content-Type: application/json'
					);
					// Open connection
					$ch = curl_init();
					// Set the url, number of POST vars, POST data
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
					$errors[] = curl_error($ch);
					// Execute post
					$result = curl_exec($ch);
					// Close connection
					curl_close($ch);
					$retornos[] = json_decode($result);
				}
				return $retornos;
			} elseif($dispositivo == 'iphone') {
				$retorno = false;
				foreach($destinatarios as $key => $value) {
					if(isset($value['token']) && !empty($value['token'])) {
						// Put your device token here (without spaces):
						$deviceToken = trim($value['token']);
						// Put your private key's passphrase here:
						$passphrase = 'Crosshost';
						// Put your alert message here:
						$message = $mensagem;
						if($SERVIDOR == 'local') {
							/** desenvolvimento */
							//$address = 'ssl://gateway.sandbox.push.apple.com:2195';
							//$arquivoPEM = 'assets/ck/ck_ios_ferrarezi_dev.pem';
							/** producao */
							$address = 'ssl://gateway.push.apple.com:2195';
							$arquivoPEM = 'assets/ck/ck_ios_ferrarezi_prod.pem';
						} else {
							/** desenvolvimento */
							//$address = 'ssl://gateway.sandbox.push.apple.com:2195';
							//$arquivoPEM = 'assets/ck/ck_ios_ferrarezi_dev.pem';
							/** producao */
							$address = 'ssl://gateway.push.apple.com:2195';
							$arquivoPEM = 'assets/ck/ck_ios_ferrarezi_prod.pem';
						}
						////////////////////////////////////////////////////////////////////////////////
						// Open a connection to the APNS server
						$ctx = stream_context_create();
						stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
						stream_context_set_option($ctx, 'ssl', 'local_cert', $arquivoPEM);
						$fp = stream_socket_client($address, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
						if(!$fp) {
							$naoenviados++;
							//exit("Failed to connect: $err $errstr" . PHP_EOL);
						}
						// Create the payload body
						$body['aps'] = array(
							'alert' => $message,
							'banner' => $message,
							//'badge' => 1,
							'sound' => 'default'
						);
						// Encode the payload as JSON
						$payload = json_encode($body);
						// Build the binary notification
						$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
						// Send it to the server
						$result = fwrite($fp, $msg, strlen($msg));
						// Close the connection to the server
						@socket_close($fp);
						@fclose($fp);
						if(!$result) {
							$retorno = false;
						} else {
							$retorno = true;
						}
					}
				}
				return $retorno;
				exit;
			}
		} else {
			$errors[] = 'Nao ha destinatarios';
		}
	}
}
?>