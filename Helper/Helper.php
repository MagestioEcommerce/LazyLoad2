<?php

namespace Magestio\LazyLoad2\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Helper
 * @package Magestio\LazyLoad2\Helper
 */
class Helper extends AbstractHelper
{

    const XML_PATH_ENABLED          = 'lazyload2/general/enabled';
    const XML_PATH_EXCLUDED_BLOCKS  = 'lazyload2/general/excluded_blocks';

    /**
     * If enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE);
    }


    /**
     * @return string
     */
    public function getExcludedBlocks()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_EXCLUDED_BLOCKS, ScopeInterface::SCOPE_STORE);
    }
}
