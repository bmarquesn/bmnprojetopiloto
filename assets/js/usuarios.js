function valida_cadastro_usuario(){
    var retorno;
    var id_usuario = $('input[name="id_usuario"]').val().trim();
    var nome = $('#nome');
    var email = $('#email');
    var senha = $('#senha');
    if(!completed(nome, 'NOME')){
        retorno=false;
    }else if(!completed(email, 'E-MAIL')){
        retorno=false;
    }else if(!validEmail(email, 'E-MAIL')){
        retorno=false;
    }else if(id_usuario=="0"&&!completed(senha, 'SENHA')){
        retorno=false;
    }else{
        retorno=verificar_email_existente(email, id_usuario);

        if(retorno){
            $('p.alert').hide('fast');
            return true;
        }else{
            $('p.alert').find('span').text('O EMAIL digitado já está em uso por outro usuário');
            $('p.alert').show('fast');
            email.focus();
            return false;
        }
    }
    return retorno;
}
function verificar_email_existente(email, id_usuario_email){
    var email_informado=email.val().trim();
    var retorno;
    $.ajax({
        type:"POST",
        data:{'id':id_usuario_email,'email':email_informado},
        url:base_url+'admin/usuarios/verificar_email_existente',
        cache:'false',
        dataType: 'html',
        async: false,
        beforeSend: function(){
            $('.carregando').fadeIn('fast');
        },
        complete: function(msg){
            $('.carregando').fadeOut('fast');
            
            if(msg.responseText=="1"){
                retorno=false;
            }else{
                retorno=true;
            }
        },
        error: function() {
            alert('Erro ao verificar email');
        }
    });
    return retorno;
}