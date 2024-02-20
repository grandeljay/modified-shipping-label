<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

namespace Grandeljay\ShippingLabel;

chdir('../../../../');

require 'includes/application_top.php';

if (rth_is_module_disabled(Constants::MODULE_NAME)) {
    http_response_code(403);
    return;
}

$file_key               = \grandeljayshippinglabel::class . '-shipping-label';
$file                   = $_FILES[$file_key];
$file_hash              = \hash_file('crc32c', $file['tmp_name']);
$file_extension         = \strtolower(\pathinfo($file['name'], PATHINFO_EXTENSION));
$file_destination       = Constants::DIRECTORY_LABELS . '/' . $file_hash . '.' . $file_extension;
$file_upload_successful = \move_uploaded_file($file['tmp_name'], $file_destination);

$response = [
    'name' => $file['name'],
];

if (!$file_upload_successful) {
    http_response_code(500);
    $response['error'] = 'File upload failed.';
}

$_SESSION['grandeljay']['shipping-label']['label'] = [
    'file_destination' => $file_destination,
    'name'             => $file['name'],
];

header('Content-Type: application/json');

echo json_encode($response);
