<?php
class Diglin_Chat_AdminController extends Mage_Adminhtml_Controller_Action
{
    public function dashboardAction()
    {
        $this->loadLayout()
            ->_addContent($this->getLayout()->createBlock('chat/dashboard'))
            ->renderLayout();
    }

    public function indexAction()
    {
        $this->dashboardAction();
    }
}
