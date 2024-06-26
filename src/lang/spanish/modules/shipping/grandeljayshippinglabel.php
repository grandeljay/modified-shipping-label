<?php

/**
 * Shipping Label
 *
 * Spanish translations
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

use Grandeljay\ShippingLabel\Constants;

$translations = [
    /** Module */
    'TITLE'                      => 'grandeljay - Versandlabel',
    'LONG_DESCRIPTION'           => 'Permite a los clientes utilizar su propia etiqueta de envío en la caja.',
    'STATUS_TITLE'               => 'Estado',
    'STATUS_DESC'                => 'Seleccione Sí para activar el módulo y No para desactivarlo.',

    'ALLOWED_TITLE'              => '',
    'ALLOWED_DESC'               => '',
    'SORT_ORDER_TITLE'           => 'Orden de clasificación',
    'SORT_ORDER_DESC'            => 'Determina la clasificación en Admin y Checkout. Los números más bajos se muestran primero.',
    'HANDLING_FEE_TITLE'         => 'Tarifa plana de manipulación',
    'HANDLING_FEE_DESC'          => 'Tasa por recoger y embalar el envío.',
    'PICK_PACK_TITLE'            => 'Pick & Pack',
    'PICK_PACK_DESC'             => 'Gastos de montaje y embalaje del pedido.',

    'TEXT_SHIPPING_LABEL'        => 'Etiqueta de envío',

    'TEXT_TITLE'                 => 'Envío con etiqueta de envío propia',
    'TEXT_TITLE_WEIGHT'          => 'Envío con etiqueta de envío propia (%s kg)',
    'TEXT_DESCRIPTION_TITLE'     => 'Cargue aquí su propia etiqueta de envío (máximo %s).',
    'TEXT_DESCRIPTION_DESC'      => 'Nota: La tarifa es un gasto fijo de manipulación para recoger y embalar su envío.',
    'TEXT_UPLOAD_BUTTON'         => 'Seleccionar archivo',
    'TEXT_UPLOAD_PROGRESS'       => 'Por favor, espere...',
    'TEXT_UPLOAD_SUCCESS'        => '¡El archivo se ha cargado correctamente!',
    'TEXT_UPLOAD_FAILURE'        => 'Se ha producido un error.',
    'TEXT_UPLOAD_COUNT_SINGULAR' => 'Archivo %s',
    'TEXT_UPLOAD_COUNT_PLURAL'   => 'Archivos %s',
];

foreach ($translations as $key => $value) {
    $constant = Constants::MODULE_NAME . '_' . $key;

    define($constant, $value);
}
