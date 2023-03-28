<?php
namespace Perficient\FinancialAid\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        \Perficient\FinancialAid\Model\Config $financialAidConfig

    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->financialAidConfig = $financialAidConfig;
        $this->logger = $context->getLogger();
    }

    public function sendEmail($post)
    {
        try {
            $this->inlineTranslation->suspend();
            $emails=$this->financialAidConfig->getEmails();
            $sender = [
                'name' => $this->escaper->escapeHtml('Vista Higher Learning Support'),
                'email' => $this->escaper->escapeHtml('support@vistahigherlearning.zendesk.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('financial_aid_email')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'productname'  => $post['description'],
                    'isbn'  => $post['isbn'],
                    'price' => $post['price'],
                ])
                ->setFrom($sender)
                ->addTo(explode(',',$post['email']))

                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}