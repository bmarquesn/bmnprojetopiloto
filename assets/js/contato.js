$(function(){
    if(mensagem_enviada!='0'){
        $('.alert.bg-danger').show();
    }
});

function validar_envio_email(){
    var valido = false;
    var nome = $('input[name="nome"]');
    var email = $('input[name="email"]');
    var mensagem = $('textarea[name="mensagem"]');
    if(!completed(nome, 'Nome')){
        valido = false;
    }else if(!completed(email, 'E-mail')){
        valido = false;
    }else if(!valida_email(email, 'E-mail')){
        valido = false;
    }else if(!completed(mensagem, 'Mensagem')){
        valido = false;
    }else{
        $('p.alert').hide('fast');
        valido = true;
    }
    return valido;
}