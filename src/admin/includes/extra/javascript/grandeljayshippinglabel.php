<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

namespace Grandeljay\ShippingLabel;

if (rth_is_module_disabled(Constants::MODULE_NAME)) {
    return;
}

/** Only enqueue JavaScript when module settings are open */
$grandeljayshippinglabel_admin_screen = [
    'set'    => 'shipping',
    'module' => \grandeljayshippinglabel::class,
    'action' => 'edit',
];

parse_str($_SERVER['QUERY_STRING'] ?? '', $query_string);

foreach ($grandeljayshippinglabel_admin_screen as $key => $value) {
    if (!isset($query_string[$key]) || $query_string[$key] !== $value) {
        return;
    }
}

$file['name'] = '/' . DIR_ADMIN . 'includes/javascript/grandeljayshippinglabel.js';
$file_path    = DIR_FS_CATALOG .  $file['name'];
$file_version = hash_file('crc32c', $file_path);
$file_url     = $file['name'] . '?v=' . $file_version;
?>
<script type="text/javascript" src="<?= $file_url ?>" defer></script>
