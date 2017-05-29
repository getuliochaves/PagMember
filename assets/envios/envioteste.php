<h3>Testando Método de Envio</h3>
<?php
global $wpdb;
$diretorioPadrao = ABSPATH.'wp-content/plugins/PagMember/assets/envios/';
require $diretorioPadrao.'vendor/autoload.php';
require $diretorioPadrao.'Mailjet/Client.php';
require $diretorioPadrao.'Mailjet/Config.php';
require $diretorioPadrao.'Mailjet/Resources.php';
require $diretorioPadrao.'Mailjet/Request.php';
require $diretorioPadrao.'Mailjet/Response.php';

use \Mailjet\Resources;
use \Mailjet\Client;

$meta_id = $_GET['meta_id'];
$pegaMetodo = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");
$dadosMetodo = unserialize($pegaMetodo);
$tipoMetodo = $dadosMetodo['tipoMetodo'];
$idMetodo = $dadosMetodo['idMetodo'];

$pegaEnvio = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$idMetodo'");
$pegaDadosMetodo = unserialize($pegaEnvio);

$pegaDadosGeral = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosGeralPagMember'");
$emailCliente = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosToken'");
if(count($pegaDadosGeral) == 0){
	echo '<div class="alert alert-success">Você deve definir um email de testes, antes de testar este método, no menu configurações.</div>';
	}
	
