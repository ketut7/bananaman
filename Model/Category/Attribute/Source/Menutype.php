<?php
/**
 * Copyright © 2020 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Kemana
 * @package  Kemaa_Categoriesenhanced
 * @license  Proprietary
 *
 * @author   Gihan Kanchana <gkanchana@kemana.com>
 */

namespace Kemana\Categoriesenhanced\Model\Category\Attribute\Source;
/**
 * Class Menutype
 * @package Kemana\Categoriesenhanced\Model\Category\Attribute\Source
 */
class Menutype extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    protected $_options;

    /** load all the menu type options
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '0', 'label' => __('Wide Submenu')],
                ['value' => '1', 'label' => __('Default Dropdown')],
                ['value' => '2', 'label' => __('Fixed')],
                ['value' => '3', 'label' => __('Vertical Tabs Wide Submenu')],
                ['value' => '4', 'label' => __('Horizontal Tabs Wide Submenu')]
            ];
        }
        return $this->_options;
    }
}
