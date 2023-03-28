<?php

declare(strict_types=1);

namespace Perficient\ContactRep\Block;

/**
 * Class ContactRep
 * @package Perficient\ContactRep\Block\ContactRep
 */
class ContactRep extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Perficient\ContactRep\Helper\Contactrep $contactRep
     */
    private $contactRep;

    /**
     * BookAlert constructor.
     * @param \Perficient\ContactRep\Helper\Contactrep $contactRep
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Perficient\ContactRep\Helper\Contactrep $contactRep,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->contactRep = $contactRep;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function getContactRep()
    {
        $product = $this->getCurrentProduct();
        return $this->contactRep->getContactRep($product);
    }

    /**
     * @return bool
     */
    public function hasContents()
    {
        return $this->getContactRep();
    }

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }
}
