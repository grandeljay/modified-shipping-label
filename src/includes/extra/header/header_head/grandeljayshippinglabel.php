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

$filename_css = sprintf('templates/%s/css/grandeljayshippinglabel.css', CURRENT_TEMPLATE);
$version_css  = hash_file('crc32c', DIR_FS_CATALOG . $filename_css);

$filename_js = sprintf('templates/%s/javascript/grandeljayshippinglabel.js', CURRENT_TEMPLATE);
$version_js  = hash_file('crc32c', DIR_FS_CATALOG . $filename_js);
?>
<link rel="stylesheet" href="<?= $filename_css ?>?v=<?php echo $version_css ?>" />
<script defer src="<?= $filename_js ?>?v=<?php echo $version_js ?>"></script>
