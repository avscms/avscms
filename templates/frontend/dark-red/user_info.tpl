<script type="text/javascript">
var lang_posting = "{t c='global.posting'}";
var lang_removing = "{t c='global.removing'}";
var lang_blocking = "{t c='global.blocking'}";
var lang_unblocking = "{t c='global.unblocking'}";
var lang_block = "{t c='user.block'}";
var lang_unblock = "{t c='user.unblock'}";
var lang_friend_msg = "{t c='ajax.invite_friend_msg_length'}";
var lang_friendship = "{t c='ajax.invite_friend_friendship'}";
var lang_remove_friend_ask = "{t c='ajax.remove_friend_ask'}";
var lang_remove_fav_game_ask = "{t c='ajax.remove_fav_game_ask'}";
var lang_remove_fav_video_ask = "{t c='ajax.remove_fav_video_ask'}";
var lang_remove_fav_photo_ask = "{t c='ajax.remove_fav_photo_ask'}";
var lang_remove_playlist_ask = "{t c='ajax.remove_playlist_ask'}";
var lang_report_user_msg_length = "{t c='ajax.report_user_msg_length'}";
var lang_subscribing = "{t c='global.subscribing'}";
var lang_unsubscribe = "{t c='user.unsubscribe'}";
var lang_unsubscribing = "{t c='global.unsubscribing'}";
var lang_subscribe = "{t c='user.subscribe'}";
var lang_wall_length = "{t c='ajax.wall_comment_length'}";
var lang_delete_video_ask = "{t c='video.delete_confirm'}";
var lang_delete_game_ask = "{t c='game.delete_confirm'}";
var lang_friend_rs = "{t c='user.friend_rs'}";
var lang_friend_rc = "{t c='user.friend_rc'}";
var lang_add_friend = "{t c='user.add_friend'}";
var lang_friends = "{t c='user.friends'}";
var lang_unfriend = "{t c='user.unfriend'}";
var lang_user_report = "{t c='user.report'}";

</script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.profile.js"></script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.voting.js"></script>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{t c='user.report'}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="report_reason" id="report_reason_1" value="offensive" checked>
					<label class="form-check-label" for="report_reason_1">
						{t c='flag.offensive'}
					</label>
				</div>
				<div class="form-check mt-2">
					<input class="form-check-input" type="radio" name="report_reason" id="report_reason_2" value="underage">
					<label class="form-check-label" for="report_reason_2">
						{t c='flag.underage'}
					</label>
				</div>
				<div class="form-check mt-2">
					<input class="form-check-input" type="radio" name="report_reason" id="report_reason_3" value="spammer">
					<label class="form-check-label" for="report_reason_3">
						{t c='flag.spammer'}
					</label>
				</div>
				<div class="form-check mt-2">
					<input class="form-check-input" type="radio" name="report_reason" id="report_reason_4" value="other">
					<label class="form-check-label" for="report_reason_4">
						{t c='flag.other'}
					</label>
				</div>
				<div class="form-group">
					<textarea class="form-control mt-2" name="other_reason" id="other_reason" rows="2" placeholder="{t c='global.message_opt'}"></textarea>
				</div>				
			</div>
			<div class="modal-footer">
				<button id="submit_user_report" type="button" data-uid="{$user.UID}" class="btn btn-primary btn-bold opt-1">{translate c='global.submit'}</button>
				<button type="button" class="btn btn-secondary btn-bold opt-2" data-dismiss="modal">{translate c='global.cancel'}</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{t c='mail.send'}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<input type="text" class="form-control" name="message_subject" id="message_subject"  placeholder="{t c='global.subject'}">
				</div>			
				<div class="form-group">
					<textarea class="form-control mt-2" name="message_body" id="message_body" rows="4" placeholder="{t c='global.message'}"></textarea>
				</div>				
			</div>
			<div class="modal-footer">
				<button id="send_user_message" type="button" data-receiver="{$user.username}" data-sender="{$smarty.session.username}" class="btn btn-primary btn-bold opt-1">{translate c='global.send'}</button>
				<button type="button" class="btn btn-secondary btn-bold opt-2" data-dismiss="modal">{translate c='global.cancel'}</button>
			</div>
		</div>
	</div>
