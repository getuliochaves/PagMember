<?php
global $wpdb;


$listaNot = $wpdb->get_results("SELECT * FROM $wpdb->options WHERE option_name like '%notificacaoPagMember#%'");

//Conta se existem notificacoes
if(count($listaNot) > 0){
	//Foreach loop pelas notificaoes

	$notePagSeguro = 'notificacaoPagMember#PagSeguro';
	$urlNotPag = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$notePagSeguro'");

	if($urlNotPag != ''){


		$diretorioDestino = ABSPATH.$urlNotPag.'/';
		$diretorioInicial = ABSPATH.'wp-content/plugins/PagMember/scripts/'.$urlNotPag;

		$destino = '../copia/';
		$diretorio = '../scripts/';

		/////////////////////////////////////////////////////////////////////////////////

		//$Dir = ABSPATH.$urlNot;

		$diretorioRemove = ABSPATH.$urlNotPag;
		//Inicia a funcao de
		function removeTreeRec($rootDir)
		{
		    if (!is_dir($rootDir))
		    {
		        return false;
		    }
		    if (!preg_match("/\\/$/", $rootDir))
		    {
		        $rootDir .= '/';
		    }


		    $dh = opendir($rootDir);

		    while (($file = readdir($dh)) !== false)
		    {
		        if ($file == '.'  ||  $file == '..')
		        {
		            continue;
		        }


		        if (is_dir($rootDir . $file))
		        {
		            removeTreeRec($rootDir . $file);
		        }

		        else if (is_file($rootDir . $file))
		        {
		            unlink($rootDir . $file);
		        }
		    }

		    closedir($dh);

		    rmdir($rootDir);

		    return true;
		};//Fim da funcao remove

		//Inicia Funcao Copia Diretorio
		function copyr($source, $dest)
		{
		   // COPIA UM ARQUIVO
		   if (is_file($source)) {
		      return copy($source, $dest);
		   }

		   // CRIA O DIRETÓRIO DE DESTINO
		   if (!is_dir($dest)) {
		      mkdir($dest);
		    //  echo "DIRET&Oacute;RIO $dest CRIADO<br />";
		   }

		   // FAZ LOOP DENTRO DA PASTA
		   $dir = dir($source);
		   while (false !== $entry = $dir->read()) {
		      // PULA "." e ".."
		      if ($entry == '.' || $entry == '..') {
		         continue;
		      }

		      // COPIA TUDO DENTRO DOS DIRETÓRIOS
		      if ($dest !== "$source/$entry") {
		         copyr("$source/$entry", "$dest/$entry");
		         //echo "COPIANDO $entry de $source para $dest <br />";
		      }
		   }

		   $dir->close();
		   return true;
		};//FIM  Funcao Copia Diretorio

		//copyr($diretorioInicial,$diretorioDestino);

		$inicioMailjet = ABSPATH.'wp-content/plugins/PagMember/scripts/Mailjet.zip';
		$destinoMailjet = $diretorioDestino.'Mailjet.zip';



		//////////////////////////////////////////////////////////////////////////////////

	};// FIM cria notificacao PagSeguro



/////////////////////////////////
///NOTIFICACAO HOTMART///
/////////////////////////////////



	$noteHotmart = 'notificacaoPagMember#Hotmart';
	$urlNotHot = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$noteHotmart'");

	if($urlNotHot != ''){


		$diretorioDestinoH = ABSPATH.$urlNotHot.'/';
		$diretorioInicialH = ABSPATH.'wp-content/plugins/PagMember/scripts/'.$urlNotHot;


		/////////////////////////////////////////////////////////////////////////////////

		//$Dir = ABSPATH.$urlNot;

		$diretorioRemoveH = ABSPATH.$urlNotHot;
		//Inicia a funcao de
		function removeTreeRecH($rootDir)
		{
				if (!is_dir($rootDir))
				{
						return false;
				}
				if (!preg_match("/\\/$/", $rootDir))
				{
						$rootDir .= '/';
				}


				$dh = opendir($rootDir);

				while (($file = readdir($dh)) !== false)
				{
						if ($file == '.'  ||  $file == '..')
						{
								continue;
						}


						if (is_dir($rootDir . $file))
						{
								removeTreeRec($rootDir . $file);
						}

						else if (is_file($rootDir . $file))
						{
								unlink($rootDir . $file);
						}
				}

				closedir($dh);

				rmdir($rootDir);

				return true;
		};//Fim da funcao remove

		//Inicia Funcao Copia Diretorio
		function copyrH($source, $dest)
		{
			 // COPIA UM ARQUIVO
			 if (is_file($source)) {
					return copy($source, $dest);
			 }

			 // CRIA O DIRETÓRIO DE DESTINO
			 if (!is_dir($dest)) {
					mkdir($dest);
				//  echo "DIRET&Oacute;RIO $dest CRIADO<br />";
			 }

			 // FAZ LOOP DENTRO DA PASTA
			 $dir = dir($source);
			 while (false !== $entry = $dir->read()) {
					// PULA "." e ".."
					if ($entry == '.' || $entry == '..') {
						 continue;
					}

					// COPIA TUDO DENTRO DOS DIRETÓRIOS
					if ($dest !== "$source/$entry") {
						 copyr("$source/$entry", "$dest/$entry");
						 //echo "COPIANDO $entry de $source para $dest <br />";
					}
			 }

			 $dir->close();
			 return true;
		};//FIM  Funcao Copia Diretorio

		//copyr($diretorioInicial,$diretorioDestino);

		$inicioMailjetH = ABSPATH.'wp-content/plugins/PagMember/scripts/Mailjet.zip';
		$destinoMailjetH = $diretorioDestinoH.'Mailjet.zip';



		//////////////////////////////////////////////////////////////////////////////////

	};// FIM cria notificacao Hotmart


};//FIM conta se existem notificacoes
?>
