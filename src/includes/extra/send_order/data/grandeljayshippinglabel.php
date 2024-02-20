<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

namespace Grandeljay\ShippingLabel;

$shipping_method = $_SESSION['shipping']['id'] ?? '';

if (\rth_is_module_disabled(Constants::MODULE_NAME) || 'grandeljayshippinglabel_shippinglabel' !== $shipping_method) {
    return;
}

$language_file = DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/modules/shipping/grandeljayshippinglabel.php';

require_once $language_file;

$filepath  = $_SESSION['grandeljay']['shipping-label']['label']['file_destination'];
$directory = \dirname($filepath);
$filename  = $order->info['orders_id'] . '.pdf';
$url       = \str_replace(DIR_FS_CATALOG, HTTPS_SERVER . '/', $directory . '/' . $filename);
$link      = '<a href="' . $url . '">' . \constant(Constants::MODULE_NAME . '_TEXT_TITLE') . '</a>';

$smarty->assign('SHIPPING_METHOD', $link);
