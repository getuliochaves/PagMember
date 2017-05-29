function verifica(){	
	var veri = document.getElementById("chekbox").checked;
	
	
	
	if(veri == true){
    //inicia2();
	//document.getElementById("formulario").select();
	
	document.getElementById("desabilitanome").style.display = "none"; 
	document.getElementById("destextonome").style.display = "none";  
	
	}
	
	if(veri == false){	
    pegacampos();	
	document.getElementById("desabilitanome").style.display = "block";
	document.getElementById("destextonome").style.display = "block";
	
	}
}


function geraform(){
	document.getElementById("geraformulario").style.display = "block";
	document.getElementById("entrada").style.display = "none";	
	
	var textonome = document.getElementById("textonome").value;
	var textoemail = document.getElementById("textoemail").value;
	
	
	var action = $a('#conteudo form').attr('action');
	var textobotao = document.getElementById("textobotao").value;
	
	
	var veri = document.getElementById("chekbox").checked;	
	if(veri == true){
    var pegaoemail = document.getElementById("campoemail").value;	

	
	var novocampo2 = '';
	var novocampo1 = '';	  
	$a('#conteudo form input[type=email], #conteudo form input[type=text], #conteudo form input[type=hidden]').each(function(index){
	var nomecampo = '';
	var tipocampo = '';
	var valorcampo = '';
	var requer = '';
	var placeholder = '';
	
    var input = $a(this);
	
	nomecampo = input.attr('name');
	tipocampo = input.attr('type');
	valorcampo = input.val();
	
	
	
		
	if(nomecampo == pegaoemail){
		
		
		tipocampo = 'email';
		requer = 'required';
		placeholder = textoemail;
		var campos2email = '<input class="form-control texto" '+requer+' name="'+ nomecampo +'" value="'+ valorcampo +'" type="'+ tipocampo +'" placeholder="'+ placeholder +'"/>';
		if(novocampo1 != campos2email){
		novocampo1 = novocampo1 + '\n' + campos2email;	
		}
		}	
		
	if(nomecampo != pegaoemail){
		tipocampo = 'hidden';		
		var campos2 = '<input name="'+ nomecampo +'" value="'+ valorcampo +'" type="'+ tipocampo +'"/>';
		if(novocampo2 != campos2){
		novocampo2 = novocampo2 + '\n' + campos2;	
		}
		}	
	
	var total = input.length;	
	
		
	var montaform = '\<form method="post" action="'+action+'" class="animated bounceInUp delay2">\
			'+ novocampo2 +'\
			'+ novocampo1 +'\
			\n<input type="submit" value="'+ textobotao +'" class="btn btn-success btn-lg btn-block tpreto btcta fundobotao"/>\
			\n</form>';
			$a("#formulario").html(montaform);
	
		
	});

	
	
	}// fim do if true
	
	if(veri == false){	
    var pegaoemail = document.getElementById("campoemail").value;
	var pegaonome = document.getElementById("camponome").value;
	
	var novocampo2 = '';
	var novocampo1 = '';	  
	$a('#conteudo form input[type=email], #conteudo form input[type=text], #conteudo form input[type=hidden]').each(function(index){
	var nomecampo = '';
	var tipocampo = '';
	var valorcampo = '';
	var requer = '';
	var placeholder = '';
	
    var input = $a(this);
	
	nomecampo = input.attr('name');
	tipocampo = input.attr('type');
	valorcampo = input.val();
	
	
	
	if(nomecampo == pegaonome){
		tipocampo = 'text';
		requer = '';
		placeholder = textonome;
		var campos2nome = '<input class="form-control texto" name="'+ nomecampo +'" value="'+ valorcampo +'" type="'+ tipocampo +'" placeholder="'+ placeholder +'"/>';
		if(novocampo2 != campos2nome){
		novocampo2 = novocampo2 + '\n' + campos2nome;	
		}
		}	
		
	if(nomecampo == pegaoemail){
		tipocampo = 'email';
		requer = 'required';
		placeholder = textoemail;
		var campos2email = '<input class="form-control texto" '+requer+' name="'+ nomecampo +'" value="'+ valorcampo +'" type="'+ tipocampo +'" placeholder="'+ placeholder +'"/>';
		if(novocampo1 != campos2email){
		novocampo1 = novocampo1 + '\n' + campos2email;	
		}
		}	
		
	if(nomecampo != pegaoemail && nomecampo != pegaonome){
		tipocampo = 'hidden';		
		var campos2 = '<input name="'+ nomecampo +'" value="'+ valorcampo +'" type="'+ tipocampo +'"/>';
		if(novocampo2 != campos2){
		novocampo2 = novocampo2 + '\n' + campos2;	
		}
		}	
		
		
		
		
		
		
	
	
	
	
	var total = input.length;
	
	
	
		
	var montaform = '\<form method="post" action="'+action+'" class="animated bounceInUp delay2">\
			'+ novocampo2 +'\
			'+ novocampo1 +'\
			\n<input type="submit" value="'+ textobotao +'" class="btn btn-success btn-lg btn-block tpreto btcta fundobotao"/>\
			\n</form>';
			$a("#formulario").html(montaform);
	
		
	});

	
}// fim do if falso

document.getElementById("formulario").select();
}
