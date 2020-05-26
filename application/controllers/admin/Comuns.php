<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Comuns
 * <pre>15/04/2016</pre>
 * <b>Funções comuns para o sistema</b>
 * 
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @name Comuns
 * @license BrunoMarquesNogueira
 * @package Comuns
 * @subpackage PhpQuery
 * @date 15/04/2016
 *
 * ---
 *
 * Comuns Atualização
 * <pre>15/02/2018</pre>
 * <b>Explicação do porque a Classe Comuns precisará sempre ser instanciada: Está dentro do PHP Query a integração com o Codeigniter</b>
 *
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @date 15/02/2018
 */

session_start();
date_default_timezone_set("America/Sao_Paulo");
/** biblioteca para ser usada pelo busca cep */
include APPPATH.'third_party/PhpQuery.php';

/** Está dentro de PhpQuery a integração com o Codeigneiter */
class Comuns extends PhpQuery {
	/*funcoes, metodos comuns para o sistema*/
	protected $hash_senha = "_3ncr1pt*p455w0rd_";

	public function hash_senha() {
		return $this->hash_senha;
	}

	public function formatar_data_banco_dados($data, $hora = false) {
		if($hora) {
			$dataFormatada = substr($data, 6, 4)."-".substr($data, 3, 2)."-".substr($data, 0, 2)." ".substr($data, 11, 5);
		} else {
			$dataFormatada = substr($data, 6, 4)."-".substr($data, 3, 2)."-".substr($data, 0, 2);
		}
		return $dataFormatada;
	}
	
	public function anti_sql_injection($sql, $array=false) {
		if($array){
			foreach($sql as $k => $c) {
				$c = preg_replace("/(from|select|insert|delete|truncate|where|drop table|show tables|#|\*|--|\\\\)/", "", $c);
				$c = trim($c);
				$c = strip_tags($c);
				$c = get_magic_quotes_gpc()==0?addslashes($c):$c;
				$sql[$k] = $c;
			}
			return $sql;
		}else{
			$sql = preg_replace("/(from|select|insert|delete|truncate|where|drop table|show tables|#|\*|--|\\\\)/", "", $sql);
			$sql = trim($sql);
			$sql = strip_tags($sql);
			$sql = get_magic_quotes_gpc()==0?addslashes($sql):$sql;
			return $sql;
		}
	}
	
	public function check_session_admin() {
		if(!isset($_SESSION['admin']) || empty($_SESSION['admin']) || $_SESSION['admin'] != '1') {
			return false;
		} else {
			return true;
		}
	}
	
	public function remover_acentuacao($string) {
		$tr = strtr($string, array (
			'À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A',
			'Æ'=>'A','Ç'=>'C','È'=>'E','É'=>'E','Ê'=>'E','Ë'=>'E',
			'Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I','Ð'=>'D','Ñ'=>'N',
			'Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O','Ø'=>'O',
			'Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U','Ý'=>'Y','Ŕ'=>'R',
			'Þ'=>'s','ß'=>'B','à'=>'a','á'=>'a','â'=>'a','ã'=>'a',
			'ä'=>'a','å'=>'a','æ'=>'a','ç'=>'c','è'=>'e','é'=>'e',
			'ê'=>'e','ë'=>'e','ì'=>'i','í'=>'i','î'=>'i','ï'=>'i',
			'ð'=>'o','ñ'=>'n','ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o',
			'ö'=>'o','ø'=>'o','ù'=>'u','ú'=>'u','û'=>'u','ý'=>'y',
			'þ'=>'b','ÿ'=>'y','ŕ'=>'r',' '=>'-','Ü'=>'U','ü'=>'u',
			'['=>'',']'=>'','['=>'','>'=>'','<'=>'','}'=>'','{'=>'',
			')'=>'','('=>'',':'=>'',';'=>'',','=>'','!'=>'','?'=>'',
			'*'=>'','%'=>'','~'=>'','^'=>'','`'=>'','&'=>'','#'=>'','@'=>'','_'=>'-',"'"=>''
		));
		
		return $tr;
	}
	
	public function envioMensagem($fromEmail, $fromNome, $nomeDestinatario, $emailDestinatario, $assunto, $Body) {
		$this->load->library("EnviarEmail");
		$EnviarEmail = new EnviarEmail;
		
		if($EnviarEmail->enviar_email($fromEmail, $fromNome, $nomeDestinatario, $emailDestinatario, $assunto, $Body)) {
			return true;
		} else {
			return false;
		}
	}
	
