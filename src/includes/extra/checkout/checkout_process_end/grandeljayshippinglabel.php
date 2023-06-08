<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

namespace Grandeljay\ShippingLabel;

$filepath_uploaded           = $_SESSION['grandeljay']['shipping-label']['label']['file_destination'];
$filepath_uploaded_extension = pathinfo($filepath_uploaded, PATHINFO_EXTENSION);
$filepath_uploaded_final     = Constants::DIRECTORY_LABELS . '/' . $last_order . '.' . $filepath_uploaded_extension;

rename($filepath_uploaded, $filepath_uploaded_final);

unset($_SESSION['grandeljay']['shipping-label']['label']);
