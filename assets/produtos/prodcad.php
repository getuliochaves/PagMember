<?php
global $wpdb;
$nomeProd = $_POST['nomeProd'];
$packProdExp00 = $_POST['packProd'];
$idProd = $_POST['idProd'];
$packProdExp0 = str_replace(' ', '', $packProdExp00);
$tipoProd = $_POST['tipoProd'];
$nomeOff = $_POST['nomeOff'];
$descOff = $_POST['descOff'];
$clienteNoSite = $_POST['clienteNoSite'];
$clienteNoSite = $_POST['redProd'];
if($tipoProd == 'hotmart' && $descOff != ''){
	$nomeProd = $nomeProd.'#'.$nomeOff;
}

$dadosProd = $_POST;
$chaveProd = array();
$valorProd = array();
foreach($dadosProd as $key => $value){
	
	if($key == 'packProd'){
		$packProdExp1 = explode(',',$packProdExp0);
		$packProd = serialize($packProdExp1);
		array_push($chaveProd,$key);
		array_push($valorProd,$packProd);
		}else{
	
	array_push($chaveProd,$key);
	array_push($valorProd,$value);
		}
		
}

$ProdAlt = array_combine($chaveProd, $valorProd);
$serlizeDadosProd = serialize($ProdAlt);


$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => 'ProdPagMember#'.$nomeProd.'*idProd#'.$idProd,'meta_value' => $serlizeDadosProd));
?>

<h3>Cadastrando Produto <strong><?php echo $nomeProd; ?></strong></h3>
<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Produto Atualizado com Sucesso. Redirecionando, Aguarde...</div>
<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=produtos">
