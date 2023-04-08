</div>
<!-- END CONTENT --> 
<!-- BEGIN CORE JS FRAMEWORK--> 
<script src="{$relative_tpl}/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script> 
<script src="{$relative_tpl}/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script> 
<script src="{$relative_tpl}/assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="{$relative_tpl}/assets/plugins/breakpoints.js" type="text/javascript"></script> 
<script src="{$relative_tpl}/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script> 
<script src="{$relative_tpl}/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script> 
<!-- END CORE JS FRAMEWORK --> 
<!-- BEGIN PAGE LEVEL JS --> 	
<script src="{$relative_tpl}/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
<script src="{$relative_tpl}/assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
<script src="{$relative_tpl}/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>

<script src="{$relative_tpl}/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
{if isset($editor)}
	<script src="{$relative_tpl}/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
	<script> $('#page-content').wysihtml5(); </script>
{/if}

{if $module == 'list'}
	<script type="text/javascript">
		var category_section = "video";
	</script>
{elseif $module == 'listalbum'}
	<script type="text/javascript">
		var category_section = "album";
	</script>
{/if}

{if $sub_menu == 'general'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.general.js" type="text/javascript"></script>
	{if $module == 'logo'}
		<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>	
	{/if}
	{if $module == 'check'}
		<script src="{$relative_tpl}/assets/js/tabs_accordian.js" type="text/javascript"></script>		
	{/if}
{elseif $sub_menu == 'video-conversion'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.video-conversion.js" type="text/javascript"></script>
{elseif $sub_menu == 'security'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.security.js" type="text/javascript"></script>
{elseif $module == 'advgroups'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.ad-zones.js" type="text/javascript"></script>
{elseif $module == 'advs'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.banner-ads.js" type="text/javascript"></script>
{elseif $module == 'advadd' || $module == 'advedit'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.banner-add.js" type="text/javascript"></script>
{elseif $module == 'advpause'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.pause-ads.js" type="text/javascript"></script>	
{elseif $module == 'advpauseadd' || $module == 'advpauseedit'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.pause-add.js" type="text/javascript"></script>
{elseif $sub_menu == 'email-templates'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.email-templates.js" type="text/javascript"></script>
{elseif $sub_menu == 'player-settings'}
	{if $player.profile}
		<script src="{$relative_tpl}/assets/js/admin/jquery.player-settings.js" type="text/javascript"></script>
		<script src="{$relative_tpl}/assets/plugins/boostrap-slider/js/bootstrap-slider.js" type="text/javascript"></script>		
	{elseif $module == 'playerlogo'}
		<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>	
	{/if}
	
{elseif $sub_menu == 'update'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.update.js" type="text/javascript"></script>	
{elseif $sub_menu == 'manage-videos'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.manage-videos.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.comments.js" type="text/javascript"></script>	
	<script type="text/javascript">
		var conf_remove_bb = "{$thumbnail_remove_bb}";
		var conf_keep_ar   = "{$thumbnail_keep_ar}";
	</script>
{elseif $sub_menu == 'requests'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.manage-videos.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.requests.js" type="text/javascript"></script>	
{elseif $sub_menu == 'add-videos'}
	<script type="text/javascript">
		var grabbing = "{$grabbing}";
		var path = "{$path}";
		var filesize = "{$filesize}";
	</script>
	{if $module == 'yt'}
		<script src="{$relative_tpl}/assets/js/admin/jquery.yt.js" type="text/javascript"></script>	
		<script src="{$relative_tpl}/assets/js/tabs_accordian.js" type="text/javascript"></script>			
	{/if}		
	<script src="{$relative_tpl}/assets/js/admin/jquery.add-videos.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>	
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>	
	<script src="{$relative_tpl}/assets/plugins/boostrap-slider/js/bootstrap-slider.js" type="text/javascript"></script>
{elseif $sub_menu == 'manage-albums'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.manage-albums.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.comments.js" type="text/javascript"></script>		
	<script src="{$relative_tpl}/assets/js/admin/imageareaselect/jquery.imgareaselect.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>		
{elseif $sub_menu == 'album-requests'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.manage-albums.js" type="text/javascript"></script>
{elseif $sub_menu == 'add-albums'}	
	<script src="{$relative_tpl}/assets/js/admin/jquery.add-albums.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>
{elseif $sub_menu == 'manage-blogs'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.manage-blogs.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.comments.js" type="text/javascript"></script>
{elseif $sub_menu == 'manage-users' || $sub_menu == 'user-requests'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/tabs_accordian.js" type="text/javascript"></script>	
	<script src="{$relative_tpl}/assets/js/admin/jquery.manage-users.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.comments.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>
{elseif $sub_menu == 'emails'}	
	<script src="{$relative_tpl}/assets/js/admin/jquery.emails.js" type="text/javascript"></script>
	<script> $('#email-content').wysihtml5(); </script>
{elseif $sub_menu == 'add-users'}
	<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>
{elseif $active_menu == 'channels'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.categories.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>	
{elseif $module == 'list_images'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.notice-images.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.file-box.js" type="text/javascript"></script>
{elseif $module == 'list_categories'}	
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.notice-categories.js" type="text/javascript"></script>
{elseif $active_menu == 'notices' && $module == 'add'}	
	<script src="{$relative_tpl}/assets/js/admin/jquery.notice-add.js" type="text/javascript"></script>
	<script> $('#notice-content').wysihtml5(); </script>
{elseif $active_menu == 'notices' && $module == 'list'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.manage-notices.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.comments.js" type="text/javascript"></script>
	<script> $('#edit-content').wysihtml5(); </script>
{elseif $active_menu == 'servers' && $module == 'all'}
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
	<script src="{$relative_tpl}/assets/js/admin/jquery.servers.js" type="text/javascript"></script>
{/if}
{if isset($plugin) && $plugin}
	<script src="{$relative_tpl}/assets/js/admin/{$plugin}" type="text/javascript"></script>
{/if}
{if $sub_menu == 'conversion-q'}
	<script src="{$relative_tpl}/assets/js/tabs_accordian.js" type="text/javascript"></script>
{/if}
<script type="text/javascript">
	var base_url = "{$baseurl}";
	var relative_tpl = "{$relative_tpl}";	
</script>
{if $active_menu == 'dashboard'}
	<script src="{$relative_tpl}/assets/plugins/jquery-ricksaw-chart/js/raphael-min.js"></script> 
	<script src="{$relative_tpl}/assets/plugins/jquery-morris-chart/js/morris.min.js"></script>
	<script src="{$relative_tpl}/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 	
	<script type="text/javascript">
	{literal}
	$(document).ready(function() {	

		Morris.Area({
		  element: 'member-registration',
		  data: [
			{/literal}{$m_chart}{literal}
		  ],
		  xkey: 'd',
		  ykeys: ['a'],
		  labels: ['Members'],
		  lineColors:['#634086'],
		  lineWidth:'0',
		   grid:'false',
		  fillOpacity:'0.5'
		});
		Morris.Line({
		  element: 'file-uploads',
		  data: [
			{/literal}{$f_chart}{literal}
		  ],
		  xkey: 'd',
		  ykeys: ['v', 'a'],
		  labels: ['Videos', 'Albums'],
		  lineColors:['#0090d9', '#0aa699'],
		  lineWidth:'2',
		});	
	});


	{/literal}
	</script>	
{/if}
<!-- END PAGE LEVEL PLUGINS --> 	

<!-- BEGIN CORE TEMPLATE JS --> 
<script src="{$relative_tpl}/assets/js/core.js" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS --> 

<!-- END NEED TO WORK ON -->
</body>
</html>