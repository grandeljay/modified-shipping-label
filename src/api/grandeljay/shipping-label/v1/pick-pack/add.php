<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

namespace Grandeljay\ShippingLabel;

chdir('../../../../..');

require 'includes/application_top.php';

if (rth_is_module_disabled(Constants::MODULE_NAME)) {
    http_response_code(403);

    return;
}

ob_start();
?>
<tr>
    <td><input type="number" step="any" data-name="weight"></td>
    <td><input type="number" step="any" data-name="costs"></td>
    <td>
        <button type="button" value="remove">
            <img src="images/icons/cross.gif">
        </button>
    </td>
</tr>
<?php

$response = ob_get_clean();

header('Content-Type: text/html');
echo $response;
