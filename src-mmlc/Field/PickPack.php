<?php

namespace Grandeljay\ShippingLabel\Field;

use Grandeljay\ShippingLabel\Constants;

class PickPack
{
    public static function getPickPack(string $option): string
    {
        ob_start();
        ?>
        <details>
            <summary>Pick & Pack</summary>

            <div>
                <?php
                $configuration_key   = $option;
                $configuration_value = constant($configuration_key);
                ?>
                <textarea name="configuration[<?= $configuration_key ?>]" spellcheck="false" data-url="<?= Constants::API_ENDPOINT_PICK_PACK_GET ?>"><?= $configuration_value ?></textarea>
            </div>
        </details>
        <?php
        return ob_get_clean();
    }
}
