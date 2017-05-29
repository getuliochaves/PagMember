function vai(){	
	
	var text = $a('textarea#formEntrada').val();
    $a("#conteudo").html(text);	
	if(text != ''){
	pegacampos();	
	document.getElementById('configform').style.display="block";
    }
}


function pegacampos(){
	
	var pegaConteudo = $a('#conteudo').val();

	alert(pegaConteudo);
	
	$a('#conteudo form input').each(function(index){
		
	var nomecampo = '';
	var tipocampo = '';
	var valorcampo = '';
	
    var input = $a(this);
	
	nomecampo = input.attr('name');
	tipocampo = input.attr('type');
	valorcampo = input.val();
	
	var campos1 = '<option value="'+ nomecampo +'">'+ nomecampo +'</option>';
	
	var total = input.length;
	
	
	if(novocampo != campos1){
		novocampo = novocampo + '\n' + campos1;	
		}	
		
		if(index == 0){			
			$a("#campoemail").html(novocampo);
			$a("#camponome").html(novocampo);
			}
		
	
		if(total <= index){
			$a("#campoemail").html(novocampo);
			$a("#camponome").html(novocampo);
			}
	});
	
}