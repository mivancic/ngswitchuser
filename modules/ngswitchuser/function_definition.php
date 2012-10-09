<?php
/**
 * File containing the function definition
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 *
 */

$FunctionList = array();

$FunctionList['has_access'] = array( 'name'            => 'has_access',
                              'operation_types' => array( 'read' ),
                              'call_method'     => array( 'class'  => 'ngSwitchUserFunctionCollection',
                                                          'method' => 'hasAccess' ),
                              'parameter_type'  => 'standard',
                              'parameters'      => array( array( 'name'     => 'user_id',
                                                                 'type'     => 'integer',
                                                                 'required' => true ) ) );
$FunctionList['get_users'] = array( 'name'            => 'get_users',
                              'operation_types' => array( 'read' ),
                              'call_method'     => array( 'class'  => 'ngSwitchUserFunctionCollection',
                                                          'method' => 'getUsers' ),
                              'parameter_type'  => 'standard',
                              'parameters'      => array( ) );
$FunctionList['is_in_switch_mode'] = array( 'name'            => 'is_in_switch_mode',
                              'operation_types' => array( 'read' ),
                              'call_method'     => array( 'class'  => 'ngSwitchUserFunctionCollection',
                                                          'method' => 'isInSwitchMode' ),
                              'parameter_type'  => 'standard',
                              'parameters'      => array( ) );
  
?>
