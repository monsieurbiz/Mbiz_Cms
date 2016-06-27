<?php
/**
 * This file is part of Mbiz_Cms for Magento.
 *
 * @license All rights reserved
 * @author Jacques Bodin-Hullin <@jacquesbh> <j.bodinhullin@monsieurbiz.com>
 * @category Mbiz
 * @package Mbiz_Cms
 * @copyright Copyright (c) 2014 Monsieur Biz (http://monsieurbiz.com/)
 */

/**
 * Template_Filter Model
 * @package Mbiz_Cms
 */
class Mbiz_Cms_Model_Template_Filter extends Mage_Widget_Model_Template_Filter
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Product directive
     *
     * @param array $construction
     * @return string
     */
    public function productDirective($construction)
    {
        $params = $this->_getIncludeParameters($construction[2]);

        if (!$product = Mage::registry('current_product')) {
            $product = Mage::registry('product');
        }

        if (!$product || !$product->getId()) {
            return '';
        }

        $value = '';
        if (isset($params['var'])) {
            $value = $product->getDataUsingMethod($params['var']);
        } elseif (isset($params['attribute_set'])) {
            $value = Mage::helper('oop_catalog')->getProductAttributeSetName($product);
        }

        return $value;
    }

// Monsieur Biz Tag NEW_METHOD

}