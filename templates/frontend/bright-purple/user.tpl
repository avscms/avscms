<script type="text/javascript" src="{$relative_tpl}/js/jquery.comments.js"></script>
<div class="container mt-3 mb-3">
	{include file='user_info.tpl'}
	<div class="user-right">
		{if $playlist}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.recently_watched'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/user/{$user.username}/playlist">{t c='global.view_all'}</a>	
				</div>		
				<div class="clearfix"></div>
			</div>

			<div class="row content-row">
				{section name=i loop=$playlist}
					<div class="{if $max_col == '5'}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 col-xl-3 {if $smarty.section.i.index > 2} d-md-none d-xl-inline {/if}
								{else}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 {if $smarty.section.i.index > 2}d-md-none d-xl-none{/if}{/if}">
						<a href="{$relative}/video/{$playlist[i].VID}/{$playlist[i].title|clean}">
							<div class="thumb-overlay" {if $playlist[i].vthumbs == '1'} id="playvthumb_{$playlist[i].VID}"{/if}>
								<img src="{insert name=thumb_path vid=$playlist[i].VID}/{$playlist[i].thumb}.jpg" title="{$playlist[i].title|escape:'html'}" alt="{$playlist[i].title|escape:'html'}" {if $playlist[i].vthumbs == '0'}id="rotate_{$playlist[i].VID}_{$playlist[i].thumbs}_{$playlist[i].thumb}_viewed"{/if} class="img-responsive {if $playlist[i].type == 'private'}img-private{/if}"/>
								{if $playlist[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
								<div class="duration">
									{if $playlist[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
									{insert name=duration assign=duration duration=$playlist[i].duration}
									{$duration}
								</div>
							</div>
						</a>
						<div class="content-info">
							<a href="{$relative}/video/{$playlist[i].VID}/{$playlist[i].title|clean}">
								<span class="content-title">{$playlist[i].title|escape:'html'}</span>					
							</a>
							<div class="content-details">
								{insert name=views assign=s_views views=$playlist[i].viewnumber}											
								<span class="content-views">
									{$s_views}								
								</span>
								{if $playlist[i].rate != 0}
									<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$playlist[i].rate}%</span></span>
								{/if}
							</div>				
						</div>
					</div>			
				{/section}
			</div>		
		</div>	
		{/if}
		{if $videos}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='global.videos'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/user/{$user.username}/videos">{t c='global.view_all'}</a>	
				</div>		
				<div class="clearfix"></div>
			</div>

			<div class="row content-row">
				{section name=i loop=$videos}
					<div class="{if $max_col == '5'}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 col-xl-3 {if $smarty.section.i.index > 2} d-md-none d-xl-inline {/if}
								{else}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 {if $smarty.section.i.index > 2}d-md-none d-xl-none{/if}{/if}">
						<a href="{$relative}/video/{$videos[i].VID}/{$videos[i].title|clean}">
							<div class="thumb-overlay" {if $videos[i].vthumbs == '1'} id="playvthumb_{$videos[i].VID}"{/if}>
								<img src="{insert name=thumb_path vid=$videos[i].VID}/{$videos[i].thumb}.jpg" title="{$videos[i].title|escape:'html'}" alt="{$videos[i].title|escape:'html'}" {if $videos[i].vthumbs == '0'}id="rotate_{$videos[i].VID}_{$videos[i].thumbs}_{$videos[i].thumb}_viewed"{/if} class="img-responsive {if $videos[i].type == 'private'}img-private{/if}"/>
								{if $videos[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
								<div class="duration">
									{if $videos[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
									{insert name=duration assign=duration duration=$videos[i].duration}
									{$duration}
								</div>
							</div>
						</a>
						<div class="content-info">
							<a href="{$relative}/video/{$videos[i].VID}/{$videos[i].title|clean}">
								<span class="content-title">{$videos[i].title|escape:'html'}</span>					
							</a>
							<div class="content-details">
								{insert name=views assign=s_views views=$videos[i].viewnumber}											
								<span class="content-views">
									{$s_views}								
								</span>
								{if $videos[i].rate != 0}
									<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$videos[i].rate}%</span></span>
								{/if}
							</div>				
						</div>
					</div>			
				{/section}
			</div>		
		</div>	
		{/if}
		{if $albums && $photo_module == '1'}
		<div>	
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.PHOTO_ALBUMS'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/user/{$user.username}/albums">{t c='global.view_all'}</a>	
				</div>		
				<div class="clearfix"></div>
			</div>
			<div class="row content-row">
			{section name=i loop=$albums}
				<div class="{if $max_col == '5'}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 col-xl-3 {if $smarty.section.i.index > 2} d-md-none d-xl-inline {/if}
								{else}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 {if $smarty.section.i.index > 2}d-md-none d-xl-none{/if}{/if}">
					<a href="{$relative}/album/{$albums[i].AID}/{$albums[i].name|clean}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/albums/{$albums[i].AID}.jpg" title="{$albums[i].name|escape:'html'}" alt="{$albums[i].name|escape:'html'}" class="img-responsive {if $albums[i].type == 'private'}img-private{/if}"/>
							{if $albums[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
						</div>
					</a>
					<div class="content-info">
						<a href="{$relative}/album/{$albums[i].AID}/{$albums[i].name|clean}">
							<span class="content-title">{$albums[i].name|escape:'html'}</span>
						</a>
						<div class="content-details">									
							<span class="content-views">
								{$albums[i].total_photos} {if $albums[i].total_photos == '1'}{t c='photo.photo'}{else}{t c='photo.photos'}{/if}
							</span>
							{if $albums[i].rate != 0}
								<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$albums[i].rate}%</span></span>
							{/if}
						</div>
					</div>
				</div>			
			{/section}		
			</div>		
		</div>
		{/if}
		{if $favorites}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.FAVORITE_VIDEOS'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/user/{$user.username}/favorite/videos">{t c='global.view_all'}</a>
				</div>		
				<div class="clearfix"></div>
			</div>

			<div class="row content-row">
				{section name=i loop=$favorites}
					<div class="{if $max_col == '5'}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 col-xl-3 {if $smarty.section.i.index > 2} d-md-none d-xl-inline {/if}
								{else}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 {if $smarty.section.i.index > 2}d-md-none d-xl-none{/if}{/if}">
						<a href="{$relative}/video/{$favorites[i].VID}/{$favorites[i].title|clean}">
							<div class="thumb-overlay" {if $favorites[i].vthumbs == '1'} id="playvthumb_{$favorites[i].VID}"{/if}>
								<img src="{insert name=thumb_path vid=$favorites[i].VID}/{$favorites[i].thumb}.jpg" title="{$favorites[i].title|escape:'html'}" alt="{$favorites[i].title|escape:'html'}" {if $favorites[i].vthumbs == '0'}id="rotate_{$favorites[i].VID}_{$favorites[i].thumbs}_{$favorites[i].thumb}_viewed"{/if} class="img-responsive {if $favorites[i].type == 'private'}img-private{/if}"/>
								{if $favorites[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
								<div class="duration">
									{if $favorites[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
									{insert name=duration assign=duration duration=$favorites[i].duration}
									{$duration}
								</div>
							</div>
						</a>
						<div class="content-info">
							<a href="{$relative}/video/{$favorites[i].VID}/{$favorites[i].title|clean}">
								<span class="content-title">{$favorites[i].title|escape:'html'}</span>					
							</a>
							<div class="content-details">
								{insert name=views assign=s_views views=$favorites[i].viewnumber}											
								<span class="content-views">
									{$s_views}								
								</span>
								{if $favorites[i].rate != 0}
									<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$favorites[i].rate}%</span></span>
								{/if}
							</div>				
						</div>
					</div>			
				{/section}
			</div>		
		</div>		
		{/if}
		{if $photos && $photo_module == '1'}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.FAVORITE_PHOTOS'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/user/{$user.username}/favorite/photos">{t c='global.view_all'}</a>
				</div>		
				<div class="clearfix"></div>
			</div>	
			<div class="row content-row">
			{section name=i loop=$photos}
				<div class="{if $max_col == '5'}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 col-xl-3 {if $smarty.section.i.index > 2} d-md-none d-xl-inline {/if}
							{else}{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 {if $smarty.section.i.index > 2}d-md-none d-xl-none{/if}{/if}">
					<a href="{$relative}/photo/{$photos[i].PID}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/photos/tmb/{$photos[i].PID}.jpg" title="{$photos[i].caption|escape:html}" alt="{$photos[i].caption|escape:html}" class="img-responsive {if $photos[i].type == 'private'}img-private{/if}"/>
							{if $photos[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
						</div>
					</a>
					<div class="content-info">
						<a href="{$relative}/album/{$photos[i].AID}/{$photos[i].name|clean}">
							<span class="content-title">{$photos[i].caption|escape:'html'}</span>
						</a>
						<div class="content-details">	
							{insert name=views assign=s_views views=$photos[i].total_views}											
							<span class="content-views">
								{$s_views}								
							</span>
							{if $photos[i].rate != 0}
								<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$photos[i].rate}%</span></span>
							{/if}
						</div>
					</div>
				</div>			
			{/section}
			</div>
		</div>
		{/if}
		{if $show_wall}
			{if $wall_comments == '1'}			
				<script type="text/javascript">
					var lang_comments_confirm_delete 		= "{t c='comments.delete_confirm'}";
					var lang_comments_reply 		 		= "{t c='global.reply'}";				
					var lang_comments_view_more_replies	 	= "{t c='comments.view_more_replies'}";								
					var lang_comments_insert_media   		= "{t c='comments.insert_media'}";		
					var lang_cancel					   		= "{t c='global.cancel'}";						
				</script>		
				<div class="comments-section">
					<div class="modal fade" id="commentsMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-body">
									<nav>
										<div class="nav nav-tabs" role="tablist">
										<a class="nav-item nav-link active" id="nav-cvideos-tab" data-toggle="tab" href="#nav-cvideos" role="tab" aria-controls="nav-cvideos" aria-selected="true">{t c='global.videos'}</a>
										<a class="nav-item nav-link" id="nav-cphotos-tab" data-toggle="tab" href="#nav-cphotos" role="tab" aria-controls="nav-cphotos" aria-selected="false">{t c='global.photos'}</a>
										</div>
									</nav>
									<div class="tab-content">
										<div class="tab-pane fade show active" id="nav-cvideos" role="tabpanel" aria-labelledby="nav-cvideos-tab">
											<input type="text" class="form-control" placeholder="{t c='global.search_videos'}" id="search-cvideos" value="" autocomplete="off">
											<div id="info-cvideos"></div>
											<div class="clearfix"></div>
											<div id="cvideos-container">
											</div>
											<div id="cvideos-loader"><i class="fas fa-circle-notch fa-spin fa-2x"></i></div>
										</div>
										<div class="tab-pane fade" id="nav-cphotos" role="tabpanel" aria-labelledby="nav-cphotos-tab">
											<input type="text" class="form-control" placeholder="{t c='global.search_photos'}" id="search-cphotos" value="" autocomplete="off">
											<div id="info-cphotos"></div>
											<div class="clearfix"></div>
											<div id="cphotos-container">
											</div>
											<div id="cphotos-loader"><i class="fas fa-circle-notch fa-spin fa-2x"></i></div>									
										</div>
									</div>
									<input id="insert_media_target" type="hidden" value="">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary btn-bold" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>		
					{assign var="comment_section" value="wall"}
					<div class="well-filters mb-1">
						<div class="float-left mr-3">
							<h1><i class="fas fa-comments"></i> {t c='global.COMMENTS'}</h1>
						</div>
						<div class="float-left">
							<h1>
								<a id="comments_sort" href="#" data-id="{$user.UID}" data-type="{$comment_section}" data-sort="newest" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-sort-amount-down"></i></a>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="comments_sort">
									<a class="dropdown-item active" data-sort="newest" id="comments_sort_newest" href="#">
										{t c='comments.newest'}
									</a>							
									<a class="dropdown-item" data-sort="top" id="comments_sort_top" href="#">
										{t c='comments.top_comments'}
									</a>
								</div>							
							</h1>
						</div>
						<div class="float-left ml-3">
							<h1>
								<span id="sort_loading"></span>					
							</h1>
						</div>
						<div class="float-right">
							<h1><span id="comments_total">{$comments_total}</span></h1>
						</div>	
						<div class="clearfix"></div>
					</div>
					<div id="comments_input_container">
						<textarea data-id="{$user.UID}" data-type="{$comment_section}" id="comments_input" rows="3"  maxlength="1000" class="form-control" {if !isset($smarty.session.uid)}disabled{/if}></textarea>
						<span id="comments_login_register" class="{if isset($smarty.session.uid)}d-none{/if}">{t c='comments.login_register'}</span>					
					</div>
					{if isset($smarty.session.uid)}
					<div id="comments_btn_container">
						<a id="post_comment" href="#" class="btn btn-secondary btn-sm">{t c='comments.post_comment'}</a>
						<span data-toggle="tooltip" data-placement="top" title="{t c='comments.insert_media'}"><a id="insert_media" href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#commentsMediaModal"><i class="fas fa-paperclip"></i></a></span>
						<span id="comment_response" class="comment-response"></span>
					</div>
					{/if}
					<div id="comments_list" class="comments-list">
					{if $comments}
						{section name=i loop=$comments}
						{insert name=time_range assign=addtime time=$comments[i].addtime}
						{insert name=comment_output assign=comment comment=$comments[i].message}	
						{insert name=total_replies assign=total_replies cid=$comments[i].CID type=$comment_section}	
						<div class="comment-item" id="comment_{$comments[i].CID}">
							<div class="comment-user">
								<a href="{$relative}/user/{$comments[i].username}">
									<img src="{$relative}/media/users/{if $comments[i].photo != ''}{$comments[i].photo}{else}nopic-{$comments[i].gender}.gif{/if}" alt="{$comments[i].username}">
								</a>						
							</div>    
							<div class="comment-info">
								<div class="comment-body">
									<div class="comment-actions">							
										<a id="comment_actions_{$comment_section}_{$comments[i].CID}" data-uid="{$comments[i].UID}" data-rel="{$comment_section}_{$comments[i].CID}" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-h"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="comment_actions_{$comment_section}_{$comments[i].CID}">
											<a class="dropdown-item {if $smarty.session.uid == $comments[i].UID}d-none{/if}" id="report_comment_{$comment_section}_{$comments[i].CID}" href="#">
												<i class="fas fa-flag"></i> {t c='global.report_spam'}
											</a>							
											<a class="dropdown-item {if $smarty.session.uid != $comments[i].UID}d-none{/if}" id="delete_comment_{$comment_section}_{$comments[i].CID}" href="#">
												<i class="fas fa-trash"></i> {t c='global.delete'}
											</a>
										</div>					
									</div>
									<div class="comment-user-info">
										<a class="comment-username" href="{$relative}/user/{$comments[i].username}">{$comments[i].username}</a>
										<span class="comment-add-time"><i class="far fa-clock"></i>{$addtime}</span>	
									</div>
									<div class="comment-text">
										{$comment|nl2br}
									</div>
									<div class="comment-meta">
										<div class="vote-box">
											<span class="content-rating">
												<span class="vote-up mr-1"><i id="comment_vote_up_{$comment_section}_{$comments[i].CID}" class="fas fa-thumbs-up"></i><span id="comment_rate_{$comment_section}_{$comments[i].CID}">{$comments[i].rate}</span></span>		
												<span class="vote-down"><i id="comment_vote_down_{$comment_section}_{$comments[i].CID}" class="fas fa-thumbs-down"></i></span>						
											</span>	
										</div>
										<div class="comment-reply">
											<a id="comment_reply_{$comment_section}_{$comments[i].CID}" data-id="{$comments[i].CID}" data-type="{$comment_section}" data-reply-username="" class="" href="#"><i class="fas fa-share"></i>{t c='global.reply'}</a>								
										</div>
									</div>								
								</div>
							</div>
							<div class="comment-replies">
								<div class="comment-reply-container d-none" id="reply_container_{$comment_section}_{$comments[i].CID}"></div>
								<div class="comments-list replies-list" id="replies_more_{$comment_section}_{$comments[i].CID}"></div>
								<div class="comments-list replies-list" id="replies_list_{$comment_section}_{$comments[i].CID}"></div>
								{if $total_replies > 0}							
									<div id="replies_show_hide_container_{$comment_section}_{$comments[i].CID}" class="replies-show-hide-container">
										<a id="replies_show_more_{$comment_section}_{$comments[i].CID}" class="replies-show-more" data-page="1" data-type="{$comment_section}" data-id="{$comments[i].CID}" href="#">{if $total_replies == 1}{t c='comments.view_reply'}{else}{t c='comments.view_replies'} <span id="replies_total_{$comment_section}_{$comments[i].CID}">{$total_replies}</span>{/if}<i class="fas fa-chevron-down"></i></a>
										<a id="replies_show_more_{$comment_section}_{$comments[i].CID}_" class="replies-show-more replies-view-more" data-page="1" data-type="{$comment_section}" data-id="{$comments[i].CID}" href="#">{t c='comments.view_more_replies'} <span id="replies_total_{$comment_section}_{$comments[i].CID}_">0</span><i class="fas fa-chevron-down"></i></a>							
										<a id="replies_hide_{$comment_section}_{$comments[i].CID}" class="replies-hide" data-type="{$comment_section}" data-id="{$comments[i].CID}" href="#">{if $total_replies == 1}{t c='comments.hide_reply'}{else}{t c='comments.hide_replies'}{/if}<i class="fas fa-chevron-up"></i></a>
										<span class="reply-response" id="replies_loading_{$comment_section}_{$comments[i].CID}"></span>															
									</div>
								{/if}							
							</div>
						</div>					
						{/section}
					{/if}			
					</div>
					<div id="comments_more" class="comments-list">
					</div>				
					{if $comments_total > 10}
						<a href="#" id="comments_show_more" class="comments-show-more" data-page="2" data-type="{$comment_section}" data-id="{$user.UID}">{t c='global.show_more'}<i class="fas fa-chevron-down"></i></a>
						<a href="#" id="comments_hide" class="comments-hide">{t c='global.hide'}<i class="fas fa-chevron-up"></i></a>
						<span id="comments_loading"></span>
					{/if}
				</div>
			{/if}
		{/if}
	</div>

</div>

