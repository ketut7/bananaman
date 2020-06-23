<?php

namespace Kemana\Categoriesenhanced\Helper;

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

use Magento\Framework\App\Config\ScopeConfigInterface;
use  Magento\Framework\App\Helper\Context;

/**
 * Class Data
 * @package Kemana\Categoriesenhanced\Helper
 */
class Data extends \Magento\Framework\Url\Helper\Data
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * @param $config_path
     * @return mixed
     */
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
