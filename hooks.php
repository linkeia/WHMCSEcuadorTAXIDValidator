<?php

if (!defined('WHMCS')) {
    die('Access Denied');
}

use WHMCS\Database\Capsule;

class TaxIdValidator
{
    private static $processed = false;

    public static function validate($country, $taxId)
    {
        if (self::$processed) {
            return null; // Evitar procesar múltiples veces
        }

        self::$processed = true;

        if (strtoupper($country) !== 'EC') {
            logActivity("País no es Ecuador. Validación omitida.");
            return null;
        }

        if (empty($taxId)) {
            return "El campo TAX ID no puede estar vacío. / The TAX ID field cannot be empty.";
        }

        if (strlen($taxId) === 10 && !self::isValidCedula($taxId)) {
            return "La cédula ingresada no es válida. / The entered Cedula is not valid.";
        }

        if (strlen($taxId) === 13 && !self::isValidRUC($taxId)) {
            return "El RUC ingresado no es válido. / The entered RUC is not valid.";
        }

        if (strlen($taxId) !== 10 && strlen($taxId) !== 13) {
            return "El TAX ID debe tener 10 dígitos (Cédula) o 13 dígitos (RUC). / The TAX ID must have 10 digits (Cedula) or 13 digits (RUC).";
        }

        return null;
    }

    private static function isValidCedula($cedula)
    {
        if (!preg_match('/^\\d{10}$/', $cedula)) {
            return false;
        }

        $provincia = substr($cedula, 0, 2);
        if ($provincia < 1 || $provincia > 24) {
            return false;
        }

        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;

        for ($i = 0; $i < 9; $i++) {
            $digito = (int)$cedula[$i] * $coeficientes[$i];
            $suma += $digito >= 10 ? $digito - 9 : $digito;
        }

        $verificador = (10 - ($suma % 10)) % 10;
        return $verificador == $cedula[9];
    }

    private static function isValidRUC($ruc)
    {
        if (!preg_match('/^\\d{13}$/', $ruc)) {
            return false;
        }

        $tercerDigito = (int)$ruc[2];
        logActivity("Tercer dígito del RUC: {$tercerDigito}");

        if (in_array($tercerDigito, [0, 1, 2, 3, 4, 5])) {
            return self::isValidCedula(substr($ruc, 0, 10)) && self::isValidEstablecimiento(substr($ruc, 10, 3));
        } elseif ($tercerDigito == 9) {
            return self::isValidRUCPrivado($ruc);
        } elseif ($tercerDigito == 6) {
            return self::isValidRUCPublico($ruc);
        }

        return false;
    }

    private static function isValidRUCPrivado($ruc)
    {
        if (strlen($ruc) !== 13) {
            logActivity("RUC privado no cumple con la longitud de 13 dígitos.");
            return false;
        }

        $establecimiento = (int)substr($ruc, 10, 3);
        if ($establecimiento <= 0) {
            logActivity("Establecimiento del RUC privado inválido: {$establecimiento}");
            return false;
        }

        $numeroSecuencial = substr($ruc, 0, 9); // Primeros 9 dígitos del RUC
        if ((int)$numeroSecuencial > 999999) {
            logActivity("Excepción SRI: Número secuencial supera los 6 dígitos. Validación del Módulo 11 omitida.");
            return true; // Aceptar el RUC sin verificar el décimo dígito
        }

        $coeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
        $suma = 0;

        for ($i = 0; $i < 9; $i++) {
            $suma += $ruc[$i] * $coeficientes[$i];
        }

        $residuo = $suma % 11;
        $verificadorCalculado = $residuo === 0 ? 0 : 11 - $residuo;

        if ($verificadorCalculado === 10) {
            logActivity("Dígito verificador no puede ser 10 para un RUC privado.");
            return false;
        }

        $verificadorActual = (int)$ruc[9];
        if ($verificadorCalculado !== $verificadorActual) {
            logActivity("Dígito verificador del RUC privado no coincide: Calculado: {$verificadorCalculado}, Actual: {$verificadorActual}.");
            return false;
        }

        logActivity("RUC privado válido.");
        return true;
    }

    private static function isValidRUCPublico($ruc)
    {
        $coeficientes = [3, 2, 7, 6, 5, 4, 3, 2];
        $suma = 0;

        for ($i = 0; $i < 8; $i++) {
            $suma += $ruc[$i] * $coeficientes[$i];
        }

        $residuo = $suma % 11;
        $verificadorCalculado = $residuo === 0 ? 0 : 11 - $residuo;

        return $verificadorCalculado === (int)$ruc[8];
    }

    private static function isValidEstablecimiento($establecimiento)
    {
        return (int)$establecimiento > 0;
    }
}

// Hook para Registro
add_hook('ClientDetailsValidation', 1, function ($vars) {
    $country = $vars['country'] ?? '';
    $taxId = $vars['tax_id'] ?? '';

    $error = TaxIdValidator::validate($country, $taxId);
    return $error ? ['tax_id' => $error] : [];
});

// Hook para Checkout
add_hook('ShoppingCartValidateCheckout', 1, function ($vars) {
    $country = App::getFromRequest('country');
    $taxId = App::getFromRequest('tax_id');

    $error = TaxIdValidator::validate($country, $taxId);
    return $error ? ['tax_id' => $error] : [];
});
