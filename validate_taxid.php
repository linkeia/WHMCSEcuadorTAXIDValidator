<?php

if (!defined('WHMCS')) {
    die('Access Denied');
}

/**
 * Configuración del módulo
 */
function validate_taxid_config()
{
    return [
        'name' => 'Validación de TAX ID de Ecuador',
        'description' => 'Este módulo valida el TAX ID (Cédula o RUC) para usuarios de Ecuador en el registro y el checkout.',
        'version' => '1.3',
        'author' => 'Linkeia Network',
    ];
}

/**
 * Activar el módulo
 */
function validate_taxid_activate()
{
    return ['status' => 'success', 'description' => 'El módulo de validación de TAX ID ha sido activado.'];
}

/**
 * Desactivar el módulo
 */
function validate_taxid_deactivate()
{
    return ['status' => 'success', 'description' => 'El módulo de validación de TAX ID ha sido desactivado.'];
}

/**
 * Configuración personalizada en el backend
 */
function validate_taxid_output($vars)
{
    echo '<div style="padding-bottom:20px;"><img src="https://linkeia.com/modules/addons/validate_taxid/logo.png" alt="Linkeia Newtork"></div>';
    echo '<div class="alert alert-info">Este módulo está configurado desde <strong>Configuración > Módulos adicionales</strong>.</div>';
    echo '<div class="alert alert-info">
            <p><strong>Información del módulo:</strong></p>
            <p>Este módulo ha sido desarrollado por <strong>Linkeia Network</strong> para la validación del TAX ID de Ecuador en el sistema WHMCS. Es compatible con las versiones 8.10 y 8.11. Las validaciones se ejecutan únicamente si el soporte para TAX ID nativo de WHMCS está activado en <strong>Ajustes > Ajustes de Impuestos</strong>. Utiliza el campo TAX ID para validar cédulas, RUC públicos y RUC privados, siempre que el país de dirección sea Ecuador. Si necesitas ayuda o soporte, visita <a href="https://www.linkeia.com" target="_blank">www.linkeia.com</a> para más información.</p>
          </div>';
}
