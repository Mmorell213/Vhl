<?php

namespace Perficient\DigitalRequest\Block;

use Magento\Framework\View\Element\Template;

class Product extends \Magento\Framework\View\Element\Template
{
    protected $_productRepository;
    protected $request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\App\Request\Http $request,
        array $data = []
    )
    {
        $this->_productRepository = $productRepository;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    public function getProductById()
    {
        $id=$this->request->getParam('id');
        return $this->_productRepository->getById($id);
    }
}
