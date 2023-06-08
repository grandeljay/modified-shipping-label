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
    'LONG_DESCRIPTION'       => 'Ermöglicht es Kunden ein eignes Versandlabel im Checkout zu verwenden.',
    'STATUS_TITLE'           => 'Status',
    'STATUS_DESC'            => 'Wählen Sie Ja um das Modul zu aktivieren und Nein um es zu deaktivieren.',

    'ALLOWED_TITLE'          => '',
    'ALLOWED_DESC'           => '',
    'HANDLING_FEE_TITLE'     => 'Handling-Pauschale',
    'HANDLING_FEE_DESC'      => 'Gebühr für das Picken und Packen der Sendung.',

    'TEXT_SHIPPING_LABEL'    => 'Versandlabel',

    'TEXT_TITLE'             => 'Versand mit eigenem Versandlabel',
    'TEXT_DESCRIPTION_TITLE' => 'Laden Sie ihr eigenes Versandlabel hier hoch (maximal %s).',
    'TEXT_DESCRIPTION_DESC'  => 'Hinweis: Die Gebühr versteht sich als eine Handling-Pauschale für das Picken und Packen Ihrer Sendung.',
    'TEXT_UPLOAD_BUTTON'     => 'Datei wählen',
    'TEXT_UPLOAD_PROGRESS'   => 'Bitte warten...',
    'TEXT_UPLOAD_SUCCESS'    => 'Die Datei wurde erfolgreich hochgeladen!',
);

foreach ($translations as $key => $value) {
    $constant = Constants::MODULE_NAME . '_' . $key;

    define($constant, $value);
}