if(count($pegaDadosGeral) > 0){	
$listaDadosGeral = unserialize($pegaDadosGeral);	
$emailCliente = $listaDadosGeral['EmailTestes'];
	
//Verifica se o email de testes existe
if($emailCliente == ''){
	echo '<div class="alert alert-success">Você deve definir um email de testes, antes de testar este método, no menu configurações.</div>';
}else{

//Define a senha aleatória	
$tipoSenha = $pegaDadosMetodo['tipoSenha'];
if($tipoSenha == 'senhaAleatoria'){
	$senhaUsu = 'senha_aleatoria_criada_pelo_sistema';
}else{
	$senhaUsu = $pegaDadosMetodo['senhaUsu'];
}

	
if($tipoMetodo == 'SemAutenticacao'){			
//Lizta Dados Remetente
$remetenteEnvio = $pegaDadosMetodo['remetenteEnvio'];
$emailEnvio = $pegaDadosMetodo['emailEnvio'];
$assuntoEnvio = $pegaDadosMetodo['assuntoEnvio'];
$loginUsu = $pegaDadosMetodo['loginUsu'];
$msgInicial = $pegaDadosMetodo['msgInicial'];
$msgFinal = $pegaDadosMetodo['msgFinal'];


//Monta Mensagem para metodo para SemAutenticacao
$monta_mensagem = $msgInicial.' João <br/>
<br/>
Usuario: '.$emailCliente.'<br/>
Senha: '.$senhaUsu.'<br/>
Pagina de Login: '.$loginUsu.'<br/>
<br/>
'.$msgFinal;

//Envia Mensagem
$emaildestinatario = $emailCliente;
$assunto = $assuntoEnvio;
$mensagemHTML = ''.$monta_mensagem.'';
$emailsender = $emailEnvio;			
$quebra_linha = '<br/>';
$headers = array('Content-Type: text/html; charset=UTF-8','From: '.$remetenteEnvio.' <'.$emailsender.'>');		 
$resultado = wp_mail($emaildestinatario, $assunto, $mensagemHTML, $headers );
if($resultado == true){
	echo '<div class="alert alert-success">Mensagem Enviada com Sucesso para o seguinte email: '.$emailCliente.'</div>';
	}else{
echo '<div class="alert alert-danger">Erro ao enviar mensagem. Isso pode ocorrer por algumas razões: <br>
1 - Metodo de Envio não configurado Corretamente.<br>
2 - Dados Incorretos no método de Envio<br>
3 - Ip da sua hospedagem bloqueada para enviar emails.(Envie um email para sua hospedagem perguntando para informações)<br>
4 - Email de Destinatário incorreto ou não existe.<br>
<br>
OBS: Recomendamos fortemente não usar este método se não tiver um provedor de smtp configurado. Para mais informações veja a aula sobre "Configurar smtp gratuito na sua hospedagem", disponível nos tutoriais pagmember.
</div>';		
}
		

//}
}//Finaliza Sem Autenticacao


//inicia Metodo AutoResponder
		if($tipoMetodo == 'AutoResponder'){
			
			//Pega Dados do Usuario			
			$actionForm0 = $pegaDadosMetodo['actionForm'];
			$campoEmail = $pegaDadosMetodo['campoEmail'];
			
			$actionForm1 = explode('//', $actionForm0);
			$actionForm = 'https://'.$actionForm1[1];
			
			$chaves = array();
			$valores = array();
			foreach($pegaDadosMetodo as $key => $valor){	
			array_push($chaves, $key);	
			
			if($key == 'EMAIL' or $key == 'email' or $key == 'Email' or $key == $campoEmail){	
				array_push($valores, $emailCliente);		
				}else{
			array_push($valores, $valor);		
					}	
			}	
			$dataEnvioCURL = array_combine($chaves, $valores);
			
						
			$chw = curl_init();
			curl_setopt($chw, CURLOPT_URL, $actionForm);
			curl_setopt($chw, CURLOPT_POST, true);
			curl_setopt($chw, CURLOPT_HEADER, 0);
			curl_setopt($chw, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($chw, CURLOPT_NOBODY, FALSE);
			curl_setopt($chw, CURLOPT_POSTFIELDS, $dataEnvioCURL);
			curl_setopt($chw, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($chw, CURLOPT_MAXREDIRS, 1);
			curl_setopt($chw, CURLOPT_SSL_VERIFYPEER, false);
			curl_exec($chw);
			//$response = curl_exec($chw);			
			curl_close($chw);
			
			echo '<div class="alert alert-success">Mensagem Enviada com Sucesso para o seguinte email: '.$emailCliente.'</div>';
			
		}//Finaliza Metodo Autoresponder
	
		
		//inicia Metodo ServidorSMTP
		if($tipoMetodo == 'ServidorSMTP'){
			
		//Chama a classe PHPMailer/class.phpmailer.php	
		include_once($diretorioPadrao.'PHPMailer/class.phpmailer.php');
		
			//Pega Dados do Servidor
			$emailServ = $pegaDadosMetodo['emailServ'];
			$senhaServ = $pegaDadosMetodo['senhaServ'];
			$portaServ = $pegaDadosMetodo['portaServ'];
			$smtpServ = $pegaDadosMetodo['smtpServ'];
			
			//Pega Dados do Envio para o Cliente	
			$remetenteUsu = $pegaDadosMetodo['remetenteUsu'];
			$assuntoUsu = $pegaDadosMetodo['assuntoUsu'];			
			
			$loginUsu = $pegaDadosMetodo['loginUsu'];
			$msgInicial = $pegaDadosMetodo['msgInicial'];
			$msgFinal = $pegaDadosMetodo['msgFinal'];
			
					
			//Monta Mensagem para metodo ServidorSMTP
			$monta_mensagem = $msgInicial.'<br><br>
			Usuario: '.$emailCliente.'<br>
			Senha: '.$senhaUsu.'<br>
			Pagina de Login: '.$loginUsu.'<br><br>
			'.$msgFinal;
			
			
			//Definicoes PHP Mailer	
			//date_default_timezone_set('America/Sao_Paulo');
			$mail = new PHPMailer();
			$mail->SetLanguage('br');		
				
			$mail->IsSMTP();
			$mail->IsHTML(true);
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Port = $portaServ;
			$mail->Host = $smtpServ;
			$mail->Username = $emailServ;
			$mail->Password = $senhaServ;
			
			$mail->SetFrom($emailServ,$remetenteUsu);
			$mail->AddReplyTo($emailCliente, $remetenteUsu);
			$mail->AddAddress($emailCliente, $remetenteUsu);
			$mail->Subject = $assuntoUsu;
			$mail->MsgHTML(''.$monta_mensagem.'');
			
			$resultado = ($mail->Send());
			
			if($resultado == true){
	echo '<div class="alert alert-success">Mensagem Enviada com Sucesso para o seguinte email: '.$emailCliente.'</div>';
	}else{
echo '<div class="alert alert-danger">Erro ao enviar mensagem. Isso pode ocorrer por algumas razões: <br>
1 - Metodo de Envio não configurado Corretamente.<br>
2 - Dados Incorretos no método de Envio<br>
3 - Ip da sua hospedagem bloqueada para enviar emails.(Envie um email para sua hospedagem perguntando para informações)<br>
4 - Email de Destinatário incorreto ou não existe.<br>

</div>';		
}
			
			
			
		}//Finaliza Envio por ServidorSMTP
		
		//Inicia Metodo MailJet
		if($tipoMetodo == 'MailJet'){
			
			
			
			
			
			
			//Pega API KEY
			$apikeymailjet = $pegaDadosMetodo['apikeymailjet'];
			$secretkeymailjet = $pegaDadosMetodo['secretkeymailjet'];
			
			//Lista Dados Remetente
			$remetenteEnvio = $pegaDadosMetodo['remetenteEnvio'];
			$emailEnvio = $pegaDadosMetodo['emailEnvio'];
			$assuntoEnvio = $pegaDadosMetodo['assuntoEnvio'];
			$loginUsu = $pegaDadosMetodo['loginUsu'];
			$msgInicial = $pegaDadosMetodo['msgInicial'];
			$msgFinal = $pegaDadosMetodo['msgFinal'];
			
			//Monta Mensagem para metodo para SemAutenticacao
			$monta_mensagem = $msgInicial.'<br><br>
			
			Usuario: '.$emailCliente.'<br>
			Senha: '.$senhaUsu.'<br>
			Pagina de Login: '.$loginUsu.'<br><br>
			
			'.$msgFinal;		
			
	
			
			$mj = new \Mailjet\Client($apikeymailjet, $secretkeymailjet);		
			
			//var_dump($mj);
			
		
			
			//Remove HTML do texto
			//$textoSimples = strip_tags($monta_mensagem);	
			
			// Resources are all located in the Resources class
			$response = $mj->get(Resources::$Contact);		
			
			if ($response->success()){
			  $resposta0 = $response->getData();
			}else{
			  $resposta0 = $response->getStatus();			  
			  }
			  
			  $resposta = serialize($resposta0);
			  
		
			
	  
			 $body = [
				'FromEmail' => $emailEnvio,
				'FromName' => $remetenteEnvio,
				'Subject' => $assuntoEnvio,
				'Text-part' => $monta_mensagem,
				'Html-part' => $monta_mensagem,
				'Recipients' => [['Email' => $emailCliente]]
			];
			
			$response = $mj->post(Resources::$Email, ['body' => $body]); 
			
			
			
			
			if($response == true){
	echo '<div class="alert alert-success">Mensagem Enviada com Sucesso para o seguinte email: '.$emailCliente.'</div>';
	}else{
echo '<div class="alert alert-danger">Erro ao enviar mensagem. Isso pode ocorrer por algumas razões: <br>
1 - Metodo de Envio não configurado Corretamente.<br>
2 - Dados Incorretos no método de Envio, verique na sua conta Mailjet<br>
3 - Conta mailjet não validada ou suspensa.<br>
4 - Sua hospedagem bloqueada para enviar mensagem via smtp.<br>
5 - Email de Destinatário incorreto ou não existe(Defina um email nas configurações).<br>

</div>';		
}
			
	//		/
			
						
			
		}//Finaliza Envio MailJet

	

	};////FIM Verifica se o email de testes existe
	
	//Fim IF conta Geral > 0
	};

?>