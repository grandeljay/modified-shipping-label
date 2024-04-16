<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

namespace Grandeljay\ShippingLabel;

if (\rth_is_module_disabled(Constants::MODULE_NAME)) {
    return;
}

foreach ($_SESSION['grandeljay']['shipping-label']['labels'] as $label) {
    $label_filepath_current = $label['destination'];
    $label_filepath_new     = \sprintf(
        '%s/%d-%s.%s',
        Constants::DIRECTORY_LABELS,
        $last_order,
        $label['hash'],
        \pathinfo($label['destination'], \PATHINFO_EXTENSION)
    );

    $success = rename($label_filepath_current, $label_filepath_new);

    if (!$success) {
        continue;
    }

    \xtc_db_perform(
        Constants::TABLE_LABELS,
        [
            'order_id' => $last_order,
            'filename' => $label_filepath_new,
            'filehash' => $label['hash'],
        ]
    );
}

unset($_SESSION['grandeljay']['shipping-label']['labels']);
