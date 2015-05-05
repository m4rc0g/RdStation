<?php
  //Delete the data from database
  if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

  delete_option( 'rd_token' );
?>
