<?php

/**
 * ngSwitchUserFunctionCollection class implements fetch functions for ngswitchuser
 *
 */

class ngSwitchUserFunctionCollection
{
    /**
     * Returns true if user has access to ngswitchuser - can_switch function and in user is admin with ID 14
     *
     * @param integer $userID
     * @return boolean
     */
    function hasAccess( $userID )
    {
       
        $http = eZHttpTool::instance();
        
        if ( $userID )
        {
            $user = eZUser::fetch( $userID );
        }

        if ( is_object( $user ) )
        {
            $result = $user->hasAccessTo( 'ngswitchuser', 'can_switch' );
            if ( ( $result['accessWord'] != 'no' || $http->hasSessionVariable( 'ngLoginAdmin' ) ) && 
                ( $http->sessionVariable( 'ngLoginAdmin' ) == 14 || $user->ContentObjectID == 14 ) )
            {
                return array( 'result' => true );
            }
            else
            {
                return array( 'result' => false );
            }
        }
        else
        {
            return array( 'result' => false );
        }        
    }

    /**
     * Fetches all eZUser Content objects that have access to ngswitchuser - can_switch function
     *
     * @return array
     */
    function getUsers(  )
    {
        $usersArray = array();
        /*$policiesArray = self::getPoliciesByModuleAndFunction( 'ngswitchuser', 'can_switch' );
        
        foreach( $policiesArray as $policy )
        {
            $role = eZRole::fetch( $policy->RoleID );
        }*/
        //fetch all users
        $treeParameters = array(    'ClassFilterType' => 'include',
                                    'ClassFilterArray' => array( 'user' ),
                                    'Limitation' => array(),
                                    'Depth' => 2
                                    );
        $users = eZContentObjectTreeNode::subTreeByNodeID( $treeParameters, 5 );
        
        foreach ( $users as $userContent)
        {
            $user = eZUser::fetch( $userContent->ContentObjectID );
            $accessArray = $user->hasAccessTo( 'ngswitchuser', 'can_switch' );
            
            if ( $user instanceof eZUser &&  $accessArray['accessWord'] != 'no' )
            {
                $usersArray[] = $userContent->ContentObject;
            }
        }
        
        //print_r( self::hasAccess( 61 ) );
        //print_r( $usersArray );
        //print_r( self::fetchUserGroupsByRoleID( 5 ) );
        //$role = eZRole::fetchByName('Name test');
        //$roleUsers = $role->fetchUserByRole();
        //$users = eZUser::fetchContentList();

       return array( 'result' => $usersArray );
    }

    /*
     * DEPRECATED (this was used in getUsers method)
     */

    static function getPoliciesByModuleAndFunction( $moduleName, $functionName )
    {
        $policiesArray = array();
        foreach ( eZRole::fetchList() as $role )
        {
            foreach( $role->policyList() as $policy )
            {
                if ( $policy->ModuleName != $moduleName && $policy->FunctionName != $functionName )
                    continue;

                $policiesArray[] = $policy;
            }
        }
        return $policiesArray;
    }

    /*
     * DEPRECATED (this was used in getUsers method)
     */
    static function fetchUserGroupsByRoleID( $roleID )
    {
        $db = eZDB::instance();

        $query = "SELECT
                     ezuser_role.contentobject_id as user_id,
                     ezuser_role.limit_value,
                     ezuser_role.limit_identifier,
                     ezuser_role.id
                  FROM
                     ezuser_role
                  WHERE
                    ezuser_role.role_id = '$roleID'";

        $userRoleArray = $db->arrayQuery( $query );
        $usersGroupArray = array();
        foreach ( $userRoleArray as $userRole )
        {
            $usersGroupArray[] = eZContentObject::fetch( $userRole['user_id'] );
        }
        return $usersGroupArray;
    }

    /**
     * Check if admin is in switchmode
     *
     * @return boolean
     */
    function isInSwitchMode(  )
    {
        $http = eZHttpTool::instance();
        $currentUser = eZUser::currentUser();
        $ngLoginAdmin = ( $http->hasSessionVariable( 'ngLoginAdmin' ) ) ? $http->sessionVariable( 'ngLoginAdmin' ) : false;

        if ( $ngLoginAdmin && $currentUser->ContentObjectID != $ngLoginAdmin )
            return array( 'result' => true );
        else
            return array( 'result' => false );
    }

}
?>