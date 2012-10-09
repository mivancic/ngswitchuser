<?php

$userId = $Params['userID'];
$module = $Params['Module'];
$currentUser = eZUser::currentUser();
$http = eZHttpTool::instance();

if ( $http->hasPostVariable( 'ngLoginChange' ) )
    $userId = $http->postVariable( 'ngchange_user_object_id' );

$isSuperAdmin = false;

if ( $currentUser->ContentObjectID == 14 )
    $isSuperAdmin = $currentUser->ContentObjectID;

if ( $http->hasSessionVariable( 'ngLoginAdmin' ) )
    $isSuperAdmin = $http->sessionVariable( 'ngLoginAdmin' );

if ( !$isSuperAdmin )
{
    return $module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );

}

if ( $userId
         and $userId != eZINI::instance()->variable( 'UserSettings', 'AnonymousUserID' )
         /*and in_array( 12, $currentUser->groups() )*/
         and $isSuperAdmin
     )
{
    
    $requestedUser =  eZUser::fetch( (int) $userId );
    
    if ( $requestedUser instanceof eZUser ) 
        eZUser::setCurrentlyLoggedInUser( $requestedUser, $requestedUser->ContentObjectID );
    else
        return $module->redirectTo( '/' );
    
    //set session variable for knowing which users started changing session
    if ( !$http->hasSessionVariable( 'ngLoginAdmin' ) )
        $http->setSessionVariable( 'ngLoginAdmin', $currentUser->ContentObjectID );
}

/* Restore originaly user that started changing sessions*/
if ( $http->hasPostVariable( 'ngLoginRestore' ) )
{
    $firstUserObjectID = $http->sessionVariable( 'ngLoginAdmin' );
    $firstUser =  eZUser::fetch( (int) $firstUserObjectID );
    
    if ( $firstUser instanceof eZUser ) 
        eZUser::setCurrentlyLoggedInUser( $firstUser, $firstUser->ContentObjectID );
    
    $http->removeSessionVariable( 'ngLoginAdmin' );

}
/* Redirect to last accessed URI*/
if ( $http->hasSessionVariable( "LastAccessesURI" ) )
    $module->redirectTo( $http->sessionVariable( "LastAccessesURI" ) );

?>
