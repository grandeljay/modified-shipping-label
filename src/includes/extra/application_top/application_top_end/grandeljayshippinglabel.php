<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

namespace Grandeljay\ShippingLabel;

require_once DIR_FS_CATALOG . 'includes/extra/functions/rth_modified_std_module.php';

if (rth_is_module_disabled(Constants::MODULE_NAME)) {
    return;
}

if (!isset($_SESSION['shipping']['id'])) {
    return;
}

if (\grandeljayshippinglabel::class . '_shippinglabel' !== $_SESSION['shipping']['id']) {
    return;
}

require_once DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/modules/shipping/grandeljayshippinglabel.php';

$filename                     = ltrim($_SERVER['SCRIPT_NAME'], '/');
$constant_shipping_text_title = Constants::MODULE_NAME . '_TEXT_TITLE';

switch ($filename) {
    case FILENAME_CHECKOUT_PAYMENT:
        if (!isset($_SESSION['grandeljay']['shipping-label']['labels'])) {
            unset($_SESSION['shipping']);
                    $messageStack->add('checkout_shipping', 'Shipping labels are missing');
        }
        break;
    case FILENAME_CHECKOUT_CONFIRMATION:
        $files_count      = count($_SESSION['grandeljay']['shipping-label']['labels']);
        $files_count_text = 1 === $files_count
                          ? \constant(Constants::MODULE_NAME . '_TEXT_UPLOAD_COUNT_SINGULAR')
                          : \constant(Constants::MODULE_NAME . '_TEXT_UPLOAD_COUNT_PLURAL');

        $_SESSION['shipping']['title'] = defined($constant_shipping_text_title)
                                       ? sprintf(
                                           '%s (%s)',
                                           constant($constant_shipping_text_title),
                                           \sprintf($files_count_text, $files_count)
                                       )
                                       : $constant_shipping_text_title;
        break;
}
