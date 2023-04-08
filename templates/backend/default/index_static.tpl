	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content"> 
		<div class="content">  
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<i class="icon-custom-left"></i>
				<h3>Settings - <span class="semi-bold">General</span></h3>
			</div>
			{include file="errmsg.tpl"}
			<!-- END PAGE TITLE -->
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="col-md-12">
				<div class="grid simple">
					<div class="grid-title no-border">
						<h4>Static <span class="semi-bold">Pages</span></h4>
					</div>
					<div class="grid-body no-border">
						<form class="form-no-horizontal-spacing" name="static_pages" method="POST" action="index.php?m=static&page={$page}">
							<div class="row">
								<div class="col-xs-12">
									<h3>Edit <span class="semi-bold">Static Pages</span></h3>
									<div class="p-b-10">
										Select a page for editing:
									</div>
									<div class="p-b-20">
										<div class="btn-group"> <a class="btn btn-success dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"> {if $page == '2257.tpl'}2257{elseif $page == 'advertise.tpl'}Advertise{elseif $page == 'dmca.tpl'}DMCA{elseif $page == 'faq.tpl'}FAQ{elseif $page == 'privacy.tpl'}Privacy Policy{elseif $page == 'terms.tpl'}Terms and Conditions{elseif $page == 'webmasters.tpl'}Webmasters{elseif $page == 'whatis.tpl'}What Is{/if} <span class="caret"></span> </a>
											<ul class="dropdown-menu">
												{if $page != '2257.tpl'}<li><a href="index.php?m=static&page=2257.tpl">2257</a></li>{/if}
												{if $page != 'advertise.tpl'}<li><a href="index.php?m=static&page=advertise.tpl">Advertise</a></li>{/if}
												{if $page != 'dmca.tpl'}<li><a href="index.php?m=static&page=dmca.tpl">DMCA</a></li>{/if}
												{if $page != 'faq.tpl'}<li><a href="index.php?m=static&page=faq.tpl">FAQ</a></li>{/if}
												{if $page != 'privacy.tpl'}<li><a href="index.php?m=static&page=privacy.tpl">Privacy Policy</a></li>{/if}
												{if $page != 'terms.tpl'}<li><a href="index.php?m=static&page=terms.tpl">Terms and Conditions</a></li>{/if}
												{if $page != 'webmasters.tpl'}<li><a href="index.php?m=static&page=webmasters.tpl">Webmasters</a></li>{/if}
												{if $page != 'whatis.tpl'}<li class="divider"></li>{/if}
												{if $page != 'whatis.tpl'}<li><a href="index.php?m=static&page=whatis.tpl">What Is</a></li>{/if}
											</ul>
										</div>									

									</div>
									<textarea name="page-content" id="page-content" rows='30' style="width:100%">{$spage}</textarea>
								</div>								
							</div>
							<div class="form-actions">
								<div class="pull-right">
									<input type="submit" name="submit_static" value="Save" class="btn btn-success btn-cons">
									<a href="index.php" class="btn btn-white btn-cons">Cancel</a>
								</div>
							</div>							
						</form>
					</div>
				</div>
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	