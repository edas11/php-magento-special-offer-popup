<?php
/**
 * Created by PhpStorm.
 * User: edvardas
 * Date: 18.11.22
 * Time: 09.46
 */
declare(strict_types=1);

namespace Edvardas\Special\Block;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class SpecialOfferPopup extends Template
{
    private $blockRepository;
    private $scopeConfig;
    private $storeManager;

    public function __construct(
        Context $context,
        BlockRepositoryInterface $blockRepository,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->blockRepository = $blockRepository;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }


    public function getContent(): string
    {
        try {
            $specialOfferBlockId = $this->scopeConfig->getValue(
                'specialOfferModuleConfig/general/popupBlock',
                ScopeInterface::SCOPE_STORE,
                $this->storeManager->getStore()->getId()
            );
            $block = $this->blockRepository->getById($specialOfferBlockId);
            $content = $block->getContent();
        } catch (LocalizedException $exception) {
            $content = '';
        }
        return $content;
    }

    public function getDisplayTime(): int
    {
        try {
            $displayTimeSeconds = $this->scopeConfig->getValue(
                'specialOfferModuleConfig/general/popupTime',
                ScopeInterface::SCOPE_STORE,
                $this->storeManager->getStore()->getId()
            );
            $displayTimeMilliseconds = (int) 1000*$displayTimeSeconds;
        } catch (LocalizedException $exception) {
            $displayTimeMilliseconds = 2000;
        }
        return $displayTimeMilliseconds;
    }
}