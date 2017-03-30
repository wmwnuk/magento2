<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Variable\Controller\Adminhtml\System\Variable;

/**
 * Display Variables list page
 * @api
 */
class Index extends \Magento\Variable\Controller\Adminhtml\System\Variable
{
    /**
     * Index Action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->createPage();
        $resultPage->getConfig()->getTitle()->prepend(__('Custom Variables'));
        return $resultPage;
    }
}
