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
 * Class Customlabel
 * @package Kemana\Categoriesenhanced\Model\Category\Attribute\Source
 */
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Customlabel extends AbstractSource
{

    protected $_options;

    /** load all custom label values
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '',            'label' => __('No label')],
                ['value' => 'label-one',   'label' => __('Label #1')],
                ['value' => 'label-two',   'label' => __('Label #2')],
                ['value' => 'label-three', 'label' => __('Label #3')]
            ];
        }
        return $this->_options;
    }
}
