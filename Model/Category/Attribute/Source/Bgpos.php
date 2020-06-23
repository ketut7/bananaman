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
 * Class Bgpos
 * @package Kemana\Categoriesenhanced\Model\Category\Attribute\Source
 */
class Bgpos extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    protected $_options;

    /** load the all background positions
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '1', 'label' => __('Left')],
                ['value' => '2', 'label' => __('Right')],
                ['value' => '3', 'label' => __('Center')],
                ['value' => '4', 'label' => __('Fill with stretching')]
            ];
        }
        return $this->_options;
    }
}
