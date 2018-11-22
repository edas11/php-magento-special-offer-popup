<?php
/**
 * Created by PhpStorm.
 * User: edvardas
 * Date: 18.11.22
 * Time: 09.46
 */
declare(strict_types=1);

namespace Edvardas\Special\Block;

use Edvardas\Special\Logger\Logger;
use Edvardas\Special\Model\Config\PopupConfig;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Theme\Block\Html\Header\Logo;

class SpecialOfferPopup extends Template
{
    private $popupConfig;
    private $logger;
    private $logoBlock;

    private static $defaulContent = '';
    private static $defaultDisplayTime = 1000;

    public function __construct(
        Context $context,
        PopupConfig $popupConfig,
        Logger $logger,
        Logo $logoBlock,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->popupConfig = $popupConfig;
        $this->logger = $logger;
        $this->logoBlock = $logoBlock;
    }

    public function shouldShowPopup(): bool
    {
        try {
            return $this->logoBlock->isHomePage() && $this->popupConfig->isModuleEnabled();
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getMessage());
            return false;
        }
    }

    public function getSpecialOfferBlockContent(): string
    {
        try {
            $specialOfferBlockId = $this->popupConfig->getSpecialOfferBlockId();
            $block = $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId($specialOfferBlockId);
            $content = $block->toHtml();
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getMessage());
            $content = self::$defaulContent;
        }
        return (string) $content;
    }

    public function getPopupTimeoutMilliseconds(): int
    {
        try {
            $timeoutSeconds = $this->popupConfig->getPopupTimeoutSeconds();
            $timeoutMilliseconds = $this->secondsToMilliseconds($timeoutSeconds);
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getMessage());
            $timeoutMilliseconds = self::$defaultDisplayTime;
        }
        return (int) $timeoutMilliseconds;
    }

    private function secondsToMilliseconds($seconds)
    {
        return 1000*$seconds;
    }
}