<?php

/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 *
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 * @phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
 */

use Grandeljay\ShippingLabel\Constants;
use RobinTheHood\ModifiedStdModule\Classes\StdModule;

class grandeljayshippinglabel extends StdModule
{
    public const VERSION = '0.3.2';

    /**
     * Keys to automatically add on __construct and to remove on remove.
     *
     * @var array
     */
    private array $autoKeys = array();

    /**
     * Used by modified to determine the cheapest shipping method. Should
     * contain the return value of the `quote` method.
     *
     * @var array
     */
    public array $quotes = array();

    public static function pickPack(string $configuration_value, string $configuration_key): string
    {
        ob_start();
        ?>
        <details>
            <summary>Pick & Pack</summary>

            <div>
                <textarea name="configuration[<?= $configuration_key ?>]" spellcheck="false" data-url="<?= Constants::API_ENDPOINT_PICK_PACK_GET ?>"><?= $configuration_value ?></textarea>
            </div>
        </details>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public function __construct()
    {
        parent::__construct(Constants::MODULE_NAME);

        $this->autoKeys[] = 'SORT_ORDER';
        $this->autoKeys[] = 'HANDLING_FEE';
        $this->autoKeys[] = 'PICK_PACK';

        foreach ($this->autoKeys as $key) {
            $this->addKey($key);
        }
    }

    public function install()
    {
        parent::install();

        $pickPack = json_encode(
            array(
                array(
                    'weight' => '1',
                    'costs'  => '1.3',
                ),
                array(
                    'weight' => '5',
                    'costs'  => '1.6',
                ),
                array(
                    'weight' => '10',
                    'costs'  => '2',
                ),
                array(
                    'weight' => '20',
                    'costs'  => '2.6',
                ),
                array(
                    'weight' => '60',
                    'costs'  => '3',
                ),
            )
        );

        $this->addConfiguration('ALLOWED', '', 6, 1);
        $this->addConfiguration('SORT_ORDER', 5, 6, 1);
        $this->addConfiguration('HANDLING_FEE', 1.60, 6, 1);
        $this->addConfiguration('PICK_PACK', $pickPack, 6, 1, self::class . '::pickPack(');
    }

    public function remove()
    {
        parent::remove();

        foreach ($this->autoKeys as $key) {
            $this->removeConfiguration($key);
        }
    }

    /**
     * Used by modified to show shipping costs. Will be ignored if the value is
     * not an array.
     *
     * @var ?array
     */
    public function quote(): ?array
    {
        global $shipping_weight;

        $upload_max_size         = ini_get('upload_max_filesize');
        $input_file_upload_label = sprintf(
            $this->getConfig('TEXT_DESCRIPTION_TITLE'),
            $upload_max_size
        );
        $language_current        = $_SESSION['language_code'] ?? 'de';

        if ('de' !== $language_current) {
            return null;
        }

        ob_start();
        ?>
        <div class="grandeljay">
            <div class="upload-file">
                <?= $input_file_upload_label ?><br /><br />
                <?= $this->getConfig('TEXT_DESCRIPTION_DESC') ?><br />

                <label>
                    <input type="file" name="<?= self::class . '-shipping-label' ?>" accept="application/pdf" />

                    <?php if (isset($_SESSION['grandeljay']['shipping-label']['label'])) { ?>
                        <span class="text-upload hide"><?= $this->getConfig('TEXT_UPLOAD_BUTTON') ?></span>
                        <span class="text-progress hide"><?= $this->getConfig('TEXT_UPLOAD_PROGRESS') ?></span>
                        <span class="text-success">
                            <?= $_SESSION['grandeljay']['shipping-label']['label']['name'] ?>
                        </span>
                    <?php } else { ?>
                        <span class="text-upload"><?= $this->getConfig('TEXT_UPLOAD_BUTTON') ?></span>
                        <span class="text-progress hide"><?= $this->getConfig('TEXT_UPLOAD_PROGRESS') ?></span>
                        <span class="text-success hide"><?= $this->getConfig('TEXT_UPLOAD_SUCCESS') ?></span>
                    <?php } ?>
                </label>
            </div>
        </div>
        <?php
        $title_html = trim(ob_get_clean());

        $method_shipping_label_costs = $this->getConfig('HANDLING_FEE');

        $pick_pack_json    = $this->getConfig('PICK_PACK');
        $pick_pack_entries = json_decode($pick_pack_json, true);

        usort(
            $pick_pack_entries,
            function ($entry_a, $entry_b) {
                return $entry_a['weight'] <=> $entry_b['weight'];
            }
        );

        foreach ($pick_pack_entries as $entry) {
            if ($shipping_weight <= $entry['weight']) {
                $method_shipping_label_costs += $entry['costs'];

                break;
            }
        }

        $method_shipping_label = array(
            'id'    => 'shippinglabel',
            'title' => $title_html,
            'cost'  => $method_shipping_label_costs,
        );
        $methods               = array(
            $method_shipping_label,
        );
        $quote                 = array(
            'id'      => self::class,
            'module'  => constant(Constants::MODULE_NAME . '_TEXT_TITLE'),
            'methods' => $methods,
        );

        if (isset($quote['methods']) && count($quote['methods']) > 0) {
            $this->quotes = $quote;
        }

        return $quote;
    }

    /**
     * Do not automatically select this method as the cheapest.
     *
     * @return bool
     */
    // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function ignore_cheapest(): bool
    {
        return true;
    }
}
