<?php

namespace Grandeljay\ShippingLabel;

class Constants
{
    public const MODULE_NAME = 'MODULE_SHIPPING_GRANDELJAYSHIPPINGLABEL';

    public const DIRECTORY_LABELS = DIR_FS_EXTERNAL . 'grandeljay/shipping-label/labels';

    public const API_ENDPOINT               = HTTPS_SERVER . '/api/grandeljay/shipping-label/v1';
    public const API_ENDPOINT_PICK_PACK     = self::API_ENDPOINT . '/pick-pack';
    public const API_ENDPOINT_PICK_PACK_ADD = self::API_ENDPOINT_PICK_PACK . '/add.php';
    public const API_ENDPOINT_PICK_PACK_GET = self::API_ENDPOINT_PICK_PACK . '/get.php';
}
