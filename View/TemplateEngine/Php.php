<?php

namespace Magestio\LazyLoad2\View\TemplateEngine;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\TemplateEngine\Php as PhpEngineBase;
use Magestio\LazyLoad2\Helper\Helper;

/**
 * Class Php
 * @package Magestio\LazyLoad2\View\TemplateEngine
 */
class Php extends PhpEngineBase
{

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var string
     */
    protected $lazyloadClass;

    /**
     * @var array
     */
    protected $excludedBlocks;

    /**
     * Php constructor.
     * @param ObjectManagerInterface $helperFactory
     * @param Helper $helper
     * @param array $blockVariables
     */
    public function __construct(
        ObjectManagerInterface $helperFactory,
        Helper $helper,
        array $blockVariables = []
    ) {
        parent::__construct($helperFactory,$blockVariables);
        $this->helper = $helper;
    }

    /**
     * Render output
     *
     * Include the named PHTML template using the given block as the $this
     * reference, though only public methods will be accessible.
     *
     * @param BlockInterface           $block
     * @param string                   $fileName
     * @param array                    $dictionary
     * @return string
     * @throws \Exception
     */
    public function render(BlockInterface $block, $fileName, array $dictionary = [])
    {
        $output = parent::render($block, $fileName, $dictionary);

        if ($this->helper->isEnabled()) {
            if (!in_array(get_class($block), $this->getExcludedBlocks())) {
                $output = $this->addLazyLoadClass($output);
            }

            if (get_class($block) == 'Magento\Wishlist\Block\Share\Email\Items\Interceptor') {
                $output = str_replace("data-src", "src", $output);
            }
        }

        return $output;
    }

    /**
     * @return array
     */
    protected function getExcludedBlocks()
    {
        if (!$this->excludedBlocks) {
            $this->excludedBlocks = explode(',', $this->helper->getExcludedBlocks());
        }
        return $this->excludedBlocks;
    }

    /**
     * @return string
     */
    protected function getLazyLoadClass()
    {
        if (!$this->lazyloadClass) {
            $this->lazyloadClass = $this->helper->getLazyLoadClass();
        }
        return $this->lazyloadClass;
    }

    /**
     * @param $html
     * @return string
     */
    public function addLazyLoadClass($html)
    {
        $class = $this->getLazyLoadClass();
        preg_match_all('/<img[^>]*src=\"([^\"]*)\"[^>]*>/is', $html, $matches);
        $replaced = [];
        $search   = [];
        foreach ($matches[0] as $img) {
            if (strpos($img, $class) !== false or strpos($img, 'data-src') !== false) {
                continue;
            }
            if (strpos($img, 'class="') !== false) {
                $newClass = str_replace('class="', 'class="' . $class . ' ', $img);
            } else {
                $newClass = str_replace('<img', '<img class="' . $class . '"', $img);
            }
            $strProcess = str_replace('src="', 'data-src="', $newClass);
            $replaced[] = $strProcess;
            $search[]   = $img;

        }
        return str_replace($search, $replaced, $html);
    }

}