	function validaEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function enviarMensagemCelular($mensagem, $destinatarios, $device, $SERVIDOR) {
		$this->load->library("EnviarMensagemCelular");
		$EnviarMensagemCelular = new EnviarMensagemCelular;
		//var_dump($mensagem, $destinatarios, $device, $SERVIDOR);die;
		$result = $EnviarMensagemCelular->enviar($mensagem, $destinatarios, $device, $SERVIDOR);
		
		return $result;
	}
	
	public function exportarPDF($nomeArquivo = null, $htmlDados, $dadosRodape = null) {
		$this->load->library("ExportarPDF");
		$ExportarPDF = new ExportarPDF;
		
		if($ExportarPDF->pdfExportar($nomeArquivo, $htmlDados, $dadosRodape)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function upload_arquivo($name_input_FILE, $pasta_destino, $tipo_arquivo, $arquivo, $renomeia = true, $tamanho_maximo, $verificar_dimensoes = false) {
		/** Pasta onde o arquivo vai ser salvo */
		$_UP['pasta'] = 'assets/'.$pasta_destino.'/';
		/** Array com as extensões permitidas */
		if($tipo_arquivo == 'img') {
			$_UP['extensoes'] = array('jpg', 'png', 'jpeg');
		}
		
		/** pegar extensao arquivo */
		$extensao_arquivo = explode('.', $arquivo[$name_input_FILE]['name']);
		$extensao = strtolower(end($extensao_arquivo));
		
		/** Faz a verificação da extensão do arquivo */
		if (array_search($extensao, $_UP['extensoes']) === false) {
			return false;
		} else {
			/** verifica o tamanho do arquivo e se está no limite estipulado */
			if ($tamanho_maximo < $arquivo[$name_input_FILE]['size']) {
				return false;
			} else {
				/** por default os arquivos, as imagens, serão renomeados/das */
				if($renomeia) {
					$nome_final = md5(time().'_'.$arquivo[$name_input_FILE]['name']).'.'.$extensao;
				} else {
					$nome_final = time().'_'.$arquivo[$name_input_FILE]['name'].'.'.$extensao;
				}
				
				/** verifico se existe a pasta destino para se nao cria-la */
				if(!file_exists('assets/'.$pasta_destino)) {
					mkdir('assets/'.$pasta_destino, 0777, true);
				}
				
				/** Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro */
				if ($arquivo[$name_input_FILE]['error'] != 0) {
					/** Array com os tipos de erros de upload do PHP */
					$_UP['erros'][0] = 'Não houve erro';
					$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
					$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
					$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
					$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
					die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$arquivo[$name_input_FILE]['error']]);
					exit;
				} else {					  
					/** move o arquivo para a pasta escolhida */
					if (move_uploaded_file($arquivo[$name_input_FILE]['tmp_name'], $_UP['pasta'] . $nome_final)) {
						if($verificar_dimensoes) {
							/** verifico as dimensoes da imagem - conforme acordado (05/02/15) com o Jailton será feita a verificação e tendo entre 800px e 1000px de largura será válido */
							$dimensoes = getimagesize("assets/".$pasta_destino."/".$nome_final);
							if(isset($dimensoes[3]) && !empty($dimensoes[3])) {
								$width = explode('width="', $dimensoes[3]);
								$width = explode('"', $width[1]);
								$width = (int)$width[0];
								$height = explode('height="', $dimensoes[3]);
								$height = explode('"', $height[1]);
								$height = (int)$height[0];
								/** conforme acordado com o Galamba (11/02/15) se a imagem for menor que 500px e maior que 1000px de largura a mesma será redimensionada para 500px e largura */
								if($width >= 500 && $width <= 1000) {
									return $nome_final;
								} else {
									$this->load->library("WideImage");
									$WideImage = new WideImage;
									if($WideImage->resize("assets/".$pasta_destino, $nome_final)) {
										return $nome_final;
									} else {
										return false;
									}
								}
							} else {
								return false;
							}
						} else {
							return $nome_final;
						}
					} else {
						return false;
					}
				}
			}
		}
	}
	
