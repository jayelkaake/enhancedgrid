<?php

class TBT_Enhancedgrid_Model_System_Config_Source_Sort_Direction
{
    public function toOptionArray()
    {
        $sorts = array();
        $sorts[] = array('value' => 'desc',   'label' => 'Descending');
        $sorts[] = array('value' => 'asc',   'label' => 'Ascending');
        return $sorts;
    }
}