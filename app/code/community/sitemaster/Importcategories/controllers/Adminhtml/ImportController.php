<?php

class Sitemaster_Importcategories_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action
{

	public function indexAction() {
		$this->_title(Mage::helper('sitemaster_importcategories')->__('Import Profiles'));

		$this->loadLayout()->_setActiveMenu('sitemaster_coreexportcategories/import');
		$this->renderLayout();
	}

	public function categoryAction() {
		$type = $this->getRequest()->getParam('type');
		$this->_title(Mage::helper('sitemaster_importcategories')->__('Import Category Profiles'));

		if ($this->getRequest()->isPost()) {
			$this->getResponse()->setBody($this->getLayout()->createBlock('sitemaster_importcategories/adminhtml_category_import_'.$type)->toHtml());
			$this->getResponse()->sendResponse();
		} else {
			$this->loadLayout()->_setActiveMenu('sitemaster_coreexportcategories/import');
			$this->renderLayout();
		}
	}

}