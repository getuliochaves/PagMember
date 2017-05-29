<?php
global $wpdb;
$nomeProd = $_POST['nomeProd'];
$idProd = $_POST['idProd'];
$tipoProd = $_POST['tipoProd'];
$descOff = $_POST['descOff'];
$nomeOff = $_POST['nomeOff'];
if($tipoProd == 'hotmart' && $descOff != ''){
		$nomeProd = $nomeProd.'#'.$nomeOff;
}

$nomeProdDB = 'ProdPagMember#'.$nomeProd.'*idProd#'.$idProd;
$packProdExp00 = $_POST['packProd'];
$packProdExp0 = str_replace(' ', '', $packProdExp00);



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

$grava = $wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '$serlizeDadosProd' WHERE meta_id = '$prodMetaId'");
$grava = $wpdb->query("UPDATE $wpdb->postmeta SET meta_key = '$nomeProdDB' WHERE meta_id = '$prodMetaId'");


?>

<h3>Atualizando Produto <strong><?php echo $nomeProd; ?></strong></h3>
<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Produto Atualizado com Sucesso. Redirecionando, Aguarde...</div>
<meta http-equiv="refresh" content="0; url=admin.php?page=pagmember&pg=produtos&pg2=prod&pg3=edit&prodMetaId=<?php echo $prodMetaId; ?>">
