<?php

/**
 * Shipping Label
 *
 * French translations
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

use Grandeljay\ShippingLabel\Constants;

$translations = [
    /** Module */
    'TITLE'                      => 'grandeljay - Versandlabel',
    'LONG_DESCRIPTION'           => 'Permet aux clients d\'utiliser leur propre étiquette d\'expédition dans le checkout.',
    'STATUS_TITLE'               => 'Statut',
    'STATUS_DESC'                => 'Sélectionnez Oui pour activer le module et Non pour le désactiver.',

    'ALLOWED_TITLE'              => '',
    'ALLOWED_DESC'               => '',
    'SORT_ORDER_TITLE'           => 'Ordre de tri',
    'SORT_ORDER_DESC'            => 'Détermine le tri dans Admin et Checkout. Les chiffres les plus bas sont affichés en premier.',
    'HANDLING_FEE_TITLE'         => 'Forfait de manutention',
    'HANDLING_FEE_DESC'          => 'Frais pour le prélèvement et l\'emballage de l\'envoi.',
    'PICK_PACK_TITLE'            => 'Pick & Pack',
    'PICK_PACK_DESC'             => 'Frais encourus pour la préparation et l\'emballage de la commande.',

    'TEXT_SHIPPING_LABEL'        => 'Étiquette d\'expédition',

    'TEXT_TITLE'                 => 'Envoi avec votre propre étiquette d\'expédition',
    'TEXT_TITLE_WEIGHT'          => 'Envoi avec votre propre étiquette d\'expédition (%s kg)',
    'TEXT_DESCRIPTION_TITLE'     => 'Téléchargez votre propre étiquette d\'expédition ici (%s maximum).',
    'TEXT_DESCRIPTION_DESC'      => 'Remarque : les frais s\'entendent comme un forfait de manutention pour le picking et l\'emballage de votre envoi.',
    'TEXT_UPLOAD_BUTTON'         => 'Sélectionner un fichier',
    'TEXT_UPLOAD_PROGRESS'       => 'Veuillez patienter...',
    'TEXT_UPLOAD_SUCCESS'        => 'Le fichier a été téléchargé avec succès !',
    'TEXT_UPLOAD_FAILURE'        => 'Une erreur est survenue.',
    'TEXT_UPLOAD_COUNT_SINGULAR' => 'Fichier %s',
    'TEXT_UPLOAD_COUNT_PLURAL'   => 'Fichiers %s',
];

foreach ($translations as $key => $value) {
    $constant = Constants::MODULE_NAME . '_' . $key;

    define($constant, $value);
}
