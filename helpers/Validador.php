<?php
namespace helpers;

class Validador
{
    public function validarCPF($cpf)
    {
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

    public function validarCelular($numero)
    {
        // Remover todos os caracteres que não são dígitos
        $numero = preg_replace('/[^0-9]/', '', $numero);

        // Verificar se o número tem 11 dígitos (incluindo o DDD)
        if (strlen($numero) === 11) {
            // Verificar se o DDD está dentro do intervalo válido para celulares no Brasil (11 a 99)
            $ddd = substr($numero, 0, 2);
            if ($ddd >= 11 && $ddd <= 99) {
                return true;
            }
        }

        return false;
    }


    public function validarEmail($email)
    {
        // Verificar se o e-mail possui um formato válido
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public function validarPlaca($placa)
    {
        // Transformar todas as letras em maiúsculas
        $placa = strtoupper(trim($placa));

        // Verificar se a placa tem exatamente 7 caracteres
        if (strlen($placa) !== 7) {
            return false;
        }

        // Verificar o formato da placa usando expressão regular
        if (!preg_match('/^[A-Z]{3}\d[A-Z]\d{2}$/', $placa)) {
            return false;
        }

        return true;
    }
}
?>