<?php
/**
 * File containing the module definition.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 *
 */

$Module = array( 'name' => 'ngSwitchUser' );

$ViewList = array();

$ViewList['as'] = array(
                   'functions' => array( 'can_switch' ),
                   'script' => 'as.php',
                   'params' => array( 'userID' ),
                   );

$FunctionList = array();

$FunctionList['can_switch'] = array();
