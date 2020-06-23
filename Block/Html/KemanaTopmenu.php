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

namespace Kemana\Categoriesenhanced\Block\Html;

use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Theme\Block\Html\Topmenu;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Cms\Model\Template\FilterProvider;

class KemanaTopmenu extends Topmenu
{
    /**
     * Cache identities
     *
     * @var array
     */
    protected $identities = [];

    /**
     * Top menu data tree
     *
     * @var \Magento\Framework\Data\Tree\Node
     */
    protected $_menu;

    /**
     * @var NodeFactory
     */
    private $nodeFactory;

    /**
     * @var TreeFactory
     */
    private $treeFactory;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @param Template\Context $context
     * @param NodeFactory $nodeFactory
     * @param TreeFactory $treeFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        NodeFactory $nodeFactory,
        TreeFactory $treeFactory,
        CategoryFactory $categoryFactory,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        filterProvider $filterProvider,
        \Magento\Catalog\Helper\Output $helperCat,
        array $data = []
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->treeFactory = $treeFactory;
        $this->categoryFactory = $categoryFactory;
        $this->scopeConfig = $scopeConfig;
        $this->_filterProvider = $filterProvider;
        $this->_storeManager = $storeManager;
        $this->helper = $helperCat;
        parent::__construct($context, $nodeFactory, $treeFactory, $data);
    }
    /**
     * Prepare Content HTML
     *
     * @return string
     */
    public function getDesignDir()
    {
        $mediapath = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $dir = 'catalog/category/';
        return $mediapath.$dir;
    }

    public function getValHtml($val)
    {
        if (empty($val)) {
            return;
        }
        return $this->_filterProvider->getBlockFilter()->filter($val);
    }

    /**
     * Add sub menu HTML code for current menu item
     *
     * @param \Magento\Framework\Data\Tree\Node $child
     * @param string $childLevel
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string HTML code
     */
    protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
    {
        $html = '';
        if (!$child->hasChildren()) {
            return $html;
        }

        $catId = explode("category-node-", $child->getId());

        if (isset($catId[1]) && (int)$catId[1] == true) {
            $is_menu = true;
        } else {
            $is_menu = false;
        }

        $subcontent = '';
        $wrapperClass = null;
        $wrapperInit = null;
        $colStops = null;
        if ($childLevel == 0 && $limit) {
            $colStops = $this->_columnBrake($child->getChildren(), $limit);
        }
        if ($is_menu) {
            $currentCat = $this->categoryFactory->create()->load($catId[1]);
            $ratio = $currentCat->getData('kemana_cat_ratio');
            (empty($ratio) ? $ratio = '6/6' : $ratio = $ratio);
            $ratio = explode("/", $ratio);
            $columnsCount = $currentCat->getData('kemana_cat_max_quantity');
            (empty($columnsCount) ? $columnsCount = '1' : $columnsCount = $columnsCount);
            $columnsCount  = ' data-columns="'.$columnsCount.'"';
            $menuType = $currentCat->getData('kemana_cat_max_quantity');
            $categoryBg = '';
            $menuWidthVal = null;
            $menuWidth = $currentCat->getData('kemana_cat_menu_width');
            if ($menuType == 2) {
                $menuClass = ' fixed-width';
            }
            $catBg = $currentCat->getData('kemana_cat_bg');
            if ($catBg) {
                $catBgOption = $currentCat->getData('kemana_cat_bg_option');
                switch ($catBgOption) {
                    case "1":
                        $catBgOption = "background-position: left 0;";
                        break;
                    case "2":
                        $catBgOption = "background-position: right 0;";
                        break;
                    case "3":
                        $catBgOption = "background-position: center 0;";
                        break;
                    case "4":
                        $catBgOption = "background-size: 100% 100%;";
                        break;
                    default:
                        $catBgOption = "background-position: left 0;";
                }
                if ($menuType == 2 && $menuWidth) {
                    $categoryBg = ' style="background-image:url('.$catBg.'); '.$catBgOption.' width: '.$menuWidth.'px;"';
                } else {
                    $categoryBg = ' style="background-image:url('.$catBg.'); '.$catBgOption.'"';
                }
            } else {
                if ($menuType == 2 && $menuWidth) {
                    $menuWidthVal = ' style="width: '.$menuWidth.'px"';
                }
            }

            $status = $this->scopeConfig->getValue('kemana_categoriesenhanced/settings/config_categoriesenhanced_status', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $is_tabs = false;


            if ($currentCat->getData('kemana_cat_subcontent')) {
                $html .= '<div class="megamenu-wrapper' . $menuClass .'" '.$columnsCount . $categoryBg . $menuWidthVal . '>'.$this->getValHtml($currentCat->getData('kemana_cat_subcontent')).'</div>';
            } else {
                if ($status && $childLevel == 1) {
                    $parentCat = $this->categoryFactory->create()->load($currentCat->getParentCategory()->getId());
                    if ($parentCat->getData('kemana_cat_menutype') == 3 || $parentCat->getData('kemana_cat_menutype') == 4) {
                        $is_tabs = true;
                        $topContent = $currentCat->getData('kemana_cat_block_top');
                        $bottomContent = $currentCat->getData('kemana_cat_block_bottom');
                        $rightContent = $currentCat->getData('kemana_cat_block_right');
                        $subcontent .= '<div class="megamenu-inner"'.$columnsCount.$categoryBg.'>';
                        if ($topContent) {
                            $subcontent .= '<div class="top-content">'.$this->getValHtml($topContent).'</div>';
                        }

                        if ($rightContent) {
                            $subcontent .= '<div class="megamenu-center-block"><div class="left-column col-md-'.$ratio[0].'">';
                        }
                        $subcontent .= '<ul class="level' . $childLevel . ' ' . $childrenWrapClass . $wrapperClass . '" '. $wrapperInit .' >';
                        $subcontent .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
                        $subcontent .= '</ul>';
                        if ($rightContent) {
                            $subcontent .= '</div><div class="right-column col-md-'.$ratio[1].'">'.$this->getValHtml($rightContent).'</div></div>';
                        }
                        if ($bottomContent) {
                            $subcontent .= '<div class="bottom-content">'.$this->getValHtml($bottomContent).'</div>';
                        }
                        $subcontent .= '</div>';
                    }

                    if ($parentCat->getData('kemana_cat_menutype') != 3 || $parentCat->getData('kemana_cat_menutype') != 4) {
                        $is_tabs = true;
                        $topContent = $currentCat->getData('kemana_cat_block_top');
                        $bottomContent = $currentCat->getData('kemana_cat_block_bottom');
                        $subcontent .= '<ul class="level' . $childLevel . ' ' . $childrenWrapClass . $wrapperClass . '" '. $wrapperInit .' >';
                        $subcontent .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
                        $subcontent .= '</ul>';
                        if ($bottomContent) {
                            $subcontent .= '<div class="bottom-content">'.$this->getValHtml($bottomContent).'</div>';
                        }
                    }
                }

                if ($status == 1 && $childLevel == 0) {

                    $showFields = true;
                    if ($menuType == 1) {
                        $showFields = false;
                    }

                    if (!$showFields) {
                        $wrapperClass = ' default-menu';
                        $wrapperInit = ' data-mage-init=\'{"menu":{"responsive":true, "expanded":true, "delay": 0, "position":{"my":"left top","at":"left bottom"}}}\'';
                    }

                    if ($showFields) {
                        $topContent = $currentCat->getData('kemana_cat_block_top');
                        $bottomContent = $currentCat->getData('kemana_cat_block_bottom');
                        $rightContent = $currentCat->getData('kemana_cat_block_right');

                        $menuClass = null;
                        if ($menuType == 3) {
                            $menuClass = ' tabs-menu vertical';
                        }
                        if ($menuType == 4) {
                            $menuClass = ' tabs-menu horizontal';
                        }
                        ($menuType == 3 || $menuType == 4 ? $menuTabs = true : $menuTabs = false);

                        $html .= '<div class="megamenu-wrapper' . $menuClass .'" '.$columnsCount . $categoryBg . $menuWidthVal . '>';
                        if ($topContent && !$menuTabs) {
                            $html .= '<div class="top-content">'.$this->getValHtml($topContent).'</div>';
                        }

                        if ($rightContent && !$menuTabs) {
                            $html .= '<div class="megamenu-center-block"><div class="left-column col-md-'.$ratio[0].'">';
                        }
                    }
                }

                if ($childLevel == 1) {
                    $html .= $subcontent;
                }

                if (!$is_tabs) {
                    $html .= '<ul class="level' . $childLevel . ' ' . $childrenWrapClass . $wrapperClass . '" '. $wrapperInit .' >';
                    $html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
                    $html .= '</ul>';
                }

                if ($is_menu) {
                    if ($status == 1 && $childLevel == 0 && $showFields) {
                        if ($rightContent && !$menuTabs) {
                            $html .= '</div><div class="right-column col-md-'.$ratio[1].'">'.$this->getValHtml($rightContent).'</div></div>';
                        }
                        if ($bottomContent && !$menuTabs) {
                            $html .= '<div class="bottom-content">'.$this->getValHtml($bottomContent).'</div>';
                        }
                        $html .= '</div>';
                    }

                }
            }
        }

        return $html;
    }



    /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param \Magento\Framework\Data\Tree\Node $menuTree
     * @param string $childrenWrapClass
     * @param int $limit
     * @param array $colBrakes
     * @return string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _getHtml(
        \Magento\Framework\Data\Tree\Node $menuTree,
        $childrenWrapClass,
        $limit,
        $colBrakes = []
    ) {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;

        $counter = 1;
        $itemPosition = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        $status = $this->scopeConfig->getValue('kemana_categoriesenhanced/settings/config_categoriesenhanced_status', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        /** @var \Magento\Framework\Data\Tree\Node $child */
        foreach ($children as $child) {
            // if ($childLevel === 0 && $child->getData('is_parent_active') === false) {
            if ($child->getData('is_parent_active') === false) {
                continue;
            }

            $catId = explode("category-node-", $child->getId());
            if (isset($catId[1]) && (int)$catId[1] == true) {
                $is_menu = true;
            } else {
                $is_menu = false;
            }

            $catLabel = '';
            $boldLink = '';
            $target = '';
            $catImgHtml = '';
            $catCustLink = '';
            if ($is_menu) {
                $currentCat = $this->categoryFactory->create()->load($catId[1]);

                if ($status == 1) {
                    if ($childLevel < 4) {
                        $catCustLabel = $currentCat->getData('kemana_cat_customlabel');
                        $catCustLabelText = $currentCat->getData('kemana_cat_labeltext');
                        $boldLinkOpt = $currentCat->getData('kemana_cat_bold_link');

                        if ($catCustLabel) {
                            $catLabel = '<em class="category-label ' . $catCustLabel . '">' . $catCustLabelText . '</em>';
                        }
                        if ($boldLinkOpt) {
                            $boldLink = ' data-bold-link="1"';
                        }
                    }

                    $catCustLink = $currentCat->getData('kemana_cat_custom_link');
                    $catCustLinkTarget = $currentCat->getData('kemana_cat_custom_link_target');

                    ($catCustLinkTarget ? $target = 'target="_blank"' : $target = '');
                    if ($catCustLink) {
                        switch ($catCustLink) {
                            case "/":
                                $catCustLink = $this->_storeManager->getStore()->getBaseUrl();
                                break;
                            case "#":
                                $catCustLink = "javascript: void(0);";
                            default:
                                $catCustLink = $catCustLink;
                        }
                    }

                    if ($catImg = $currentCat->getData('kemana_menu_catimg')) {
                        $parentCat = $this->categoryFactory->create()->load($currentCat->getParentCategory()->getId());
                        if ($parentCat->getData('kemana_cat_menutype') !=1) {
                            //$catImg = $this->getDesignDir().$catImg;
                            $catImgHtml = '<p class="category-image"><img src="'.$catImg.'" alt="'.$this->escapeHtml($currentCat->getName()).'" title="'.$this->escapeHtml($currentCat->getName()).'" /></p>';
                            $catImgHtml = $this->helper->categoryAttribute($currentCat, $catImgHtml, 'image');
                        }
                    }
                }
            }

            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            $fixedClass = null;
            if ($childLevel == 0 && $outermostClass) {
                if ($is_menu) {
                    if ($currentCat->getData('kemana_cat_menutype') && $currentCat->getData('kemana_cat_menu_width')) {
                        $fixedClass = ' data-fixed-width="1" ';
                    }
                }
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }

            if ($colBrakes && count($colBrakes) && $colBrakes[$counter]['colbrake']) {
                $html .= '</ul></li><li class="column"><ul>';
            }

            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . $fixedClass . '>';
            $html .= $catImgHtml;
            if ($childLevel == 1) {
                $topContent = $currentCat->getData('kemana_cat_block_top');
                if ($topContent) {
                    $html .= '<div class="top-content">'.$this->getValHtml($topContent).'</div>';
                }
            }
            $html .= '<a href="' . ($catCustLink ? $catCustLink : $child->getUrl()) . '" ' . $outermostClassCode . $target . $boldLink . '> <span>' . $this->escapeHtml(
                $child->getName()
            ) . '</span>'.$catLabel.'</a>' . $this->_addSubMenu(
                $child,
                $childLevel,
                $childrenWrapClass,
                $limit
            ) . '</li>';
            $itemPosition++;
            $counter++;
        }

        if ($colBrakes && count($colBrakes) && $limit) {
            $html = '<li class="column"><ul>' . $html . '</ul></li>';
        }

        return $html;
    }
}
