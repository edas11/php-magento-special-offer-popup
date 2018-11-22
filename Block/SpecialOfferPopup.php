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

class SpecialOfferPopup extends Template
{
    private $popupConfig;
    private $logger;

    private static $defaulContent = 'g';
    private static $defaultDisplayTime = 1000;

    public function __construct(
        Context $context,
        PopupConfig $popupConfig,
        Logger $logger,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->popupConfig = $popupConfig;
        $this->logger = $logger;
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

    public function getDisplayTimeMilliseconds(): int
    {
        try {
            $displayTimeSeconds = $this->popupConfig->getPopupDisplayTimeSeconds();
            $displayTimeMilliseconds = $this->secondsToMilliseconds($displayTimeSeconds);
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getMessage());
            $displayTimeMilliseconds = self::$defaultDisplayTime;
        }
        return (int) $displayTimeMilliseconds;
    }

    private function secondsToMilliseconds($seconds)
    {
        return 1000*$seconds;
    }
}