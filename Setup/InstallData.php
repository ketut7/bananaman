<?php
/**
 * Copyright © 2020 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Kemana
 * @package  Kemana_Categoriesenhanced
 * @license  Proprietary
 *
 * @author   Gihan Kanchana <gkanchana@kemana.com>
 */

namespace  Kemana\CategoriesEnhanced\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;

/**
 * Class InstallData
 * @package Kemana\CategoriesEnhanced\Setup
 * create the attributes for store the menu data
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_max_quantity',
            [
                'type'                     => 'text',
                'label'                    => 'Max. Quantity of categories in 1 row:',
                'input'                    => 'text',
                'required'                 => false,
                'sort_order'               => 1,
                'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled'          => false,
                'is_html_allowed_on_front' => false,
                'group'                    => 'Kemana/Categoriesenhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_ratio',
            [
                'type'          => 'varchar',
                'label'         => 'Ratio',
                'input'         => 'select',
                'required'      => false,
                'source'        => 'Kemana\Categoriesenhanced\Model\Category\Attribute\Source\Ratio',
                'sort_order'    => 2,
                'global'        => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'         => 'Kemana/Categoriesenhanced',
                'default'       => '',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_bg',
            [
                'type'       => 'varchar',
                'label'      => 'Upload your top level category background image',
                'input'      => 'image',
                'required'   => false,
                'backend'    => \Magento\Catalog\Model\Category\Attribute\Backend\Image::class,
                'sort_order' => 3,
                'global'     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'      => 'Kemana/Categoriesenhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_bg_option',
            [
                'type'       => 'varchar',
                'label'      => 'Ratio',
                'input'      => 'select',
                'required'   => false,
                'source'     => 'Kemana\Categoriesenhanced\Model\Category\Attribute\Source\Bgpos',
                'sort_order' => 4,
                'global'     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'      => 'Kemana/Categoriesenhanced',
                'default'    => '',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_block_right',
            [
                'type'                     => 'text',
                'label'                    => 'Right Content',
                'input'                    => 'textarea',
                'required'                 => false,
                'sort_order'               => 8,
                'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled'          => true,
                'is_html_allowed_on_front' => true,
                'group'                    => 'Kemana/Categoriesenhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_block_bottom',
            [
                'type'                     => 'text',
                'label'                    => 'Top Content',
                'input'                    => 'textarea',
                'required'                 => false,
                'sort_order'               => 9,
                'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled'          => true,
                'is_html_allowed_on_front' => true,
                'group'                    => 'Kemana/Categoriesenhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_block_top',
            [
                'type'                     => 'text',
                'label'                    => 'Bottom Content',
                'input'                    => 'textarea',
                'required'                 => false,
                'sort_order'               => 10,
                'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled'          => true,
                'is_html_allowed_on_front' => true,
                'group'                    => 'Kemana/Categoriesenhanced',
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_custom_link',
            [
                'type'                     => 'text',
                'label'                    => 'Custom link',
                'input'                    => 'text',
                'required'                 => false,
                'sort_order'               => 5,
                'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled'          => false,
                'is_html_allowed_on_front' => false,
                'group'                    => 'Kemana/Categoriesenhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_custom_link_target',
            [
                'type'       => 'int',
                'label'      => 'Link target blank',
                'input'      => 'select',
                'required'   => false,
                'source'     => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'sort_order' => 6,
                'global'     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'      => 'Kemana/Categoriesenhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_customlabel',
            [
                'type'       => 'varchar',
                'label'      => 'Category Label',
                'input'      => 'select',
                'required'   => false,
                'source'     => 'Kemana\Categoriesenhanced\Model\Category\Attribute\Source\Customlabel',
                'sort_order' => 7,
                'global'     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'      => 'Kemana/Categoriesenhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_labeltext',
            [
                'type'                     => 'text',
                'label'                    => 'Label Text',
                'input'                    => 'text',
                'required'                 => false,
                'sort_order'               => 8,
                'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled'          => false,
                'is_html_allowed_on_front' => false,
                'group'                    => 'Kemana/Categoriesenhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_menutype',
            [
                'type'       => 'varchar',
                'label'      => 'Top Level Dropdown Menu Type',
                'input'      => 'select',
                'required'   => false,
                'source'     => 'Kemana\Categoriesenhanced\Model\Category\Attribute\Source\Menutype',
                'sort_order' => 9,
                'global'     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'      => 'Kemana/CategoriesEnhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_menu_width',
            [
                'type'                     => 'text',
                'label'                    => 'Top Level Dropdown Menu Width',
                'input'                    => 'text',
                'required'                 => false,
                'sort_order'               => 10,
                'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled'          => false,
                'is_html_allowed_on_front' => false,
                'group'                    => 'Kemana/CategoriesEnhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_subcontent',
            [
                'type'                     => 'text',
                'label'                    => 'Custom Drop Down Content',
                'input'                    => 'textarea',
                'required'                 => false,
                'sort_order'               => 11,
                'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled'          => true,
                'is_html_allowed_on_front' => true,
                'group'                    => 'Kemana/CategoriesEnhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_cat_bold_link',
            [
                'type'       => 'int',
                'label'      => 'Bold link design',
                'input'      => 'select',
                'required'   => false,
                'source'     => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'sort_order' => 12,
                'global'     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'      => 'Kemana/CategoriesEnhanced',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'kemana_menu_catimg',
            [
                'type'       => 'varchar',
                'label'      => 'Menu Category Image',
                'input'      => 'image',
                'required'   => false,
                'backend'    => \Magento\Catalog\Model\Category\Attribute\Backend\Image::class,
                'sort_order' => 13,
                'global'     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'      => 'Kemana/CategoriesEnhanced',
            ]
        );

        $setup->endSetup();
    }
}
