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
    public const VERSION = '0.1.0';

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

    public function __construct()
    {
        parent::__construct(Constants::MODULE_NAME);

        $this->autoKeys[] = 'HANDLING_FEE';

        foreach ($this->autoKeys as $key) {
            $this->addKey($key);
        }

        $this->quotes = $this->quote();
    }

    public function install()
    {
        parent::install();

        $this->addConfiguration('ALLOWED', '', 6, 1);
        $this->addConfiguration('HANDLING_FEE', 1.60, 6, 1);
    }

    public function remove()
    {
        parent::remove();

        foreach ($this->autoKeys as $key) {
            $this->removeConfiguration($key);
        }
    }

    public function quote(): array
    {
        $upload_max_size         = ini_get('upload_max_filesize');
        $input_file_upload_label = sprintf(
            $this->getConfig('TEXT_DESCRIPTION_TITLE'),
            $upload_max_size
        );

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

        $method_shipping_label = array(
            'id'    => 'shippinglabel',
            'title' => $title_html,
            'cost'  => $this->getConfig('HANDLING_FEE'),
        );
        $methods               = array(
            $method_shipping_label,
        );
        $quote                 = array(
            'id'      => self::class,
            'module'  => constant(Constants::MODULE_NAME . '_TEXT_TITLE'),
            'methods' => $methods,
        );

        return $quote;
    }
}
