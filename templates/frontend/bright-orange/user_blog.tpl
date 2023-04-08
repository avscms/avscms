<script type="text/javascript">
var lang_blogs_delete_confirm = "{t c='blogs.delete_confirm'}";
</script>
<div class="container mt-3">
	{include file='user_info.tpl'}
	<div class="user-right">
		{if $blogs}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='global.blog'}</h1>
				</div>	
				<div class="clearfix"></div>
			</div>
			<div class="well-info">
				{if $blogs}
				{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$blogs_total}</span> {t c='blog.blog_art'}.
				{/if}
			</div>				
			<div class="row {if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}my{/if}">
				{section name=i loop=$blogs}
				<div id="blog_block_{$blogs[i].BID}" class="col-12">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title"><a href="{$relative}/blog/{$blogs[i].BID}/{$blogs[i].title|clean}">{$blogs[i].title|escape:'html'}</a></h5>
							<p class="card-text">{$blogs[i].content|nl2br}</p>
							<div class="card-sub">
								<div class="float-left">
								{if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}
									<a href="{$relative}/blog/edit/{$blogs[i].BID}/{$blogs[i].title|clean}" data-toggle="tooltip" data-placement="top" title="{t c='global.edit'}"><i class="fas fa-edit"></i></a>
									<a href="#" data-bid="{$blogs[i].BID}" id="delete_blog_{$blogs[i].BID}"  data-toggle="tooltip" data-placement="top" title="{t c='global.delete'}" class="ml-2"><i class="fas fa-trash"></i></a>
								{/if}
								</div>
								{insert name=time_range assign=addtime time=$blogs[i].addtime}
								<div class="float-right">
									{$blogs[i].total_views} <i class="fas fa-eye"></i> &nbsp; {$addtime}						
								</div>
							</div>
						</div>
					</div>
				</div>
				{/section}				
			</div>		
			{if $page_link}			
				<div class="d-block d-sm-none">
					<ul class="pagination pagination-lg">{$page_link}</ul>
				</div>
				<div class="d-none d-sm-block">
					<ul class="pagination">{$page_link}</ul>
				</div>					
			{/if}			
		</div>	
		{else}
		<div class="well well-sm">
			<span class="text-danger">{t c='blog.none'}.</span>
		</div>
		{/if}
	</div>
</div>

