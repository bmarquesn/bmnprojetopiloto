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
		nextText: 'PrÃ³ximo',
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
		$("#noticias").tablesorter({
			headers:{
				1:{sorter:'datetime'}
				,2:{sorter:false}
			},
			dateFormat:'dd/mm/yyyy H:i'
		});
	}
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
function completed(field, name) {
	if (field.val() != ''){
		return true;
	}else{
		$('.alert.alert-danger span').html('O campo '+name+' deve ser preenchido');
		$('.alert.alert-danger').show('fast');
		field.focus();
		return false;
	}
}

//Function that checks if valid email
function email(field, name) {
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

//-------------------------------------------------------------
function validar_insercao_prospect() {
	var ok = false;
	
	if(!completed($('#nome'),'Nome')) {
		ok = false;
	} else if(!completed($('#setor'),'Setor')) {
		ok = false;
	} else if(!completed($('#contatos'),'Contatos')) {
		ok = false;
	} else if(!completed($('#acao'),'Ação')) {
		ok = false;
	} else if(!completed($('#dataProximaAcao'),'Data Próxima Ação')) {
		ok = false;
	} else {
		ok = true;
	}
	
	return ok;
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