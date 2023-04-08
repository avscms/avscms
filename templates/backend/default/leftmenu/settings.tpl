			<li class="{if $active_menu == 'settings'}open{/if}">
				<a href="javascript:;">
					<i class="fa fa-gear"></i>
					<span class="title">Settings</span>
					<span class="arrow {if $active_menu == 'settings'}open{/if}"></span>					
				</a>
				<ul class="sub-menu" {if $active_menu == 'settings'}style="overflow: hidden; display: block;"{/if}>
					<li class="{if $sub_menu == 'general'}open active{/if}">
						<a href="javascript:;"><span class="title">General</span><span class="arrow {if $sub_menu == 'general'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'general'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'admin'}active{/if}"><a href="index.php?m=admin">Account Settings</a></li>
							<li class="{if $module == 'main'}active{/if}"><a href="index.php?m=main">System Settings</a></li>
							<li class="{if $module == 'check'}active{/if}"><a href="index.php?m=check">System Check</a></li>
							<li class="{if $module == 'mail'}active{/if}"><a href="index.php?m=mail">Mail Configuration</a></li>
							<li class="{if $module == 'static'}active{/if}"><a href="index.php?m=static">Static Pages</a></li>
							<li class="{if $module == 'socialsignin'}active{/if}"><a href="index.php?m=socialsignin">Social Sign-in</a></li>
							<li class="{if $module == 'captcha'}active{/if}"><a href="index.php?m=captcha">Captcha Protection</a></li>						
							<li class="{if $module == 'analytics'}active{/if}"><a href="index.php?m=analytics">Google Analytics</a></li>
							<li class="{if $module == 'logo'}active{/if}"><a href="index.php?m=logo">Logo</a></li>
						</ul>						
					</li>
					<li class="{if $sub_menu == 'video-conversion'}open active{/if}">
						<a href="javascript:;"><span class="title">Video Conversion</span><span class="arrow {if $sub_menu == 'video-conversion'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'video-conversion'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'media'}active{/if}"><a href="index.php?m=media">Configuration</a></li>
							<li class="{if $module == 'encoding'}active{/if}"><a href="index.php?m=encoding&all=1">H264 Encodings</a></li>
							<li class="{if $module == 'encodingadd'}active{/if}"><a href="index.php?m=encodingadd">Add Encoding</a></li>							
						</ul>						
					</li>
					<li class="{if $sub_menu == 'security'}open active{/if}">
						<a href="javascript:;"><span class="title">Security</span><span class="arrow {if $sub_menu == 'security'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'security'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'modules'}active{/if}"><a href="index.php?m=modules">Modules</a></li>
							<li class="{if $module == 'permissions'}active{/if}"><a href="index.php?m=permissions">General Permissions</a></li>
							<li class="{if $module == 'userpermisions'}active{/if}"><a href="index.php?m=userpermisions">User Permisions</a></li>							
							<li class="{if $module == 'bandwidth'}active{/if}"><a href="index.php?m=bandwidth">Bandwidth</a></li>
							<li class="{if $module == 'sessions'}active{/if}"><a href="index.php?m=sessions">Sessions</a></li>
							<li class="{if $module == 'bans'}active{/if}"><a href="index.php?m=bans&all=1">Bans</a></li>
						</ul>
					</li>
					<li class="{if $sub_menu == 'email-templates'}open active{/if}">
						<a href="javascript:;"><span class="title">Email Templates</span><span class="arrow {if $sub_menu == 'email-templates'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'email-templates'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'emails'}active{/if}"><a href="index.php?m=emails">View Email Templates</a></li>
							<li class="{if $module == 'emailadd'}active{/if}"><a href="index.php?m=emailadd">Add Email Template</a></li>
						</ul>						
					</li>
					<li class="{if $sub_menu == 'advertising-settings'}open active{/if}">
						<a href="javascript:;"><span class="title">Advertising Settings</span><span class="arrow {if $sub_menu == 'advertising-settings'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'advertising-settings'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'advgroups'}active{/if}"><a href="index.php?m=advgroups&all=1">Ad Zones (Groups)</a></li>
							<li class="{if $module == 'advs'}active{/if}"><a href="index.php?m=advs&all=1">Banner Ads</a></li>
							<li class="{if $module == 'advpause'}active{/if}"><a href="index.php?m=advpause&all=1">Player Pause Ads</a></li>
							<li class="{if $module == 'advvastvpaid'}active{/if}"><a href="index.php?m=advvastvpaid&all=1">Player Vast-Vpaid Ads</a></li>
							<li class="{if $module == 'advadd'}active{/if}"><a href="index.php?m=advadd">Add Banner Ad</a></li>
							<li class="{if $module == 'advpauseadd'}active{/if}"><a href="index.php?m=advpauseadd">Add Player Pause Ad</a></li>							
							<li class="{if $module == 'advvastvpaidadd'}active{/if}"><a href="index.php?m=advvastvpaidadd">Add Player Vast-Vpaid Ad</a></li>
						</ul>						
					</li>
					<li class="{if $sub_menu == 'player-settings'}open active{/if}">
						<a href="javascript:;"><span class="title">Player Settings</span><span class="arrow {if $sub_menu == 'player-settings'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'player-settings'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'player' || $module == 'playeredit'}active{/if}"><a href="index.php?m=player">Player Profiles</a></li>
							<li class="{if $module == 'playerlogo'}active{/if}"><a href="index.php?m=playerlogo">Player Logo</a></li>							
						</ul>						
					</li>	
					<li class="{if $sub_menu == 'update'}open active{/if}">
						<a href="javascript:;"><span class="title">Updates</span><span class="arrow {if $sub_menu == 'update'}open{/if}"></span></a>
						<ul class="sub-menu" {if $sub_menu == 'update'}style="overflow: hidden; display: block;"{/if}>
							<li class="{if $module == 'update' || $module == 'update-step1' || $module == 'update-step2' || $module == 'update-step3'}active{/if}"><a href="index.php?m=update">Check Updates</a></li>				
						</ul>						
					</li>					
				</ul>
			</li>
