<?php

$installer = $this;

$installer->startSetup();
$install_version = Mage::getConfig ()->getNode ( 'modules/TBT_Enhancedgrid/version' );

$msg_title = "Enhanced Grid {$install_version} was successfully installed! Remember to flush all cache, recompile and log-out and log back in.";
$msg_desc = "Enhanced Grid {$install_version} was successfully installed on your store. "
		. "Remember to flush all cache, recompile and log-out and log back in. "
		. "The new Enhanced Products Grid replaces the default Magento product management grid."
        . "You can configure Enhanced Grid in the Configuration section.";
$url = "#";

$message = Mage::getModel( 'adminnotification/inbox' );
$message->setDateAdded( date( "c", time() ) );

$message->setSeverity( Mage_AdminNotification_Model_Inbox::SEVERITY_NOTICE );

$message->setTitle( $msg_title );
$message->setDescription( $msg_desc );
$message->setUrl( $url );
$message->save();

$installer->endSetup(); 

