			<li class="{if $active_menu == 'blogs'}open{/if}">
				<a href="javascript:;">
					<i class="fa fa-pencil"></i>
					<span class="title">Blogs</span>
					<span class="arrow {if $active_menu == 'blogs'}open{/if}"></span>					
				</a>
				<ul class="sub-menu" {if $active_menu == 'blogs'}style="overflow: hidden; display: block;"{/if}>
					<li class="{if $sub_menu == 'manage-blogs'}open active{/if}">
						<a href="blogs.php?m=all&all=1">Manage Blogs</a>
					</li>
					<li class="{if $sub_menu == 'blog-requests'}open active{/if}">
						<a href="javascript:;"><span class="title">Requests</span><span class="arrow {if $sub_menu == 'blog-requests'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'blog-requests'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'spam' && $sub_menu == 'blog-requests'}active{/if}"><a href="blogs.php?m=spam">Spam</a></li>
						</ul>						
					</li>				
				</ul>
			</li>