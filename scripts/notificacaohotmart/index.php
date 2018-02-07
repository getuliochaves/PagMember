<?php
require 'vendor/autoload.php';
require 'Mailjet/Client.php';
require 'Mailjet/Config.php';
require 'Mailjet/Resources.php';
require 'Mailjet/Request.php';
require 'Mailjet/Response.php';

use \Mailjet\Resources;
use \Mailjet\Client;
if(isset($_GET['teste'])){
	echo '<link rel="stylesheet" href="../wp-content/plugins/PagMember/scripts/style.css">';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	echo '<h1>Notificação Criada e Funcionando Corretamente</h1>';

	if(file_exists('hotmart.txt') && isset($_GET['remove'])){
		unlink('hotmart.txt');
		echo '</br>Arquivo de Post Removido';
	};

	//Inicio dos testes
}else{
include_once('../wp-load.php');
global $wpdb;
$tipoToken = 'Hotmart';
$pegaDadosToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'dadosToken'");
$listaToken = unserialize($pegaDadosToken);
$dadosToken = $listaToken[$tipoToken];
$email = $dadosToken['email'];
$token = $dadosToken['token'];
$pgred = $dadosToken['pgred'];

$idMetaGravaPM = 999999999;
$idMetaGravaUsuario = 999999998;
$idMetaGravaTR = 999999997;

  $chaveApi = $_POST["hottok"];
if($chaveApi == ''){
	$chaveApi = $_POST['token'];
}

if($pgred == ''){
	$pgred = get_site_url();
}
//Conta Token Hotmart
if(count($_POST) > 0){
$wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$idMetaGravaPM'");
$wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$idMetaGravaUsuario'");
$dataHoje = date('d-m-Y');

$gravaEvento['Chegou o Post'] = 'Chegou';
$gravaEvento['Tipo de Post'] = $tipoToken;
$tipoPost = $_POST['testeLocal'];
$reenvioAcesso = $_POST['reenvioAcesso'];



//Verificacao se o token recebido é igual ao token do banco
if($chaveApi == $token){
date_default_timezone_set('America/Sao_Paulo');
$dataGravaPost = date("d-m-Y H:i:s");
$dadosPost = ''.PHP_EOL;
$dadosPost .= '==================== Gravado em: '.$dataGravaPost.'====================='.PHP_EOL;
$dadosPost .= serialize($_POST).PHP_EOL;


$arquivoT = fopen("hotmart.txt", "a");
// Escreve "exemplo de escrita" no bloco1.txt
$escreve = fwrite($arquivoT, $dadosPost);

// Fecha o arquivo
fclose($arquivoT);


//Inicio validacao Teste Local
if($tipoPost != 'testeLocal'){

		$idTransacao = $_POST['transaction'];
	  $nomeCli = $_POST['name'];
		$emailCli = $_POST['email'];
		$assinatura = $_POST['subscription_status'];
		$nomeProd = $_POST['prod_name'];
		$idProd = $_POST['prod'];
		$valorProd = $_POST['price'];
		$oferta = $_POST['off'];
		$nomeCliPS = $nomeCli;


		if($assinatura == '' or $assinatura == null){
			$statusTrasacao = $_POST['status'];
		}else{
			$statusTrasacao = $assinatura;
		}

		switch($statusTrasacao){

			/*
			# active => Ativo --------------------------------> Fica com acesso site
			#Inactive => Inativo -----------------------------> Perde o Acesso ao site
			# canceled => Cancelada pelo cliente -------------> Perde o Acesso ao site
			# started => Iniciada ----------------------------> Nao tem acesso ao site
			# past_due => Atraso -----------------------------> Perde o acesso ao site
			# expired => Vencido -----------------------------> Perde o Acesso ao site
			*/

			//Status Aguardando Pagamento
			case 'started': $statusCompra = 'Aguardando pagamento';
				$statusTrasacaoOk = 1;
			break;

			case 'inactive': $statusCompra = 'Aguardando pagamento';
				$statusTrasacaoOk = 1;
			break;

			case 'past_due': $statusCompra = 'Aguardando pagamento';
				$statusTrasacaoOk = 1;
			break;

			case 'expired': $statusCompra = 'Aguardando pagamento';
				$statusTrasacaoOk = 1;
			break;

			case 'pending_analysis': $statusCompra = 'Aguardando pagamento';
				$statusTrasacaoOk = 1;
			break;

			case 'billet_printed': $statusCompra = 'Aguardando pagamento';
				$statusTrasacaoOk = 1;
			break;

			//Status Cancelado

			case 'canceled': $statusCompra = 'Cancelado';
				$statusTrasacaoOk = 6;
			break;

			case 'refunded': $statusCompra = 'Cancelada';
				$statusTrasacaoOk = 6;
			break;

			case 'blocked': $statusCompra = 'Cancelada';
				$statusTrasacaoOk = 6;
			break;

			case 'chargeback': $statusCompra = 'Cancelada';
				$statusTrasacaoOk = 6;
			break;

			//Status que são ativos

			case 'active': $statusCompra = 'Aprovado';
				$statusTrasacaoOk = 3;
			break;

			case 'approved': $statusCompra = 'Aprovado';
				$statusTrasacaoOk = 3;
			break;

			




		};




};//FIM // validacao Teste Local


//Inicio validacao SE FOR Teste Local
if($tipoPost == 'testeLocal'){

	//var_dump($_POST);

	if($reenvioAcesso == 'sim'){
		echo '<h3>Dados de Acesso Reenviado Com sucesso!</h3>';
	}else{
	echo '<h3>Teste Realizado com Sucesso! Verifique o Relatorio para mais Detalhes.</h3>';
	}


	if(count($_POST) > 0){
	echo '<h4>DADOS do Enviados</h4><br/>';
		foreach($_POST as $chaveD => $dadosD){
			echo $chaveD.' => '.$dadosD.'<br/>';
		};
	echo '<br/>';
	};

	$gravaEvento['Tipo de Post'] = 'Teste Local';

	$nomeProd0 = $_POST['nomeProd'];
	$nomeProd1 = explode('#',$nomeProd0);
	$nomeProd = $nomeProd1[0];

	$idProd = $_POST['idProd'];
	$valorProd = $_POST['valorProd'];
	$idTransacao = $_POST['idTransacao'];

	$nomeCli = $_POST['nomeCli'];
	$emailCli = $_POST['emailCli'];
	$nomeCliPS = $nomeCli;

	$statusTrasacao = $_POST['statusTrasacao'];

	//Inicio Switch status transacao
	switch($statusTrasacao){
	case '1': $statusCompra = 'Aguardando pagamento';
		$statusTrasacaoOk = 1;
	break;

	case '3':	$statusCompra = 'Aprovado';
			$statusTrasacaoOk = 3;
	break;

	case '6':	$statusCompra = 'Cancelada';
					$statusTrasacaoOk = 6;
		break;

		default:
				$statusCompra = 'Aguardando pagamento';
				$statusTrasacaoOk = 1;
			break;
	}//FIM Switch status transacao

	$oferta = $_POST['nomeOff'];


};////Inicio validacao Teste Local

		$dadosCadUsuario['newUserConfirm'] = 'newUserConfirm';

		$dadosCadUsuario['tipoProd'] = $tipoToken;
		$dadosCadUsuario['valorProd'] = $valorProd;
		$dadosCadUsuario['statusTrasacao'] = $statusTrasacaoOk;
		$dadosCadUsuario['statusCompra'] = $statusCompra;
		$dadosCadUsuario['nomeProd'] = $nomeProd.'#'.$oferta;
		$dadosCadUsuario['idProd'] = $idProd;
		$dadosCadUsuario['idTransacao'] = $idTransacao;
		$dadosCadUsuario['emailCli'] = $emailCli;
		$dadosCadUsuario['nomeCli'] = $nomeCli;

		$transacaoUsuario['DataTransacao'] = base64_encode($dataHoje);
		$transacaoUsuario['NomeCliente'] = base64_encode($nomeCli);
		$transacaoUsuario['EmailCliente'] = base64_encode($emailCli);
		$transacaoUsuario['IdTransacao'] = base64_encode($idTransacao);
		$transacaoUsuario['StatusCompra'] = base64_encode($statusCompra);
		$transacaoUsuario['NomeProduto'] = base64_encode($nomeProd.'#'.$oferta);
		$transacaoUsuario['ValorProduto'] = base64_encode($valorProd);
		$transacaoUsuario['TipoPagamento'] = base64_encode($tipoToken);


		$idTransacaoDB = 'TransacoesPagMember-'.$idTransacao;
		$pegaTrDB = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '$idTransacaoDB'");
		$conta_RS = count($pegaTrDB);

		if($conta_RS > 0){
			$restauraTrDB = unserialize($pegaTrDB);
			$statusTrDB = base64_decode($restauraTrDB['StatusCompra']);
			$trDBExiste = 'sim';

			if($statusTrDB != $statusCompra){//Aprovado != Cancelado
				$trDiferente = 'sim';
				$gravaEvento['Transacao'] = 'Transacao Atualizada';
			}else{
				$trDiferente = 'nao';
			};

		}else{
				$trDiferente = 'sim';
				$gravaEvento['Transacao'] = 'NOVA Transacao Inserida';
		}


		////////////////////////////////////////////////////////////////////////

		//Dados do Produto Banco de Dados
		//Pega dados do Banco de Dados
		//ProdPagMember#Assinatura Geracao Digital#ldjfir*idProd#99
		$idProdBanco = '#'.$oferta.'*idProd#'.$idProd;
		$nomeProdBanco = 'ProdPagMember#'.$nomeProd.'#'.$oferta;

		//Pega o Produto pelo ID
		$metaIDProd = $wpdb->get_var("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key like '%$idProdBanco%'");

		//Caso não ache pelo ID, tenta pelo nome
		if($metaIDProd == ''){
			$metaIDProd = $wpdb->get_var("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key like '%$nomeProdBanco%'");
		}

		//Caso não encontre, emite essa mensagem para o Admin
		if($metaIDProd == ''){
			$gravaEvento['Erro de Busca'] = 'Produto não encontrado no seu Site. Nome ou ID Incompativeis  com o '.$tipoToken.'.';
			$gravaEventoSer = serialize($gravaEvento);
			$wpdb->insert($wpdb->postmeta, array('post_id' => $idMetaGravaPM, 'meta_key' => 'Relatorio PagMember','meta_value' => $gravaEventoSer));
			exit;
		}

		//Pega os Dados do Produto
		$dadosProdBanco = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$metaIDProd'");
		$dadosProdBanco = unserialize($dadosProdBanco);
		//var_dump($dadosProdBanco);

		//Pega o Metodo de envio
		if($reenviaAcesso == 'sim'){
			$idMetodoEnvio = $_POST['idMetodoEnvio'];
			$idMetodoEnvioAguarda = $_POST['idMetodoEnvio'];
		}else{
			$idMetodoEnvio = $dadosProdBanco['idMetodoEnvio'];
			$idMetodoEnvioAguarda = $dadosProdBanco['idMetodoEnvioAguarda'];
		}

		$transacaoUsuario['idMetodoEnvio'] = base64_encode($idMetodoEnvio);

		//Pega os Pacotes do Produto
		$packProd = $dadosProdBanco['packProd'];
		$packProd = unserialize($packProd);

		//Verifica se existe pacotes

		if($packProd[0] !== ""){
		$pacoteProd = array();
			foreach($packProd as $keyPacote => $nomePacote){
				array_push($pacoteProd,'access_optimizemember_ccap_'.$nomePacote);
			}

		}else{
		$pacoteProd[''] = true;
		}//Fim Verifica se existe pacotes

		//Dados Produto do Banco
		$userGratis = $dadosProdBanco['userGratis'];
		$nomeProd = $dadosProdBanco['nomeProd'];
		$idProd = $dadosProdBanco['idProd'];
		$valorProd = $dadosProdBanco['valorProd'];
		$descOff = $dadosProdBanco['descOff'];
		$nivelProd = $dadosProdBanco['nivelProd'];
		$nivelProdAguarda = $dadosProdBanco['nivelProdAguarda'];
		$posCompra = $dadosProdBanco['posCompra'];
		$redProd = $dadosProdBanco['redProd'];
		$siteProd = $dadosProdBanco['siteProd'];
		$clienteNoSite = $dadosProdBanco['clienteNoSite'];
		$eotCli = $dadosProdBanco['eotCli'];
		$clienteNoSite = $dadosProdBanco['clienteNoSite'];
		$eotProd = $dadosProdBanco['eotProd'];

		//Converte para minisculo
		$descOff = strtolower($descOff);

		$pacoteProd[$descOff] = true;

		$pacoteProd = serialize($pacoteProd);
		$pacoteProd = base64_encode($pacoteProd);

		if($redProd == ''){
			$redProd = $pgred;
		}

		$transacaoUsuario['URLRedireciona'] = base64_encode($redProd);

		//FIm Banco de dados
		////////////////////////////////////////////////////////////

		//$consultaEmail = base64_decode($emailCliE);

		//$emailCli = 'setordigital7@gmail.com';

		//Curl pra verificar se existe usuario ou não
		$testeCliPm = $siteProd.'testclipm.php';
		$dataMetaUser = 'email='.$emailCli.'&validacao=sim&tipoPagamento='.$tipoToken.'&tokenExterno='.$token;


		$curl99 = curl_init();
		curl_setopt($curl99, CURLOPT_URL, $testeCliPm);
		curl_setopt($curl99, CURLOPT_POST, true);
		curl_setopt($curl99, CURLOPT_HEADER, 0);
		curl_setopt($curl99, CURLOPT_NOBODY, FALSE);
		curl_setopt($curl99, CURLOPT_POSTFIELDS, $dataMetaUser);
		curl_setopt($curl99, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl99, CURLOPT_MAXREDIRS, 1);
		curl_setopt($curl99, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl99, CURLOPT_SSL_VERIFYPEER, false);
		$response88 = curl_exec($curl99);
		$existeUsuario = strpos($response88, 'Existeeeee');
		curl_close( $curl99 );

		if($existeUsuario != false){
			$usuarioExiste = 'Sim';
		}else{
			$usuarioExiste = 'Não';
		}

		$gravaEvento['Usuário Existe']= $usuarioExiste;
		//FIM Curl pra verificar se existe usuario ou não


		//DADOS DE ENVIO
		///////////////////////////////////////////////////////////////

		//Retorna o ID do Método de Envio
		$metaIDDadosEnvio = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$idMetodoEnvio'");
		$metaIDDadosEnvio = unserialize($metaIDDadosEnvio);
		$metaIDEnvio = $metaIDDadosEnvio['idMetodo'];
		$tipoMetodo = $metaIDDadosEnvio['tipoMetodo'];
		//var_dump($metaIDDadosEnvio);

		if($tipoMetodo == 'SemAutenticacao'){
			$enviodeDados = 'Envio pelo Wordpress';
		}else{
			$enviodeDados = $tipoMetodo;
		}

		$gravaEvento['Tipo de Envio de Acesso']= $enviodeDados;


		//Retorna Dados do Envio
		$dadosEnvio = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$metaIDEnvio'");
		$dadosEnvio = unserialize($dadosEnvio);
		//var_dump($dadosEnvio);

		//Cria uma Senha Aleatória para o Cliente
		$tipoSenha = $dadosEnvio['tipoSenha'];

		if($reenvioAcesso == 'sim'){
			$senhaUsu = $_POST['senhaUsu'];
		}else{
			if($tipoSenha == 'senhaAleatoria'){
				$caracteres = "#@aAbBcCdDeEfFgGhHiIjJlLmMnNoOpPqQrRsStTuUvVxXzZ";
				$tempo = $caracteres.time();
				$senhaUsu = substr(md5($tempo),0,10);
			}else{
				$senhaUsu = $dadosEnvio['senhaUsu'];
			}

		}

	$transacaoUsuario['senhaUsu'] = base64_encode($senhaUsu);

		if($tipoMetodo == 'SemAutenticacao'){
			//Retorna dados de Envio
			$assuntoEnvio = $dadosEnvio['assuntoEnvio'];
			$remetenteEnvio = $dadosEnvio['remetenteEnvio'];
			$emailEnvio = $dadosEnvio['emailEnvio'];
		};

		if($tipoMetodo == 'ServidorSMTP'){
			//Dados SMTP ENVIO
			$emailServ = $dadosEnvio['emailServ'];	//email login Servidor
			$senhaServ = $dadosEnvio['senhaServ'];	//senha Servidor
			$portaServ = $dadosEnvio['portaServ'];	//Porta Servidor
			$smtpServ = $dadosEnvio['smtpServ'];	//smtp do servidor
			//Dados do Remetente
			$remetenteUsu = $dadosEnvio['remetenteUsu']; //Nome do Remetente
			$assuntoUsu = $dadosEnvio['assuntoUsu'];	//Assunto Email de Envio
		};


		if($tipoMetodo == 'MailJet'){
			//Dados do Mailjet
			$apikeymailjet = $dadosEnvio['apikeymailjet'];	//email login Servidor
			$secretkeymailjet = $dadosEnvio['secretkeymailjet'];	//senha Servidor

			//Dados do Remetente
			$emailEnvio = $dadosEnvio['emailEnvio'];	//smtp do servidor
			$remetenteEnvio = $dadosEnvio['remetenteEnvio']; //Nome do Remetente
			$assuntoEnvio = $dadosEnvio['assuntoEnvio'];	//Assunto Email de Envio
		};


		//Pagina de Login do usuário
		$loginUsu = $dadosEnvio['loginUsu'];	//Pagina de Login

		//Retorna Mensagem
		$msgInicial = $dadosEnvio['msgInicial'];
		$atualizacaoAcesso = $dadosEnvio['atualizacaoAcesso'];
		$cancelamentoAcesso = $dadosEnvio['cancelamentoAcesso'];
		$msgFinal = $dadosEnvio['msgFinal'];
		$codificado = $dadosEnvio['codificado'];

		if($codificado == 'sim'){
				$msgInicial = base64_decode($msgInicial);
				$atualizacaoAcesso = base64_decode($atualizacaoAcesso);
				$cancelamentoAcesso = base64_decode($cancelamentoAcesso);
				$msgFinal = base64_decode($msgFinal);
		};

		$msgInicial = str_replace('*nomeCliente*', $nomeCliPS, $msgInicial);
		$atualizacaoAcesso = str_replace('*nomeCliente*', $nomeCliPS, $atualizacaoAcesso);
		$cancelamentoAcesso = str_replace('*nomeCliente*', $nomeCliPS, $cancelamentoAcesso);

		//Caso o campo de atualizacaoAcesso, esteja vazio, monte essa mensagem
		if($atualizacaoAcesso == ''){
			$atualizacaoAcesso = 'Obrigado por adquirir, mais um de nossos produtos. Segue o Produto que você solicitou:';
		}

		//Caso o campo de cancelamentoAcesso, esteja vazio, monte essa mensagem
		if($cancelamentoAcesso == ''){
			$cancelamentoAcesso = 'Lamentamos que você decidiu cancelar o acesso, ao nosso Produto/Serviço.<br>Gostariamos que informasse o motivo, ou sugestão, para podermos fazer as melhorias necessárias, para atendê-lo futuramente.';
		}

		//FIM DADOS DE ENVIO
		//////////////////////////////////////////////////////////////




		$dadosCadUsuario['pacoteProd'] = $pacoteProd;
		$dadosCadUsuario['token'] = $token;
		$dadosCadUsuario['senhaUsu'] = $senhaUsu;
		$dadosCadUsuario['userGratis'] = $userGratis;
		$dadosCadUsuario['nivelProd'] = $nivelProd;
		$dadosCadUsuario['nivelProdAguarda'] = $nivelProdAguarda;
		$dadosCadUsuario['clienteNoSite'] = $clienteNoSite;
		$dadosCadUsuario['eotCli'] = $eotCli;
		$dadosCadUsuario['eotProd'] = $eotProd;


		//VERIFICA STATUS DA TRANSACAO
		$gravaEvento['Status Processador'] = $statusTrasacao;
		$enviaDados = 'nao';
		
		if($statusTrasacaoOk < 3 && $userGratis == 'Permitir') { //Envia dados quando arguardar pagamento e usuário grátis for permitir
			$enviaDados = 'sim';
			$gravaEvento['Status Transacao'] = 'Transacao Aguardando Pagamento e Usuario Gratis';			
		}

		if($statusTrasacaoOk == 3 && $existeUsuario == false){ //Envia dados quando for aprovado
			$enviaDados = 'sim';
			$gravaEvento['Status Transacao'] = 'Transacao Aprovada';			
		}

		if($statusTrasacaoOk > 3 && $existeUsuario != false){ //Envia dados quando for cancelado
			$enviaDados = 'nao';
			$gravaEvento['Status Transacao'] = 'Transacao Cancelada';			
		}
		
		

		//FIM VERIFICA STATUS DA TRANSACAO

		//Incio Envia dados SIM
		if($enviaDados == 'sim'){
			//Monta as Mensagens de Envio
			/////////////////////////////////////////////////////////////////
			if($trDiferente == 'sim' or $reenvioAcesso == 'sim'){
			//Caso a transacao esteja aguardando pagamento ou paga
			if($statusTrasacaoOk == 1 or $statusTrasacaoOk == 2 or $statusTrasacaoOk == 3){

			//Caso o Pagamento esteja aguardando ou em análise, mostra esta mensagem
			if($statusTrasacaoOk == 1 or $statusTrasacaoOk == 2){
				$msgAguardaPagmento = '(OBS: Assim que o seu pagamento for aprovado, terá acesso total ao conteúdo adquirido)';
				$dadosAcessoLimitado = 'Limitado';
			}
			//Inicio Monta Mensagem de Envio, se o usuário já existe
			if($existeUsuario != false && $reenvioAcesso != 'sim'){
			$msgInicial = $atualizacaoAcesso;
			$Mensagem = $msgInicial.'<br/>
			<br/>
			<h3>Dados de Acesso '.$dadosAcessoLimitado.'</h3>
			<strong>Página de Login:</strong> '.$loginUsu.'<br/>
			<strong>Usuário:</strong> '.$emailCli.'<br/><br/>
			<strong>Produto Adquirido:</strong> '.$nomeProd.'<br/>
			<strong>Status da Compra:</strong> '.$statusCompra.'<br/>'.$msgAguardaPagmento.'
			<br/><br/>
			<strong>OBS: Use mesma senha, cadastrada anteriormente. Caso não lembre, acesse a '.$loginUsu.', e clique no botão recumperar senha.</strong><br/>
			<br/>
			'.$msgFinal;
			}

			//Inicio Monta Mensagem de Envio, caso o usuário não existe
			if($existeUsuario == false or $reenvioAcesso == 'sim'){
				$Mensagem = $msgInicial.'<br/>
				<br/>
				<h3>Dados de Acesso '.$dadosAcessoLimitado.'</h3>
				<strong>Página de Login:</strong> '.$loginUsu.'<br/>
				<strong>Usuário:</strong> '.$emailCli.'<br/>
				<strong>Senha:</strong> '.$senhaUsu.'<br/><br/>
				<strong>Produto Adquirido:</strong> '.$nomeProd.'<br/>
				<strong>Status da Compra:</strong> '.$statusCompra.'<br/>'.$msgAguardaPagmento.'
				<br/><br/>
				'.$msgFinal;
			}//Fim Monta Mensagem de Envio



			}//FIM Caso a transacao esteja aguardando pagamento ou paga

			//Caso a transacao Seja cancela ou devolvida
			if($statusTrasacaoOk == 6){
				//Mensagem Inicial recebe o Cancelamento Acesso
				$msgInicial = $cancelamentoAcesso;
				//Inicio Monta Mensagem de Envio, seja cancelada ou devolvida

					$Mensagem = $msgInicial.'<br/>
					<br/>
					<strong>Produto a ser Cancelado:</strong> '.$nomeProd.'<br/>
					<strong>Status da Compra:</strong> '.$statusCompra.'<br/>
					<br/>
					'.$msgFinal;
				//Fim Monta Mensagem de Envio

			};

			//Fim GEral Monta as Mensagens de Envio
			/////////////////////////////////////////////////////////////////


			//Inicio Sem Autenticacao
			if($tipoMetodo == 'SemAutenticacao'){
				$quebra_linha = '<br/>';
				$headers = array('Content-Type: text/html; charset=UTF-8','From: '.$remetenteEnvio.' <'.$emailEnvio.'>');
				//Faz o Envio do Acesso
				wp_mail($emailCli, $assuntoEnvio, $Mensagem, $headers);

				$gravaEvento['Envio de Mensagem']= 'Email Enviado por Wordpress';

			}//Finaliza Sem Autenticacao


			//inicia Metodo ServidorSMTP
			if($tipoMetodo == 'ServidorSMTP'){
				$emailEnvioRE = $dadosEnvio['emailEnvioRE'];
				$tipoAutenticacao = $dadosEnvio['tipoAutenticacao'];

				if($emailEnvioRE == ''){
					$emailEnvioRE = $emailServ;
				}

				if($tipoAutenticacao == ''){
					$tipoAutenticacao = 'ssl';
				}

				if($tipoAutenticacao == 'nao'){
					$tipoAutenticacao = false;
				}



				//Chama a classe PHPMailer/class.phpmailer.php
				include_once('PHPMailer/class.phpmailer.php');
				//Definicoes PHP Mailer
				date_default_timezone_set('America/Sao_Paulo');
				$mail = new PHPMailer();
				$mail->CharSet = "UTF-8";
				$mail->SetLanguage('br');
				$mail->IsSMTP();
				$mail->IsHTML(true);
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = $tipoAutenticacao;
				$mail->Port = $portaServ;
				$mail->Host = $smtpServ;
				$mail->Username = $emailServ;
				$mail->Password = $senhaServ;
				$mail->SetFrom($emailEnvioRE,$remetenteUsu);
				$mail->AddReplyTo($emailCli, $remetenteUsu);
				$mail->AddAddress($emailCli, $remetenteUsu);
				$mail->Subject = $assuntoUsu;
				$mail->MsgHTML(''.$Mensagem.'');
				$respostaEmail = $mail->Send();


				if($respostaEmail){
					$repostaMSG = 'Email ao Cliente Enviado com Uscesso';
					$gravaEvento['Envio de Mensagem']= 'Email Enviado por ServidorSMTP';
				}else{
					$repostaMSG = 'Erro ao Enviar Email ao Cliente. Verifique as Configurações de SMTP ou entre em contato com sua hospedagem.';
					$gravaEvento['Envio de Mensagem']= 'Email Não Enviado por ServidorSMTP, verifique as configurações';
				}
			}//Finaliza Envio por ServidorSMTP

			//Inicia Metodo MailJet
			if($tipoMetodo == 'MailJet'){
				$mj = new \Mailjet\Client($apikeymailjet, $secretkeymailjet);
				// Resources are all located in the Resources class
				$response = $mj->get(Resources::$Contact);
				if ($response->success()){
					$resposta = $response->getData();
					$gravaEvento['Envio de Mensagem']= 'Email Enviado por MailJet';
				}else{
					$resposta = $response->getStatus();
					$gravaEvento['Envio de Mensagem']= 'Email Não Enviado por Mailjet, verifique as configurações';
				}
				$resposta = serialize($resposta);

			//Codigo que faz o envio do acesso
			$body = [
				'FromEmail' => $emailEnvio,
				'FromName' => $remetenteEnvio,
				'Subject' => $assuntoEnvio,
				'Text-part' => $Mensagem,
				'Html-part' => $Mensagem,
				'Recipients' => [['Email' => $emailCli]]
			];
			$response = $mj->post(Resources::$Email, ['body' => $body]);
			//FIM Codigo que faz o envio do acesso
			};//Fim Metodo MailJet

		}else{
			$gravaEvento['Envio de Mensagem']= 'Usuário Atualizado, mas Mensagem não Enviada.';
		};//FIm //Monta as Mensagens de Envio


			//////////////////////////////////////////////////////////////////

		$registraclipm = $siteProd.'registraclipm.php';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $registraclipm);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_NOBODY, FALSE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $dadosCadUsuario);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response33 = curl_exec($curl);
		curl_close( $curl );

		};//FIM Envia dados SIM

		//Verifica Campos Vazio das Transacoes Recebidas
			if(count($transacaoUsuario) > 0){
				foreach ($transacaoUsuario as $chave57 => $valor57) {
					if($valor57 == ''){
						$gravaTRP = 'nao';
					};
				};
			};//FIM Verifica Campos Vazio das Transacoes Recebidas

			$gravaEvento['TREXIte'] = $trDBExiste;
			$gravaEvento['TRDiferente'] = $trDiferente;

		//Se NAO Existir Campos Vazio nas Transacoes, Grava Transacoes
		$transacaoUsuarioGrava = serialize($transacaoUsuario);
			if($gravaTRP != 'nao'){

				if($trDBExiste == 'sim' && $trDiferente == 'sim'){
					$wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '$transacaoUsuarioGrava' WHERE meta_key = '$idTransacaoDB'");

				};

				if($trDBExiste != 'sim'){
					$wpdb->insert($wpdb->postmeta, array('post_id' => $idMetaGravaTR, 'meta_key' => $idTransacaoDB,'meta_value' => $transacaoUsuarioGrava));
				};

			};//FIM //Se NAO Existir Campos Vazio nas Transacoes, Grava Transacoes

	//Remove Campos Vazio do Grava Evento
		if(count($gravaEvento) > 0){
			foreach ($gravaEvento as $chave55 => $valor55) {
				if($valor55 == ''){
					unset($gravaEvento[$chave55]);
				};
			};
		};//FIM Remove Campos Vazio do Grava Evento

	//Remove Campos Vazio do Grava Dados Usuario
		if(count($dadosCadUsuario) > 0){
			foreach ($dadosCadUsuario as $chave56 => $valor56) {
				if($valor56 == ''){
					unset($dadosCadUsuario[$chave56]);
				};
			};
		};//FIM Remove Campos Vazio do Grava Dados Usuario

	//Mostra Dados Usuario no Teste Local
	if($tipoPost == 'testeLocal' && $reenvioAcesso != 'sim'){
		if(count($transacaoUsuario) > 0){
		echo '<h4>DADOS do USUÁRIO</h4><br/>';
			foreach($transacaoUsuario as $chaveD => $dadosD){
				echo $chaveD.' => '.base64_decode($dadosD).'<br/>';
			};
		};
	};//FIM //Mostra Dados Usuario no Teste Local

	//Grava Os Eventos Executados No POST
		$gravaEventoSer = serialize($gravaEvento);
		$wpdb->insert($wpdb->postmeta, array('post_id' => $idMetaGravaPM, 'meta_key' => 'Relatorio PagMember','meta_value' => $gravaEventoSer));

	//Grava Dados do Usuario Executados No POST
		$gravaDadosUsuario = serialize($dadosCadUsuario);
		$wpdb->insert($wpdb->postmeta, array('post_id' => $idMetaGravaUsuario, 'meta_key' => 'Relatorio Usuario','meta_value' => $gravaDadosUsuario));

//FIM Verificacao se o token recebido é igual ao token do banco
	};
	//Fim Conta Token Hotmart
}else{

			if($_GET['transaction_id'] != ''){
				$idTransacaoC = $_GET['transaction_id'];
				$idTransacaoDB = 'TransacoesPagMember-'.$idTransacaoC;
				$pegaTrDB = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '$idTransacaoDB'");
				if(count($pegaTrDB) > 0){
					$dadosTrDB = unserialize($pegaTrDB);
					$urlTR = $dadosTrDB['URLRedireciona'];
					$pgred = base64_decode($urlTR);

					if($pgred == ''){
						$pgred = get_site_url();
					};
				};
			};
echo '<meta http-equiv="refresh" content="0; url='.$pgred.'">';
};
};//Fim dos testes
 ?>
