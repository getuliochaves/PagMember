<?php
global $wpdb;
$meta_id = $_GET['meta_id'];
$nomeProd = $_GET['nomeProd'];
$dataAgora = date('d-m-Y');
$nomeProd2 = $nomeProd.'(dup)'.$dataAgora;
$nomeProd3 = 'ProdPagMember#'.$nomeProd2;


$pegaUnico = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '$nomeProd3'");
if($pegaUnico == ''){
$pegaProd = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_id = '$meta_id'");
$dadosProd = unserialize($pegaProd);
$idProd = $pegaProd['idProd'];

$chaves = array();
$valores = array();
foreach($dadosProd as $key => $valor){	
	array_push($chaves, $key);	
	if($valor == $nomeProd){
		array_push($valores, $nomeProd2);		
		}else{
	array_push($valores, $valor);		
			}
	
	}
	
$geraProdDup = array_combine($chaves, $valores);
$geraProdDupSer = serialize($geraProdDup);

$grava = $wpdb->insert($wpdb->postmeta, array('meta_key' => 'ProdPagMember#'.$nomeProd2.'*idProd#'.$idProd,'meta_value' => $geraProdDupSer));
?>

<h3>Duplicando Produto <strong><?php echo $nomeProd; ?></strong></h3>

<div class="alert alert-success"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Produto duplicado com sucesso. Redirecionando... Aguarde...</div>
<meta http-equiv="refresh" content="3; url=admin.php?page=pagmember&pg=produtos">

<?php
}else{
?>

<h3>Duplicando Produto <strong><?php echo $nomeProd; ?></strong></h3>

<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Erro ao duplicar o Produto. Existe outro produto com esse nome. Renomeio o Produto atual ou duplique partir de outro Produto. Redirecionando...</div>

<meta http-equiv="refresh" content="10; url=admin.php?page=pagmember&pg=produtos">

<?php
};
?>