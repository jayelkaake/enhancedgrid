<?php
/**
 * Enhanced grid Product collection
 * @nelkaake -a 15/12/10: 
 *
 * @category   TBT
 * @package     Enhancedgrid
 * @author      WDCA
 */
class TBT_Enhancedgrid_Model_Resource_Eav_Mysql4_Product_Collection
    extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
{

    /**
     * Get SQL for get record count
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        
        //@nelkaake -a 15/12/10: Reset the group selection. ( for categories grouping)
        $countSelect->reset(Zend_Db_Select::GROUP);

        return $countSelect;
    }
}
