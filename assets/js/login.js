$(function(){
    $('.bs-docs-example').css('width','100%');
    if(php_get_msg!=0&&php_get_msg=='dadosInvalidos'){
        $('.alert.alert-danger span').html('Email e/ou Senha preenchidos são inválidos.');
        $('.alert.alert-danger').show('fast');
    }else if(php_get_msg!=0&&php_get_msg=='dadosNaoPreenchidos'){
        $('.alert.alert-danger span').html('Dados nao preenchidos e/ou são inválidos.');
        $('.alert.alert-danger').show('fast');
    }else if(retorno_msg!=0){
        $('.alert.alert-danger span').html(retorno_msg);
        $('.alert.alert-danger').show('fast');
    }
    /** enviar formulário esqueci minha senha */
    $('#modalEsqueciSenha').find('input[type="button"][value="Enviar"]').on('click', function(){
        valida_envio_email();
    });
});
function valida_envio_email(){
    var email=$('#modalEsqueciSenha').find('input[name="email"]');
    if(email.val().trim()===""){
        exibirMensagem('O campo E-mail deve ser preenchido');
        email.focus();
    }else if(!valida_email(email)){
        exibirMensagem('O campo E-mail deve estar em um formato válido');
        email.focus();
    }else{
        var confirmar=confirm('Deseja mesmo resetar sua SENHA e recebê-la por email?');
        if(confirmar){
            $.ajax({
                type:"POST",
                data:{email:email.val().trim()},
                url:url_esqueci_minha_senha,
                cache:'false',
                dataType:'json',
                beforeSend:function(){
                    $('.carregando').show('slow');
                    $('input[name="email"]').attr('disabled', 'disabled');
                    $('input[type="button"][value="Enviar"]').attr('disabled', 'disabled');
                },
                complete:function(msg){
                    $('span.carregando').hide('slow');
                    url_redirect+=msg.responseText;
                    window.location.href=url_redirect;
                }
            });
        }
    }
}
function validar_login(){
    var valido = false;
    var email = $('#email');
    var senha = $('#senha');
    if(email.val().trim()==''){
        $('p.alert').find('span').text('O campo EMAIL deve ser preenchido');
        $('p.alert').show('fast');
        email.focus();
        valido = false;
    }else if(!valida_email(email)){
        $('p.alert').find('span').text('O campo EMAIL deve ser um email válido');
        $('p.alert').show('fast');
        email.focus();
        valido = false;
    }else if(senha.val().trim()==''){
        $('p.alert').find('span').text('O campo SENHA deve ser preenchido');
        $('p.alert').show('fast');
        senha.focus();
        valido = false;
    }else{
        $('p.alert').hide('fast');
        valido = true;
    }
    return valido;
}