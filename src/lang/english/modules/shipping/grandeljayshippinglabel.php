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
    'LONG_DESCRIPTION'       => 'Allows customers to use their own shipping label in the checkout.',
    'STATUS_TITLE'           => 'Status',
    'STATUS_DESC'            => 'Select Yes to activate the module and No to deactivate it.',

    'ALLOWED_TITLE'          => '',
    'ALLOWED_DESC'           => '',
    'HANDLING_FEE_TITLE'     => 'Handling flat rate',
    'HANDLING_FEE_DESC'      => 'Fee for picking and packing the consignment.',
    'PICK_PACK_TITLE'        => 'Pick & Pack',
    'PICK_PACK_DESC'         => 'Costs incurred in assembling and packing the order.',

    'TEXT_SHIPPING_LABEL'    => 'Shipping label',

    'TEXT_TITLE'             => 'Shipping with own shipping label',
    'TEXT_DESCRIPTION_TITLE' => 'Upload your own shipping label here (maximum %s).',
    'TEXT_DESCRIPTION_DESC'  => 'Note: The fee is a flat handling charge for picking and packing your shipment.',
    'TEXT_UPLOAD_BUTTON'     => 'Select file',
    'TEXT_UPLOAD_PROGRESS'   => 'Please wait...',
    'TEXT_UPLOAD_SUCCESS'    => 'The file has been uploaded successfully!',
);

foreach ($translations as $key => $value) {
    $constant = Constants::MODULE_NAME . '_' . $key;

    define($constant, $value);
}