	public function traz_estados_brasileiros() {
		$estadosBrasileiros = array(
			'AC' => 'Acre',
			'AL' => 'Alagoas',
			'AM' => 'Amazonas',
			'AP' => 'Amapá',
			'BA' => 'Bahia',
			'CE' => 'Ceará',
			'DF' => 'Distrito Federal',
			'ES' => 'Espírito Santo',
			'GO' => 'Goiás',
			'MA' => 'Maranhão',
			'MG' => 'Minas Gerais',
			'MS' => 'Mato Grosso do Sul',
			'MT' => 'Mato Grosso',
			'PA' => 'Pará',
			'PB' => 'Paraíba',
			'PE' => 'Pernambuco',
			'PI' => 'Pauí',
			'PR' => 'Paraná',
			'RJ' => 'Rio de Janeiro',
			'RN' => 'Rio Grande do Norte',
			'RO' => 'Rondônia',
			'RR' => 'Roraima',
			'RS' => 'Rio Grande do Sul',
			'SC' => 'Santa Catarina',
			'SE' => 'Sergipe',
			'SP' => 'São Paulo',
			'TO' => 'Tocantins'
		);
		
		return $estadosBrasileiros;
	}
	
	public function nome_meses($num_mes = null) {
		$meses = array(
			1 => 'Janeiro',
			2 => 'Fevereiro',
			3 => 'Março',
			4 => 'Abril',
			5 => 'Maio',
			6 => 'Junho',
			7 => 'Julho',
			8 => 'Agosto',
			9 => 'Setembro',
			10 => 'Outubro',
			11 => 'Novembro',
			12 => 'Dezembro'
		);
		
		if(!empty($num_mes)) {
			return $meses[(int)$num_mes];
		} else {
			return $meses;
		}
	}
	
	public function diferenca_entre_datas($data1, $data2) {
		/** utiliza-se o formato Y-m-d H:i:s */
		$ano1 = date('Y', strtotime($data1));
		$mes1 = date('m', strtotime($data1));
		$dia1 = date('d', strtotime($data1));
		$hora1 = date('H', strtotime($data1));
		$minuto1 = date('i', strtotime($data1));
		$segundo1 = date('s', strtotime($data1));
		
		$ano2 = date('Y', strtotime($data2));
		$mes2 = date('m', strtotime($data2));
		$dia2 = date('d', strtotime($data2));
		$hora2 = date('H', strtotime($data2));
		$minuto2 = date('i', strtotime($data2));
		$segundo2 = date('s', strtotime($data2));
		
		$mktime1 = mktime($hora1, $minuto1, $segundo1, $mes1, $dia1, $ano1);
		$mktime2 = mktime($hora2, $minuto2, $segundo2, $mes2, $dia2, $ano2);
		
		$dias = floor(($mktime2-$mktime1)/86400);
		$meses = floor(($mktime2-$mktime1)/2592000);
		$anos = floor(($mktime2-$mktime1)/31536000);
		$horas = floor(($mktime2-$mktime1)/3600);
		$minutos = floor(($mktime2-$mktime1)/60);
		$segundos = floor(($mktime2-$mktime1)/1);
		
		$arrayDiferencaDatas = array('dias' => $dias, 'meses' => $meses, 'anos' => $anos, 'horas' => $horas, 'minutos' => $minutos, 'segundos' => $segundos);
		
		return $arrayDiferencaDatas;
	}
	
	public function download_arquivo($id_webinar, $nome_arquivo) {
		switch(strtolower(substr(strrchr(basename($nome_arquivo),"."),1))) {
			case "pdf": $tipo="application/pdf"; break;
			case "exe": $tipo="application/octet-stream"; break;
			case "zip": $tipo="application/zip"; break;
			case "doc": $tipo="application/msword"; break;
			case "docx": $tipo="application/vnd.openxmlformats-officedocument.wordprocessingml.document"; break;
			case "xls": $tipo="application/vnd.ms-excel"; break;
			case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
			case "pptx": $tipo="application/vnd.openxmlformats-officedocument.presentationml.presentation"; break;
			case "gif": $tipo="image/gif"; break;
			case "png": $tipo="image/png"; break;
			case "jpg": $tipo="image/jpg"; break;
			case "mp3": $tipo="audio/mpeg"; break;
			case "php": // deixar vazio por seurança
			case "htm": // deixar vazio por seurança
			case "html": // deixar vazio por seurança
		}
		if(isset($tipo) && !empty($tipo)) {
			header("Content-Type: ".$tipo);
			header("Content-Length: ".filesize('assets/docs/ppt/'.$id_webinar.'/'.$nome_arquivo));
			header("Content-Disposition: attachment; filename=".basename('assets/docs/ppt/'.$id_webinar.'/'.$nome_arquivo));
			readfile('assets/docs/ppt/'.$id_webinar.'/'.$nome_arquivo);
		}
		exit;
	}

