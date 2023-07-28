<?php
function validarCPF($cpf) {
    // Remover caracteres não numéricos do CPF
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verificar se o CPF tem 11 dígitos
    if (strlen($cpf) !== 11) {
        return false;
    }

    // Verificar se todos os dígitos são iguais (CPF inválido)
    if (preg_match('/^(\d)\1*$/', $cpf)) {
        return false;
    }

    // Calcular o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += intval($cpf[$i]) * (10 - $i);
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    // Verificar o primeiro dígito verificador
    if ($digito1 !== intval($cpf[9])) {
        return false;
    }

    // Calcular o segundo dígito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += intval($cpf[$i]) * (11 - $i);
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    // Verificar o segundo dígito verificador
    if ($digito2 !== intval($cpf[10])) {
        return false;
    }

    return true;
}

// Verificar se o formulário foi enviado

?>
