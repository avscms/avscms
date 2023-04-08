			<li class="{if $active_menu == 'users'}open{/if}">
				<a href="javascript:;">
					<i class="fa fa-users"></i>
					<span class="title">Users</span>
					<span class="arrow {if $active_menu == 'users'}open{/if}"></span>					
				</a>
				<ul class="sub-menu" {if $active_menu == 'users'}style="overflow: hidden; display: block;"{/if}>
					<li class="{if $sub_menu == 'manage-users'}open active{/if}">
						<a href="users.php?m=all&all=1">Manage Users</a>
					</li>
					<li class="{if $sub_menu == 'user-requests'}open active{/if}">
						<a href="javascript:;"><span class="title">Requests</span><span class="arrow {if $sub_menu == 'user-requests'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'user-requests'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'flagged' && $sub_menu == 'user-requests'}active{/if}"><a href="users.php?m=flagged&all=1">Flagged</a></li>
							<li class="{if $module == 'spam' && $sub_menu == 'user-requests'}active{/if}"><a href="users.php?m=spam">Spam</a></li>							
						</ul>						
					</li>
					<li class="{if $sub_menu == 'emails'}open active{/if}">
						<a href="javascript:;"><span class="title">Emails</span><span class="arrow {if $sub_menu == 'emails'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'emails'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'mail'}active{/if}"><a href="users.php?m=mail">Email User</a></li>
							<li class="{if $module == 'mailall'}active{/if}"><a href="users.php?m=mailall">Email All Users</a></li>							
						</ul>						
					</li>
					<li class="{if $sub_menu == 'add-users'}open active{/if}">
						<a href="javascript:;"><span class="title">Add Users</span><span class="arrow {if $sub_menu == 'add-users'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'add-users'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'add'}active{/if}"><a href="users.php?m=add">Add User</a></li>		
						</ul>						
					</li>					
				</ul>
			</li>