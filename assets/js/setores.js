function valida_cadastro_setor(){
    var valido = false;
    var id = $('#id');
    var nome = $('#nome');
    if(nome.val()==''){
        completed(nome, 'NOME');
    }else{
        $('p.alert').hide('fast');
        valido = true;
    }
    return valido;
}