<?php
/**
 * Created by PhpStorm.
 * User: edvardas
 * Date: 18.11.22
 * Time: 11.21
 */
declare(strict_types=1);

namespace Edvardas\Special\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class PopupConfig
{
    private $scopeConfig;
    private $storeManager;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function getSpecialOfferBlockId(): string
    {
        return (string) $this->scopeConfig->getValue(
            'specialOfferModuleConfig/general/popupBlock',
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

    public function getPopupTimeoutSeconds(): float
    {
        return (float) $this->scopeConfig->getValue(
            'specialOfferModuleConfig/general/popupTime',
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }
}