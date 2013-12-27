<?php

class Sitemaster_Exportcategories_Adminhtml_ExportController extends Mage_Adminhtml_Controller_Action
{

	public function indexAction() {
		$this->_title(Mage::helper('sitemaster_exportcategories')->__('Export Profiles'));

		$this->loadLayout()->_setActiveMenu('sitemaster_coreexportcategories/export');
		$this->renderLayout();
	}

	public function categoryAction() {
		$type = $this->getRequest()->getParam('type');
		$this->_title(Mage::helper('sitemaster_exportcategories')->__('Export Category Profiles'));
		$this->getResponse()->setBody($this->getLayout()->createBlock('sitemaster_exportcategories/adminhtml_category_export_'.$type)->toHtml());
		$this->getResponse()->sendResponse();
	}

}