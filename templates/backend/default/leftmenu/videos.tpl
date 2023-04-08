			<li class="{if $active_menu == 'videos'}open{/if}">
				<a href="javascript:;">
					<i class="fa fa-video-camera"></i>
					<span class="title">Videos</span>
					<span class="arrow {if $active_menu == 'videos'}open{/if}"></span>					
				</a>
				<ul class="sub-menu" {if $active_menu == 'videos'}style="overflow: hidden; display: block;"{/if}>
					<li class="{if $sub_menu == 'manage-videos'}active{/if}">
						<a href="videos.php?m=all&all=1">Manage Videos</a>		
					</li>
					<li class="{if $sub_menu == 'requests'}open active{/if}">
						<a href="javascript:;"><span class="title">Requests</span><span class="arrow {if $sub_menu == 'requests'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'requests'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'flagged' && $sub_menu == 'requests'}active{/if}"><a href="videos.php?m=flagged&all=1">Flagged</a></li>
							<li class="{if $module == 'spam' && $sub_menu == 'requests'}active{/if}"><a href="videos.php?m=spam">Spam</a></li>
						</ul>						
					</li>
					<li class="{if $sub_menu == 'add-videos'}open active{/if}">
						<a href="javascript:;"><span class="title">Add Videos</span><span class="arrow {if $sub_menu == 'add-videos'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'add-videos'}style="overflow: hidden; display: block;"{/if}>
							{section name=i loop=$plugin_files}
								{include file="leftmenu/plugins/"|cat:$plugin_files[i]}
							{/section}
							<li class="{if $module == 'embed'}active{/if}"><a href="videos.php?m=embed">Embed Video</a></li>
						</ul>						
					</li>
					{if $conversion_q == '1'}
						<li class="{if $sub_menu == 'conversion_q'}active{/if}"><a href="videos.php?m=queue">Conversion Queue</a></li>
					{/if}					
				</ul>
			</li>
