<?php
class Ameex_MinimumOrderAmount_Model_Quote_Address extends Mage_Sales_Model_Quote_Address
{

	 public function validateMinimumAmount()
    {
    	$roleId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        $role = Mage::getSingleton('customer/group')->load($roleId)->getData('minimum_order_amount');
        $role = strtolower($role);
        $storeId = $this->getQuote()->getStoreId();
        if (!Mage::getStoreConfigFlag('sales/minimum_order/active', $storeId)) {
            return true;
        }

        if ($this->getQuote()->getIsVirtual() && $this->getAddressType() == self::TYPE_SHIPPING) {
            return true;
        } elseif (!$this->getQuote()->getIsVirtual() && $this->getAddressType() != self::TYPE_SHIPPING) {
            return true;
        }

        $amount = Mage::getSingleton('customer/group')->load($roleId)->getData('minimum_order_amount');
        if ($this->getBaseSubtotalWithDiscount() < $amount) {
            return false;
        }
        return true;
       

       


       
      }
}