</div>

<div class="user-header">
	<div class="user-avatar">
		<a href="{$relative}/user/{$username}">
			<img src="{$relative}/media/users/{if $user.photo != ''}{$user.photo}{else}nopic-{$user.gender}.gif{/if}" title="{$user.username}'s avatar" alt="{$user.username}'s avatar" class="img-responsive" />
		</a>
	</div>
	<div class="user-info">
		<div class="user-actions-container">
			<div class="user-username float-left">
				<a href="{$relative}/user/{$user.username}"><span class="d-inline d-md-none">{$user.username|truncate:12:"..."}</span><span class="d-none d-md-inline">{$user.username}</span></a> <span>{if $user.gender == 'Male'}<i class="fas fa-mars"></i>{else}<i class="fas fa-venus"></i>{/if}</span>
			</div>
			<div class="vote-box float-left ml-3">
				<span class="content-rating">
					<span class="mr-2"><i class="fas fa-thumbs-up"></i> <span id="rating_user_{$user.UID}">{if $user.rate != 0}{$user.rate}%{else}-{/if}</span></span>
					<span class="vote-up mr-1"><i id="vote_up_user_{$user.UID}" class="fas fa-thumbs-up"></i> <span id="likes_user_{$user.UID}">{$user.likes}</span></span>			
					<span class="vote-down"><i id="vote_down_user_{$user.UID}" class="fas fa-thumbs-down"></i> <span id="dislikes_user_{$user.UID}">{$user.dislikes}</span></span>						
				</span>	
			</div>
			<div id="user_reported" class="float-left ml-3 d-none">
				<i class="fas fa-flag" data-toggle="tooltip" data-placement="top" title="{translate c='global.reported'}"></i>
			</div>
			{if $smarty.session.uid != $user.UID}			
			<div class="user-actions float-right ml-3">
				{if isset($smarty.session.uid)}
					{insert name=is_subscribed assign=is_subscribed SUID=$smarty.session.uid UID=$user.UID}
				{/if}
				{if isset($is_subscribed) && $is_subscribed}			
					<a href="#" id="user_subscription" data-uid="{$user.UID}" data-subscribed="1" class="btn btn-secondary btn-bold btn-xs">{t c='user.subscribed'} <i class="fas fa-check"></i></a>
				{else}
					<a href="#" id="user_subscription" data-uid="{$user.UID}" data-subscribed="0" class="btn btn-secondary btn-bold btn-xs">{t c='user.subscribe'}</a>		
				{/if}
				{if isset($smarty.session.uid)}
					{insert name=is_blocked assign=is_blocked UID=$smarty.session.uid BID=$user.UID}
					{insert name=is_blocked assign=im_blocked UID=$user.UID BID=$smarty.session.uid}					
				{/if}
				<span {if $im_blocked}class="d-none"{/if}>
					<span id="user_friendship_container" {if $is_blocked || $im_blocked}class="d-none"{/if}>
					{if isset($smarty.session.uid)}
						{insert name=check_friend assign=check_friend UID=$smarty.session.uid user_id=$user.UID}
					{/if}
					{if $check_friend == 'Pending_sent'}
						<a href="#" id="user_friendship" data-uid="{$user.UID}" data-friendship="{$check_friend}" class="btn btn-secondary btn-bold btn-xxs" title="{t c='user.friend_rs'}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-clock"></i></a>	
						<div id="user_friendship_dd" class="dropdown-menu dropdown-menu-right" aria-labelledby="user_friendship">
							<a class="dropdown-item" id="user_friendship_" data-uid="{$user.UID}" data-friendship="Cancel" href="#">
								{t c='user.friend_rc'}
							</a>
						</div>								
					{elseif $check_friend == 'Pending_received'}
						<a href="#" id="user_friendship" data-uid="{$user.UID}" data-friendship="{$check_friend}" class="btn btn-secondary btn-bold btn-xxs" title="{t c='user.friend_rr'}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-clock"></i></a>	
						<div id="user_friendship_dd" class="dropdown-menu dropdown-menu-right" aria-labelledby="user_friendship">
							<a class="dropdown-item" id="user_friendship_a" data-uid="{$user.UID}" data-friendship="Accept" href="#">
								{t c='user.friend_af'}
							</a>
							<a class="dropdown-item" id="user_friendship_r" data-uid="{$user.UID}" data-friendship="Reject" href="#">
								{t c='user.friend_rf'}
							</a>							
						</div>							
					{elseif $check_friend == 'Confirmed_received' || $check_friend == 'Confirmed_sent'}
						<a href="#" id="user_friendship" data-uid="{$user.UID}" data-friendship="{$check_friend}" class="btn btn-secondary btn-bold btn-xxs" data-placement="top" title="{t c='user.friends'}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-check"></i></a>	
						<div id="user_friendship_dd" class="dropdown-menu dropdown-menu-right" aria-labelledby="user_friendship">
							<a class="dropdown-item" id="user_friendship_" data-uid="{$user.UID}" data-friendship="Unfriend" href="#">
								{t c='user.unfriend'}
							</a>
						</div>								
					{else} 
						<a href="#" id="user_friendship" data-uid="{$user.UID}" data-friendship="Add" class="btn btn-secondary btn-bold btn-xxs"  title="{t c='user.add_friend'}" data-toggle="" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-plus"></i></a>
						<div id="user_friendship_dd" class="dropdown-menu dropdown-menu-right d-none" aria-labelledby="user_friendship">
							<a class="dropdown-item" id="user_friendship_" data-uid="{$user.UID}" data-friendship="Cancel" href="#">
								{t c='user.friend_rc'}
							</a>
						</div>							
					{/if}
					</span>
				</span>								
				<span>
					{if (!$im_blocked && $private_msgs == 'all') || ($private_msgs == 'friends' && ($check_friend == 'Confirmed_received' || $check_friend == 'Confirmed_sent'))}
						{if isset($smarty.session.uid)}
						<a href="#" id="user_message" class="btn btn-secondary btn-bold btn-xxs n-alt-menu" data-uid="{$user.UID}" data-toggle="tooltip" data-placement="top" title="{translate c='mail.send'}"><i class="fas fa-envelope"></i></a>
						{/if}
					{/if}				
					<a id="user_more_actions" href="#" class="btn btn-secondary btn-bold btn-xxs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-h"></i>
					</a>					
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="user_more_actions">

							<a class="dropdown-item alt-menu" href="{$relative}/user/{$username}">{t c='user.wall'}</a>
							<a class="dropdown-item alt-menu" href="{$relative}/user/{$username}/videos">{t c='global.videos'}</a>
							<a class="dropdown-item alt-menu" href="{$relative}/user/{$username}/albums">{t c='global.photos'}</a>
							<a class="dropdown-item alt-menu" href="{$relative}/user/{$username}/blog">{t c='global.blog'}</a>										
				
						{if (!$im_blocked && $private_msgs == 'all') || ($private_msgs == 'friends' && ($check_friend == 'Confirmed_received' || $check_friend == 'Confirmed_sent'))}
							{if isset($smarty.session.uid)}
							<a id="user_message" class="dropdown-item alt-menu" data-uid="{$user.UID}" href="#">{translate c='mail.send'}</a>
							{/if}
						{/if}					
						<a class="dropdown-item" id="user_report" data-uid="{$user.UID}" href="#">
							{t c='user.report'}
						</a>
						{if isset($is_blocked) && !$is_blocked}
							<a class="dropdown-item" id="user_block" data-uid="{$user.UID}" data-block="Block" href="#">
								{t c='user.block'}
							</a>
						{elseif isset($smarty.session.uid)}
							<a class="dropdown-item" id="user_block" data-uid="{$user.UID}" data-block="Unblock" href="#">
								{t c='user.unblock'}
							</a>						
						{/if}
					</div>	
				</span>
			</div>
			{else}	
			<div class="user-actions float-right ml-3">	
				<span>
					<a id="user_more_actions" href="#" class="btn btn-secondary btn-bold btn-xxs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-h"></i>
					</a>					
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="user_more_actions">
						<a class="dropdown-item alt-menu" href="{$relative}/user/{$username}">{t c='user.wall'}</a>
						<a class="dropdown-item alt-menu" href="{$relative}/user/{$username}/videos">{t c='global.videos'}</a>
						<a class="dropdown-item alt-menu" href="{$relative}/user/{$username}/albums">{t c='global.photos'}</a>
						<a class="dropdown-item alt-menu" href="{$relative}/user/{$username}/blog">{t c='global.blog'}</a>										
						<a class="dropdown-item" href = "{$relative}/user/edit">{t c='user.edit_profile'}</a>
						<a class="dropdown-item" href = "{$relative}/user/avatar">{t c='user.change_avatar'}</a>
					</div>	
				</span>			
			</div>
			{/if}			
			<div class="clearfix"></div>
		</div>
		<div class="user-location">
			{if isset($user.city) && $user.city != ''}{$user.city}{/if}{if isset($user.city) && $user.city != '' && isset($user.country) && $user.country != ''}, {/if}{if isset($user.country) && $user.country != ''}{$user.country}{/if}
		</div>	
		<div class="user-menu">
			<a href="{$relative}/user/{$username}">{t c='user.wall'}</a>
			<a href="{$relative}/user/{$username}/videos">{t c='global.videos'}</a>
			<a href="{$relative}/user/{$username}/albums">{t c='global.photos'}</a>
			<a href="{$relative}/user/{$username}/blog">{t c='global.blog'}</a>										
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="user-left">
	<div class="user-info-box">	
		<div>	
		{if isset($online) && $online}
			<span class="ib-icon"><i class="fas fa-circle"></i></span> <span>{t c='global.online'}</span>
		{else}
			{insert name=time_range assign=last_login time=$user.logintime}
			<span class="ib-icon"><i class="far fa-circle"></i></span> <span>{t c='user.last_login'}:</span>	<span class="text-highlighted">{$last_login}</span>
		{/if}
		</div>
		<div>
			<span class="ib-icon"><i class="fas fa-medal"></i></span> <span>{t c='user.popularity'}:</span>	<span class="text-highlighted">{$user.popularity} {if $user.popularity == '1'}{t c='global.point'}{else}{t c='global.points'}{/if}</span>
		</div>
		<div>
			<span class="ib-icon"><i class="fas fa-medal"></i></span> <span>{t c='user.activity'}:</span>	<span class="text-highlighted">{$user.points} {if $user.points == '1'}{t c='global.point'}{else}{t c='global.points'}{/if}</span>
		</div>		
		<div>
			{insert name=time_range assign=joined time=$user.addtime}
			<span class="ib-icon"><i class="fas fa-calendar"></i></span> <span>{t c='user.joined'}:</span> <span class="text-highlighted">{$joined}</span>
		</div>		
		<div>
			{insert name=tsubscribers assign=t_subscribers subscribers=$total_subscribers}			
			<span class="ib-icon"><i class="fas fa-user-friends"></i></span> <span id="total_subscribers">{$t_subscribers}</span>
		</div>
		<div>
			{insert name=pviews assign=s_views views=$user.profile_viewed}			
			<span class="ib-icon"><i class="far fa-eye"></i></span> <span>{$s_views}</span>
		</div>		
		<div>
			{insert name=vviews assign=v_views views=$user.watched_video}			
			<span class="ib-icon"><i class="far fa-eye"></i></span> <span>{$v_views}</span>
		</div>	
		<div>
			{insert name=ownvviews assign=ownv_views views=$user.video_viewed}			
			<span class="ib-icon"><i class="far fa-eye"></i></span> <span>{$ownv_views}</span>
		</div>
		{if (isset($user.aboutme) && $user.aboutme != '')||(isset($user.country) && $user.country != '')||(isset($user.town) && $user.town != '')||(isset($user.city) && $user.city != '')||(isset($user.school) && $user.school != '')||(isset($user.occupation) && $user.occupation != '')||(isset($user.interest_hobby) && $user.interest_hobby != '')||(isset($user.fav_movie_show) && $user.fav_movie_show != '')||(isset($user.fav_music) && $user.fav_music != '')||(isset($user.fav_book) && $user.fav_book != '')||(isset($user.turnon) && $user.turnon != '')||(isset($user.turnoff) && $user.turnoff != '')||(isset($user.interested) && $user.interested != '') || (isset($user.website) && $user.website != '')}
		<div id="user-info-more">	
			{insert name=age assign=age bdate=$user.bdate}
			{if $age != ''}		
			<div>
				<span class="ib-icon"><i class="fas fa-birthday-cake"></i></span> <span>{t c='user.age'}:</span>	<span class="text-highlighted">{$age}</span>
			</div>
			{/if}
			{if $user.relation != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-heart"></i></span> <span>{t c='user.relationship'}:</span>	<span class="text-highlighted">{$user.relation}</span>
			</div>
			{/if}			
			{if $user.interested != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-venus-mars"></i></span> <span>{t c='user.interested_in'}:</span>	<span class="text-highlighted">{$user.interested}</span>
			</div>
			{/if}
			{if isset($user.town) && $user.town != ''}			
			<div>
				<span class="ib-icon"><i class="fas fa-city"></i></span> <span>{t c='global.hometown'}:</span>	<span class="text-highlighted">{$user.town}</span>
			</div>			
			{/if}
			{if isset($user.school) && $user.school != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-graduation-cap"></i></span> <span>{t c='global.school'}:</span>	<span class="text-highlighted">{$user.school}</span>
			</div>			
			{/if}
			{if isset($user.occupation) && $user.occupation != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-briefcase"></i></span> <span>{t c='global.job'}:</span>	<span class="text-highlighted">{$user.occupation}</span>
			</div>
			{/if}
			{if isset($user.website) && $user.website != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-globe"></i></span> <span>{t c='global.website'}:</span>	<span class="text-highlighted">{$user.website}</span>
			</div>
			{/if}				
			{if isset($user.interest_hobby) && $user.interest_hobby != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-book-reader"></i></span> <span>{t c='global.here_for'}:</span>	<span class="text-highlighted">{$user.interest_hobby}</span>
			</div>
			{/if}
			{if isset($user.fav_movie_show) && $user.fav_movie_show != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-star"></i></span> <span>{t c='user.favorite_sex'}:</span>	<span class="text-highlighted">{$user.fav_movie_show}</span>
			</div>
			{/if}
			{if isset($user.fav_music) && $user.fav_music != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-fire-alt"></i></span> <span>{t c='user.favorite_sex_partner'}:</span>	<span class="text-highlighted">{$user.fav_music}</span>
			</div>				
			{/if}
			{if isset($user.fav_book) && $user.fav_book != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-feather-alt"></i></span> <span>{t c='user.my_erogenic_zones'}:</span>	<span class="text-highlighted">{$user.fav_book}</span>
			</div>				
			{/if}
			{if isset($user.turnon) && $user.turnon != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-smile-wink"></i></span> <span>{t c='user.turn_on'}:</span>	<span class="text-highlighted">{$user.turnon}</span>
			</div>				
			{/if}
			{if isset($user.turnoff) && $user.turnoff != ''}
			<div>
				<span class="ib-icon"><i class="fas fa-angry"></i></span> <span>{t c='user.turn_off'}:</span>	<span class="text-highlighted">{$user.turnoff}</span>
			</div>
			{/if}		
			{if isset($user.aboutme) && $user.aboutme != ''}
				<div>{$user.aboutme}</div>
			{/if}			
		</div>	
		<div class="text-center mt-2">
			<a href="#" id="user-info-show-more" class="show-hide">{t c='global.show_more'}<i class="fas fa-chevron-down"></i></a>
			<a href="#" id="user-info-show-less" class="show-hide">{t c='global.show_less'}<i class="fas fa-chevron-up"></i></a>		
		</div>		
		{/if}		
	</div>
	{if $user_wall}
		{if $friends}	
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.friends'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/user/{$user.username}/friends">{t c='global.view_all'}</a>	
				</div>		
				<div class="clearfix"></div>
			</div>

			<div class="row content-row">
		   {section name=i loop=$friends}
				<div class="col-4 col-sm-3 col-md-3 col-lg-4 member {if $smarty.section.i.index>2}d-none d-sm-block{/if}{if $smarty.section.i.index>3}d-sm-none d-md-none d-lg-block{/if}">
					<a href="{$relative}/user/{$friends[i].username}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/users/{if $friends[i].photo == ''}nopic-{$friends[i].gender}.gif{else}{$friends[i].photo}{/if}" alt="{$friends[i].username}'s avatar" class="img-responsive"/>
						</div>
					</a>			
					<div class="content-info">
						<a href="{$relative}/user/{$friends[i].username}">
							<span class="content-truncate {if $friends[i].rate != 0}content-ml{/if}">{$friends[i].username|escape:'html'}</span>
						</a>
						{if $friends[i].rate != 0}
							<span class="content-rating content-mr"><i class="fas fa-thumbs-up"></i> <span>{$friends[i].rate}%</span></span>
						{/if}								
					</div>			
				</div>
			{/section}
			</div>		
		</div>
		{/if}
		{if $subscribers}	
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.Subscribers'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/user/{$user.username}/subscribers">{t c='global.view_all'}</a>	
				</div>		
				<div class="clearfix"></div>
			</div>

			<div class="row content-row">
		   {section name=i loop=$subscribers}
				<div class="col-4 col-sm-3 col-md-3 col-lg-4 member {if $smarty.section.i.index>2}d-none d-sm-block{/if}{if $smarty.section.i.index>3}d-sm-none d-md-none d-lg-block{/if}">
					<a href="{$relative}/user/{$subscribers[i].username}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/users/{if $subscribers[i].photo == ''}nopic-{$subscribers[i].gender}.gif{else}{$subscribers[i].photo}{/if}" alt="{$subscribers[i].username}'s avatar" class="img-responsive"/>
						</div>
					</a>			
					<div class="content-info">
						<a href="{$relative}/user/{$subscribers[i].username}">
							<span class="content-truncate {if $subscribers[i].rate != 0}content-ml{/if}">{$subscribers[i].username|escape:'html'}</span>
						</a>
						{if $subscribers[i].rate != 0}
							<span class="content-rating content-mr"><i class="fas fa-thumbs-up"></i> <span>{$subscribers[i].rate}%</span></span>
						{/if}								
					</div>			
				</div>
			{/section}
			</div>		
		</div>
		{/if}
		{if $subscriptions}	
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.subscriptions'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/user/{$user.username}/subscriptions">{t c='global.view_all'}</a>	
				</div>		
				<div class="clearfix"></div>
			</div>

			<div class="row content-row">
		   {section name=i loop=$subscriptions}
				<div class="col-4 col-sm-3 col-md-3 col-lg-4 member {if $smarty.section.i.index>2}d-none d-sm-block{/if}{if $smarty.section.i.index>3}d-sm-none d-md-none d-lg-block{/if}">
					<a href="{$relative}/user/{$subscriptions[i].username}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/users/{if $subscriptions[i].photo == ''}nopic-{$subscriptions[i].gender}.gif{else}{$subscriptions[i].photo}{/if}" alt="{$subscriptions[i].username}'s avatar" class="img-responsive"/>
						</div>
					</a>			
					<div class="content-info">
						<a href="{$relative}/user/{$subscriptions[i].username}">
							<span class="content-truncate {if $subscriptions[i].rate != 0}content-ml{/if}">{$subscriptions[i].username|escape:'html'}</span>
						</a>
						{if $subscriptions[i].rate != 0}
							<span class="content-rating content-mr"><i class="fas fa-thumbs-up"></i> <span>{$subscriptions[i].rate}%</span></span>
						{/if}								
					</div>			
				</div>
			{/section}
			</div>		
		</div>
		{/if}	
	{/if}
</div>

