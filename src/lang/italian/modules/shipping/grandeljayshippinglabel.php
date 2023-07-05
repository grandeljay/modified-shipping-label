<?php

/**
 * Shipping Label
 *
 * German translations
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

use Grandeljay\ShippingLabel\Constants;

$translations = array(
    /** Module */
    'TITLE'                  => 'grandeljay - Versandlabel',
    'LONG_DESCRIPTION'       => 'Consente ai clienti di utilizzare la propria etichetta di spedizione nel checkout.',
    'STATUS_TITLE'           => 'Stato',
    'STATUS_DESC'            => 'Selezioni Sì per attivare il modulo e No per disattivarlo.',

    'ALLOWED_TITLE'          => '',
    'ALLOWED_DESC'           => '',
    'HANDLING_FEE_TITLE'     => 'Manipolazione a tariffa forfettaria',
    'HANDLING_FEE_DESC'      => 'Tassa per il prelievo e l\'imballaggio della spedizione.',

    'TEXT_SHIPPING_LABEL'    => 'Etichetta di spedizione',

    'TEXT_TITLE'             => 'Spedizione con etichetta di spedizione propria',
    'TEXT_DESCRIPTION_TITLE' => 'Carichi qui la sua etichetta di spedizione (massimo %s).',
    'TEXT_DESCRIPTION_DESC'  => 'Nota: la tariffa è un costo di gestione forfettario per il prelievo e l\'imballaggio della sua spedizione.',
    'TEXT_UPLOAD_BUTTON'     => 'Selezionare il file',
    'TEXT_UPLOAD_PROGRESS'   => 'Attendere prego...',
    'TEXT_UPLOAD_SUCCESS'    => 'Il file è stato caricato con successo!',
);

foreach ($translations as $key => $value) {
    $constant = Constants::MODULE_NAME . '_' . $key;

    define($constant, $value);
}
