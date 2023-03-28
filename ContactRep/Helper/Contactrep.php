<?php

declare(strict_types=1);

namespace Perficient\ContactRep\Helper;

/**
 * Class Contactrep
 * @package Perficient\ContactRep\Helper
 */
class Contactrep
{

    /**
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return bool
     */
    public function getContactRep(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        $contactrep = $product->getCustomAttribute('contactrep');
        if (isset($contactrep)) {
            return (bool)$contactrep->getValue();
        }
        return false;
    }
}
