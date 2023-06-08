<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

namespace Grandeljay\ShippingLabel;

if (rth_is_module_disabled(Constants::MODULE_NAME) || \grandeljayshippinglabel::class . '_shippinglabel' !== $order->info['shipping_class']) {
    return;
}

$label_relative = 'grandeljay/shipping-label/labels/' . $order->info['orders_id'] . '.pdf';
$label_filepath = DIR_FS_EXTERNAL . $label_relative;
$label_filename = pathinfo($label_filepath, PATHINFO_BASENAME);
$label_href     = rtrim(HTTPS_SERVER, '/') . DIR_WS_EXTERNAL . $label_relative;
?>
<div class="heading">
    <?= constant(Constants::MODULE_NAME . '_TEXT_TITLE') ?>:
</div>

<table class="table borderall" cellspacing="0" cellpadding="5">
    <tbody>
        <tr>
            <td class="smallText">
                <strong><?= constant(Constants::MODULE_NAME . '_TEXT_SHIPPING_LABEL') ?></strong>
            </td>
        </tr>
        <tr>
            <td class="smallText">
                <ul>
                    <li><a href="<?= $label_href ?>"><?= $label_filename ?></a></li>
                </ul>
            </td>
        </tr>
    </tbody>
</table>

<?php
