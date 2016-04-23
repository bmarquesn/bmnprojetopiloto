$(function() {
	$("a").click(function(event) {
        if ($(this).attr("href") === "http://#" || $(this).attr("href") === "#" || $(this).attr("href") === "") {
            event.preventDefault();
        }
    });
	$('.datepicker').datetimepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior',
		controlType: 'select',
		oneLine: true,
		timeOnlyTitle: 'Escolha a hora',
		timeText: 'Hora',
		hourText: 'Horas',
		minuteText: 'Minutos',
		secondText: 'Segundos',
		millisecText: 'Milissegundos',
		timezoneText: 'Fuso horário',
		currentText: 'Agora',
		closeText: 'Fechar',
		timeFormat: 'HH:mm',
		amNames: ['a.m.', 'AM', 'A'],
		pmNames: ['p.m.', 'PM', 'P'],
		ampm: true
	});
	if(temTableSorter==1){
		$.tablesorter.addParser({
			id: 'datetime',
			is: function(s) {
				return false; 
			},
			format: function(s,table) {
				s = s.replace(/-/g,"/");
				s = s.replace(/(d{1,2})[/-](d{1,2})[/-](d{4})/, "$3/$2/$1");
				return $.tablesorter.formatFloat(new Date(s).getTime());
			},
			type: 'numeric'
		});
		$("#usuarios").tablesorter({
			headers:{4:{sorter:false}}
		});
		$("#prospects").tablesorter({
			headers:{
				3:{sorter:false}
				,4:{sorter:'datetime'}
				,5:{sorter:'datetime'}
				,6:{sorter:false}
			},
			dateFormat:'dd/mm/yyyy H:i'
		});
		$("#setores").tablesorter({
			headers:{1:{sorter:false}}
		});
		$("#historic_acoes").tablesorter({
			headers:{1:{sorter:'datetime'}}
		});
	}
	
	$('.estado div').click(function(){
		var confirmar = confirm('Deseja mesmo alterar o status deste Prospect?');
		
		if(confirmar) {
			var acaoId = $(this).children('input').val();
			var prospectSelecionado = $(this).parent('.estado').children('.id_prospect').val();
			atualizarStatusProspect(prospectSelecionado,acaoId);
		}
	});
	
	$('#limpar_filtro').click(function(){
		$(this).parents('form').find('input[type="text"]').val('');
		$(this).parents('form').submit();
	});
});
$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
	  numFiles = input.get(0).files ? input.get(0).files.length : 1,
	  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		
		var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;
		
		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}
		
	});
});
/*validates form*/
//Function that checks if the field is empty
function completed(field, name){
	if (field.val() != ''){
		return true;
	}else{
		$('.alert.bg-danger span').html('O campo '+name+' deve ser preenchido');
		$('.alert.bg-danger').show('fast');
		field.focus();
		return false;
	}
}

//Function that checks if valid email
function validEmail(field, name){
    var value_field = $(field).val();
    if ((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value_field)) || (!value_field)) {
        return true;
    } else {
        $('.alert.alert-danger span').html('O campo ' + name + ' deve ser um email válido.');
		$('.alert.alert-danger').show('fast');
        $(field).focus();
        return false;
    }
}

function confirmar_exclusao(tipo){
	var retorno=false;
	var confirmar=confirm('Deseja mesmo excluir o '+tipo);
	if(confirmar){
		retorno=true;
	}
	return retorno;
}

/* Brazilian initialisation for the jQuery UI date picker plugin. */
/* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		// AMD. Register as an anonymous module.
		define([ "../datepicker" ], factory );
	} else {
		// Browser globals
		factory( jQuery.datepicker );
	}
}(function( datepicker ) {
	datepicker.regional['pt-BR'] = {
	closeText: 'Fechar',
	prevText: 'Anterior',
	nextText: 'Próximo',
	currentText: 'Hoje',
	monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
	dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
	dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
	weekHeader: 'Sm',
	dateFormat: 'dd/mm/yy',
	firstDay: 0,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''};
	datepicker.setDefaults(datepicker.regional['pt-BR']);
	return datepicker.regional['pt-BR'];
}));

function atualizarStatusProspect(prospectSelecionado,acaoId) {
	$.ajax({
        type:"POST",
        data:{acao:acaoId},
        url:urlAtualizarStatusProspect+''+prospectSelecionado,
        cache:'false',
        dataType: 'json',
        success:function(data){
        	if(data == '1') {
	        	for(i = 1; i <= 5; i++) {
	        		$('.num_'+prospectSelecionado).parent('div').children('.p'+i).removeClass('estado_'+i);
	        	}
	        	
	        	for(i = 1; i <= acaoId; i++) {
	        		$('.num_'+prospectSelecionado).parent('div').children('.p'+i).addClass('estado_'+i);
	        	}
        	} else {
        		alert('Erro... Tente novamente atualizar o Estado deste Prospect!!!');
        	}
        },
        beforeSend: function(){
            $('.carregando').fadeIn('fast');
        },
        complete: function(msg){
        	$('.carregando').fadeOut('fast');
        }
    });
}