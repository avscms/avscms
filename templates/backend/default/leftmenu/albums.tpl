			<li class="{if $active_menu == 'albums'}open{/if}">
				<a href="javascript:;">
					<i class="fa fa-camera"></i>
					<span class="title">Albums</span>
					<span class="arrow {if $active_menu == 'albums'}open{/if}"></span>					
				</a>
				<ul class="sub-menu" {if $active_menu == 'albums'}style="overflow: hidden; display: block;"{/if}>
					<li class="{if $sub_menu == 'manage-albums'}active{/if}">
						<a href="albums.php?m=all&all=1">Manage Albums</a>						
					</li>
					<li class="{if $sub_menu == 'album-requests'}open active{/if}">
						<a href="javascript:;"><span class="title">Requests</span><span class="arrow {if $sub_menu == 'album-requests'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'album-requests'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'flagged' && $sub_menu == 'album-requests'}active{/if}"><a href="albums.php?m=flagged&all=1">Flagged</a></li>
							<li class="{if $module == 'spam' && $sub_menu == 'album-requests'}active{/if}"><a href="albums.php?m=spam">Spam</a></li>
						</ul>						
					</li>
					<li class="{if $sub_menu == 'add-albums'}open active{/if}">
						<a href="javascript:;"><span class="title">Add Albums</span><span class="arrow {if $sub_menu == 'add-albums'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'add-albums'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $sub_menu == 'add-albums' && $module == 'add'}active{/if}"><a href="albums.php?m=add">Add Album</a></li>
						</ul>						
					</li>					
				</ul>
			</li>