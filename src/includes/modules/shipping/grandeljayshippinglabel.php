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
    public const VERSION = '0.5.0';

    /**
     * Keys to automatically add on __construct and to remove on remove.
     *
     * @var array
     */
    private array $autoKeys = [];

    /**
     * Used by modified to determine the cheapest shipping method. Should
     * contain the return value of the `quote` method.
     *
     * @var array
     */
    public array $quotes = [];

    /**
     * Used to calculate the tax.
     *
     * @var int
     */
    public int $tax_class = 1;

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

        $this->checkForUpdate(true);
    }

    protected function updateSteps(): int
    {
        if (version_compare($this->getVersion(), self::VERSION, '<')) {
            $this->setVersion(self::VERSION);

            return self::UPDATE_SUCCESS;
        }

        return self::UPDATE_NOTHING;
    }

    public function install(): void
    {
        parent::install();

        $pickPack = json_encode(
            [
                [
                    'weight' => '1',
                    'costs'  => '1.3',
                ],
                [
                    'weight' => '5',
                    'costs'  => '1.6',
                ],
                [
                    'weight' => '10',
                    'costs'  => '2',
                ],
                [
                    'weight' => '20',
                    'costs'  => '2.6',
                ],
                [
                    'weight' => '60',
                    'costs'  => '3',
                ],
            ]
        );

        $this->addConfiguration('ALLOWED', '', 6, 1);
        $this->addConfiguration('SORT_ORDER', 5, 6, 1);
        $this->addConfiguration('HANDLING_FEE', 1.60, 6, 1);
        $this->addConfiguration('PICK_PACK', $pickPack, 6, 1, self::class . '::pickPack(');

        xtc_db_query(
            sprintf(
                'CREATE TABLE IF NOT EXISTS `%s` (
                    `order_id`   INT      UNSIGNED     NULL DEFAULT NULL,
                    `filename`   TINYTEXT          NOT NULL,
                    `filehash`   TINYTEXT          NOT NULL,
                    `uploaded`   DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                    INDEX `idx_order_id` (`order_id`)
                )',
                Constants::TABLE_LABELS
            )
        );
    }

    public function remove(): void
    {
        parent::remove();

        foreach ($this->autoKeys as $key) {
            $this->removeConfiguration($key);
        }

        xtc_db_query(
            sprintf(
                'DROP TABLE IF EXISTS `%s`',
                Constants::TABLE_LABELS
            )
        );
    }

    private function getShippingWeight(): float
    {
        global $order;

        $shipping_weight = 0;

        foreach ($order->products as $product) {
            $length = $product['length'] ?? 0;
            $width  = $product['width']  ?? 0;
            $height = $product['height'] ?? 0;
            $weight = $product['weight'] ?? 0;

            if ($length > 0 && $width > 0 && $height > 0) {
                $volumetric_weight = ($length * $width * $height) / 5000;

                if ($volumetric_weight > $weight) {
                    $weight = $volumetric_weight;
                }
            }

            $shipping_weight += $weight * $product['quantity'];
        }

        return $shipping_weight;
    }

    /**
     * Used by modified to show shipping costs. Will be ignored if the value is
     * not an array.
     *
     * @var ?array
     */
    public function quote(): ?array
    {
        $upload_max_size         = ini_get('upload_max_filesize');
        $input_file_upload_label = sprintf(
            $this->getConfig('TEXT_DESCRIPTION_TITLE'),
            $upload_max_size
        );
        $language_current        = $_SESSION['language_code'] ?? 'de';

        if ('de' !== $language_current) {
            return null;
        }

        $shipping_weight = $this->getShippingWeight();

        ob_start();
        ?>
        <div class="grandeljay">
            <div class="upload-file">
                <?= $input_file_upload_label ?><br /><br />
                <?= $this->getConfig('TEXT_DESCRIPTION_DESC') ?><br />

                <label>
                    <input type="file" name="<?= self::class . '-shipping-label' ?>[]" accept="application/pdf" multiple="true" />

                    <?php if (isset($_SESSION['grandeljay']['shipping-label']['labels'])) { ?>
                        <span class="text-upload hide"><?= $this->getConfig('TEXT_UPLOAD_BUTTON') ?></span>
                        <span class="text-progress hide"><?= $this->getConfig('TEXT_UPLOAD_PROGRESS') ?></span>
                        <span class="text-success">
                            <?php foreach ($_SESSION['grandeljay']['shipping-label']['labels'] as $file) { ?>
                                <?= $file['name'] ?><br>
                            <?php } ?>
                        </span>
                    <?php } else { ?>
                        <span class="text-upload"><?= $this->getConfig('TEXT_UPLOAD_BUTTON') ?></span>
                        <span class="text-progress hide"><?= $this->getConfig('TEXT_UPLOAD_PROGRESS') ?></span>
                        <span class="text-success hide"><?= $this->getConfig('TEXT_UPLOAD_SUCCESS') ?></span>
                        <span class="text-failure hide"><?= $this->getConfig('TEXT_UPLOAD_FAILURE') ?></span>
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

        $method_shipping_label = [
            'id'    => 'shippinglabel',
            'title' => $title_html,
            'cost'  => $method_shipping_label_costs,
        ];
        $methods               = [
            $method_shipping_label,
        ];
        $quote                 = [
            'id'      => self::class,
            'module'  => sprintf(
                constant(Constants::MODULE_NAME . '_TEXT_TITLE_WEIGHT'),
                round($shipping_weight, 2)
            ),
            'methods' => $methods,
        ];

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
