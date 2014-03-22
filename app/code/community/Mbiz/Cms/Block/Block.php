<?php
/**
 * This file is part of Mbiz_Cms for Magento.
 *
 * @license All rights reserved
 * @author Jacques Bodin-Hullin <@jacquesbh> <j.bodinhullin@monsieurbiz.com>
 * @category Mbiz
 * @package Mbiz_Cms
 * @copyright Copyright (c) 2013 Monsieur Biz (http://monsieurbiz.com/)
 */

/**
 * Block Block
 * @package Mbiz_Cms
 *
 * @method string|int getBlockId() Retrieve the block id to load
 * @method Mbiz_Cms_Block_Block setBlockId(string|int $blockId) Set the block id to load
 */
class Mbiz_Cms_Block_Block extends Mage_Core_Block_Template
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Retrieve the cache key info
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
            'block_id'       => Mage_Cms_Model_Block::CACHE_TAG . '_' . $this->getBlockId(),
            'store'          => Mage::app()->getStore()->getId(),
            'design_package' => Mage::getDesign()->getPackageName(),
            'design_theme'   => Mage::getDesign()->getTheme('template'),
            'template'       => $this->getTemplate()
        );
    }

    /**
     * Retrieve the cache tags
     * @return array
     */
    public function getCacheTags()
    {
        $tags = parent::getCacheTags();
        array_push(
            $tags,
            //Mage_Cms_Model_Block::CACHE_TAG,
            Mage_Cms_Model_Block::CACHE_TAG . '_' . $this->getBlock()->getId()
        );

        return $tags;
    }

    /**
     * Retrieve the cache lifetime
     * @return int
     */
    public function getCacheLifetime()
    {
        return 5 * 24 * 3600; // 5 days
    }

    /**
     * Retrieve the block
     * @return Mage_Cms_Model_Block
     */
    public function getBlock()
    {
        // No block? Get it
        if (!$block = $this->getData('block')) {
            $block = Mage::getModel('cms/block')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($this->getBlockId());
            $this->setData('block', $block);
        }
        return $block;
    }

    /**
     * Retrieve the block content as HTML
     * @return string
     */
    public function getContentAsHtml()
    {
        // no content?
        if (!$html = $this->getData('content_as_html')) {
            $helper = Mage::helper('cms');
            $processor = $helper->getBlockTemplateProcessor();
            $html = $processor->filter($this->getBlock()->getContent());
            $this->setData('content_as_html', $html);
        }
        return $html;
    }

    /**
     * Prepare Content HTML
     * @return string
     */
    protected function _toHtml()
    {
        $html = '';
        $blockId = $this->getBlockId();

        if ($blockId) {
            $block = $this->getBlock();
            if ($block->getIsActive()) {

                /* @var $helper Mage_Cms_Helper_Data */
                $html = $this->getContentAsHtml();
                $this->addModelTags($block);
            }
        }

        if ($this->getTemplate()) {
            $this->setContent($html);
            return parent::_toHtml();
        }

        return $html;
    }

// Monsieur Biz Tag NEW_METHOD

}
