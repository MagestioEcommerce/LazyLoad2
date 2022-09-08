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
                $output = $this->addLazy($output);
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
     * @param $html
     * @return string
     */
    public function addLazy($html)
    {
        preg_match_all('/<img[^>]*src=\"([^\"]*)\"[^>]*>/is', $html, $matches);
        $replaced = [];
        $search   = [];
        foreach ($matches[0] as $img) {
            $strProcess = str_replace('<img', '<img loading="lazy"', $img);
            $replaced[] = $strProcess;
            $search[]   = $img;

        }
        return str_replace($search, $replaced, $html);
    }

}