	public function detectar_tipo_dispositivo() {
		$agent = $_SERVER["HTTP_USER_AGENT"];
		if(preg_match("/iPhone/", $agent) || preg_match("/iPad/", $agent)) {
			$dispositivo = 'IPhone';
			//header("Location: http://".$url_stream.":1935/".$ponto_stream."/".$name_stream_ptbr."/playlist.m3u8");
		} elseif((preg_match("/Android/", $agent))) {
			$dispositivo = 'Android';
		} else {
			$dispositivo = 'PC';
		}
		
		return $dispositivo;
	}

	function geradorSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		
		$retorno = '';
		$caracteres = '';
		$caracteres .= $lmin;
		
		if($maiusculas) {
			$caracteres .= $lmai;
		}
		
		if($numeros) {
			$caracteres .= $num;
		}
		
		if($simbolos) {
			$caracteres .= $simb;
		}
		
		$len = strlen($caracteres);
		
		for ($n = 1; $n <= $tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];
		}
		
		return $retorno;
	}
	
	function valida_email($email) {
		$valido = false;
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$valido = true;
		} else {
			$valido = false;
		}
		
		return $valido;
	}

	function deletar_pasta($dir_pasta) {
		$files = array_diff(scandir($dir_pasta), array('.','..')); 
		foreach ($files as $file) { 
			(is_dir("$dir_pasta/$file"))?$this->deletar_pasta("$dir_pasta/$file"):unlink("$dir_pasta/$file"); 
		}
		return rmdir($dir_pasta);
		echo $dir_pasta;die;
	}
	
	function simple_curl($url,$post=array(),$get=array()){
		$url = explode('?',$url,2);
		if(count($url)===2){
			$temp_get = array();
			parse_str($url[1],$temp_get);
			$get = array_merge($get,$temp_get);
		}

		$ch = curl_init($url[0]."?".http_build_query($get));
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return curl_exec ($ch);
	}
	
	function consulta_cep(){		
		if(isset($_POST['cep']) && !empty($_POST['cep'])) {
			$cep = $_POST['cep'];
		} elseif(isset($_GET['cep']) && !empty($_GET['cep'])) {
			$cep = $_GET['cep'];
		} else {
			$cep = 0;
		}
		
		if(!empty($cep)) {
			$html = $this->simple_curl('http://m.correios.com.br/movel/buscaCepConfirma.do',array(
				'cepEntrada'=>$cep,
				'tipoCep'=>'',
				'cepTemp'=>'',
				'metodo'=>'buscarCep'
			));

			phpQuery::newDocumentHTML($html, $charset = 'utf-8');

			$dados = 
			array(
				'logradouro'=> trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
				'bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
				'cidade/uf'=> trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
				'cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
			);

			$dados['cidade/uf'] = explode('/',$dados['cidade/uf']);
			$dados['cidade'] = trim($dados['cidade/uf'][0]);
			$dados['uf'] = isset($dados['cidade/uf'][1])?trim($dados['cidade/uf'][1]):'';
			unset($dados['cidade/uf']);

			echo json_encode($dados);
		} else {
			echo '0';
		}
		
		die;
	}
	
	public function retorna_paginacao($filtros, $paginador) {
		$paginador = str_replace('class="btn btn-info"', 'class="btn"', $paginador);
		$paginador = explode('<a href="', $paginador);
		foreach($paginador as $key => $value) {
			if($key > 0) {
				$links_paginador[$key] = explode('"><button class="btn', $value);
			}
		}
		if(isset($links_paginador) && !empty($links_paginador) && isset($filtros) && !empty($filtros)) {
			foreach($filtros as $key3 => $value3) {
				foreach($links_paginador as $key => $value) {
					foreach($value as $key2 => $value2) {
						if($key2 == 0) {
							$links_paginador[$key][$key2] = $value2.'&'.$key3.'='.$value3;
						}
					}
				}
			}
			foreach($links_paginador as $key => $value) {
				foreach($value as $key2 => $value2) {
					if($key2 == '1') {
						$links_paginador[$key][$key2] = explode('">', $value2);
					}
				}
			}
			foreach($links_paginador as $key => $value) {
				foreach($value as $key2 => $value2) {
					if($key2 == '0') {
						$links_paginador[$key][0] = '<a href="'.$value2.'"><button class="btn">';
					}
				}
			}
			foreach($links_paginador as $key => $value) {
				$links_paginador[$key][0] = $value[0].$value[1][1];
			}
			$string_paginador = '';
			foreach($paginador as $key => $value) {
				if($key > 0) {
					$string_paginador .= $links_paginador[$key][0];
				}
			}
			$string_paginador = $paginador[0].$string_paginador;
			return $string_paginador;
		}
	}
}
