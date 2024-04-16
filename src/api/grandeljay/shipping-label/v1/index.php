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

$file_key = \grandeljayshippinglabel::class . '-shipping-label';

/**
 * Map upload information from `$_FILES` to a sane format.
 */
$files      = [];
$files_keys = [
    'name',
    'full_path',
    'type',
    'tmp_name',
    'error',
    'size',
];

foreach ($files_keys as $files_key) {
    foreach ($_FILES[$file_key][$files_key] as $key => $value) {
        $files[$key][$files_key] = $value;
    }
}

/**
 * Add file hash
 */
$files = \array_map(
    function (array $file) {
        $file['hash'] = \hash_file('crc32c', $file['tmp_name']);

        return $file;
    },
    $files
);

/**
 * Add file extension and destination
 */
$files = \array_map(
    function (array $file) {
        $file['extension']   = \strtolower(\pathinfo($file['name'], PATHINFO_EXTENSION));
        $file['destination'] = Constants::DIRECTORY_LABELS . '/' . $file['hash'] . '.' . $file['extension'];

        return $file;
    },
    $files
);

/**
 * Move file
 */
$files = \array_map(
    function (array $file) {
        $file['upload_successful'] = \move_uploaded_file($file['tmp_name'], $file['destination']);

        return $file;
    },
    $files
);

$_SESSION['grandeljay']['shipping-label']['labels'] = $files;

/**
 * Return results
 */
$response = [
    'labels' => $files,
];

header('Content-Type: application/json');

echo json_encode($response);
