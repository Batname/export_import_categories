<?php

class Sitemaster_Importcategories_Adminhtml_Import_CategoryController extends Mage_Adminhtml_Controller_Action
{

	public function categoriesAction() {
		if ($this->getRequest()->isPost()) {
			$count = $this->getRequest()->getPost('count',0);
			$result['count'] = $count;
			$error = '';
			try {
				$attributes = Mage::helper('sitemaster_coreexportcategories/category')->getAttributes();
				$helper = Mage::helper('sitemaster_importcategories/category');
				$category = Mage::getModel('catalog/category');

				$categoryPath = $this->getRequest()->getPost('path');
				$categoryName = $this->getRequest()->getPost('name');
				$catid = $helper->getCategoryIdFromPath($categoryPath, $categoryName);
				if (is_array($catid)) {
					$error = Mage::helper('sitemaster_importcategories')->__('Path provided is not a valid one.');
				} else {
					if ($catid > 0) $category->load($catid);
					foreach($attributes as $attribute) {
						$fieldvalue = $this->getRequest()->getPost($attribute['field']);
						if (isset($attribute['function'])) {
							$fieldvalue = $helper->$attribute['function']($fieldvalue);
						}
						if (isset($attribute['required'])) {
							if (strtolower($attribute['required']) == 'yes') {
								if (!$fieldvalue) {
									$error = Mage::helper('sitemaster_importcategories')->__('Please provide the value for "%s"', $attribute['field']);
									break;
								}
							}
						}
						if (isset($attribute['importfn'])) {
							$category->$attribute['importfn']($attribute['field'], $fieldvalue);
						} else {
							$category->setData($attribute['field'], $fieldvalue);
						}
					}
				}

				if ($error) {
					$result['error'] = $error;
				} else {
					$category->save();
					$result['message'] = Mage::helper('sitemaster_importcategories')->__('Imported the category "%s" successfully.', $category->getName());
				}
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
		} else {
			$result['error'] = Mage::helper('sitemaster_importcategories')->__('Invalid request');
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}

}