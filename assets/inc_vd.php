<?php
global $wpdb;
$vd_pagmember = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'vd_pagmember'");
$conta_vd = count($vd_pagmember);
$vd_dataHoje = date('Y-m-d');
if($conta_vd > 0 && $_GET['pg'] != 'ativar'){	
	
	$datavd = unserialize($vd_pagmember);
	$vd_dataAtivacao = $datavd['dataAtivacao'];
	$vd_dataVefificacao = $datavd['dataVefificacao'];
	$vd_dataFinal = $datavd['dataFinal'];
	$vd_key = $datavd['key'];
	
	if($vd_status != 1){
		$vd_totalVerificacao = $datavd['totalVerificacao'];
	}
	
	//var_dump($datavd);
	
}
if($conta_vd == 0){
	$vd_dataAtivacao = '';
	$vd_dataVefificacao = $vd_dataHoje;
	$vd_key = '';
	$vd_status = 2;
	$vd_totalVerificacao = 3;
	$vd_dataFinal = date('Y-m-d', strtotime($vd_dataHoje. ' + '.$vd_totalVerificacao.' days'));		
	$datavd['dataAtivacao'] = $vd_dataAtivacao;
	$datavd['dataVefificacao'] = $vd_dataVefificacao;
	$datavd['dataFinal'] = $vd_dataFinal;
	$datavd['status'] = $vd_status;
	$datavd['key'] = $vd_key;
	$datavd['totalVerificacao'] = $vd_totalVerificacao;				
	$serVD = serialize($datavd);	
	$wpdb->insert($wpdb->options, array('option_name' => 'vd_pagmember','option_value' => $serVD));		
}
?>