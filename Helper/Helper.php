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
    const XML_PATH_LAZYLOAD_CLASS   = 'lazyload2/general/lazyload_class';
    const XML_PATH_EXCLUDED_BLOCKS  = 'lazyload2/general/excluded_blocks';

    const DEFAULT_IMAGE      = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

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
    public function getLazyLoadClass()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_LAZYLOAD_CLASS, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getExcludedBlocks()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_EXCLUDED_BLOCKS, ScopeInterface::SCOPE_STORE);
    }

}
