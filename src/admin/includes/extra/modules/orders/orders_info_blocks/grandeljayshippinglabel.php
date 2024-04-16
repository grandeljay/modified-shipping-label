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

$labels_query = \xtc_db_query(
    sprintf(
        'SELECT *
           FROM `%s`
          WHERE `order_id` = %d',
        Constants::TABLE_LABELS,
        $order->info['orders_id']
    )
);
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
                    <?php
                    while ($label_data = \xtc_db_fetch_array($labels_query)) {
                        $url = \str_replace(\DIR_FS_CATALOG, \HTTPS_SERVER . '/', $label_data['filename']);

                        ?>
                        <li><a href="<?= $url ?>"><?= \pathinfo($label_data['filename'], \PATHINFO_BASENAME) ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
            </td>
        </tr>
    </tbody>
</table>

<?php
