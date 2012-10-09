<div id="currentuser">

{* DESIGN: Header START *}<div class="box-header"><div class="box-ml">

<h4>{'Current user'|i18n( 'design/admin/pagelayout' )}</h4>

{* DESIGN: Header END *}</div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-content">

{if and( ne( $ui_context, 'edit' ), ne( $ui_context, 'browse' ) )}
    {def $user_node = $current_user.contentobject.main_node
         $current_user_link = $user_node.url_alias|ezurl}
    {if $user_node.can_read}
        <p><a href={$current_user_link}><img src={'current-user.gif'|ezimage} height="22" width="22" alt="" style="text-align: left; vertical-align: middle;" /></a>&nbsp;<a style="font-weight: normal; text-decoration: none; color: #000000" href={$current_user_link}>{$current_user.contentobject.name|wash}</a></p>
    {else}
        <p><img src={'current-user-disabled.gif'|ezimage} height="22" width="22" alt="" style="text-align: left; vertical-align: middle;" /> {$current_user.contentobject.name|wash}</p>
    {/if}
    {undef $current_user_link $user_node}
    <ul>
    <li><div>
    {if $current_user.contentobject.can_edit}
        <a href={concat( '/content/edit/',  $current_user.contentobject_id, '/' )|ezurl} title="{'Change name, email, password, etc.'|i18n( 'design/admin/pagelayout' )}">{'Change information'|i18n( 'design/admin/pagelayout' )}</a>
    {else}
        <span class="disabled">{'Change user info'|i18n( 'design/admin/pagelayout' )}</span>
    {/if}</div></li>
    <li><div><a href={'/user/password/'|ezurl} title="{'Change password for <%username>.'|i18n( 'design/admin/pagelayout',, hash( '%username', $current_user.contentobject.name ) )|wash}">{'Change password'|i18n( 'design/admin/pagelayout' )}</a></div></li>
    </ul>
{else}
    <p><img src={'current-user-disabled.gif'|ezimage} height="22" width="22" alt="" style="text-align: left; vertical-align: middle;" /> {$current_user.contentobject.name|wash}</p>
    <ul>
    <li><div><span class="disabled">{'Change user info'|i18n( 'design/admin/pagelayout' )}</span></div></li>
    <li><div><span class="disabled">{'Change password'|i18n( 'design/admin/pagelayout' )}</span></div></li>
    </ul>
{/if}
{* DESIGN: Content END *}</div></div></div>

</div>

{if fetch( 'ngswitchuser', 'has_access', hash( 'user_id', $current_user.contentobject_id ) ) }
  
    <div class="box-header"><div class="box-ml">
        <h4>{'Change User'|i18n( 'design/admin/pagelayout' )}</h4>
    </div></div>

    <div class="box-bc"><div class="box-ml"><div class="box-content">

    <form id="clearcache" action={'ngswitchuser/as'|ezurl} method="post">
        <div class="block">
            <select name="ngchange_user_object_id">
                {*def $usersList = fetch(content, list, hash( 
                    parent_node_id, 13,
                    class_filter_type, include,
                    class_filter_array, array('user')
                     )) }
                
                {foreach $usersList as $userItem}
                    <option{eq( $current_user.contentobject_id, $userItem.contentobject_id )|choose( '', ' selected="selected"' )} value="{$userItem.contentobject_id}">{$userItem.name|wash}</option>
                {/foreach*}
                {def $usersList = fetch(ngswitchuser,get_users)}
                {foreach $usersList as $userItem}
                    <option{eq( $current_user.contentobject_id, $userItem.id )|choose( '', ' selected="selected"' )} value="{$userItem.id}">{$userItem.name|wash}</option>
                {/foreach}
            </select>
            
        </div>
        <div class="block">
            <input class="button" type="submit" name="ngLoginChange" value="{'Change'|i18n( 'design/standard/pagelayout' )}" />
            <input class="{if fetch(ngswitchuser,is_in_switch_mode)}default{/if}button" type="submit" name="ngLoginRestore" value="{'Restore'|i18n( 'design/standard/pagelayout' )}" />
        </div>
    </form>
    </div></div></div>
{/if}