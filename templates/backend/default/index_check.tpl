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
				<ul class="nav nav-tabs" id="tab-01">
					<li {if $s==''}class="active"{/if}><a href="#tab1"><b>Directory Permissions</b>&nbsp;{if !$err.directory}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</a></li>
					<li {if $s=='fp'}class="active"{/if}><a href="#tab2"><b>File Permissions</b>&nbsp;{if !$err.file}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</a></li>
					<li><a href="#tab3"><b>PHP Configuration</b>&nbsp;{if !$err.php}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</a></li>
					<li {if $s=='cr'}class="active"{/if}><a href="#tab4"><b>Conversion Requirements</b>&nbsp;{if !$err.requirements && !$err.support}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane{if $s==''} active{/if}" id="tab1">
						{if $err.directory}
							<form class="form-no-horizontal-spacing m-t-10 m-b-10" name="directory_permissions" method="POST" action="index.php?m=check">
								<input type="submit" name="directory_fix" value="Fix Permissions" class="btn btn-success btn-cons">
							</form>
						{/if}
						<table class="table table-hover no-more-tables">
							<thead>
								<tr>
									<!-- <th>#</th> -->
									<th>Path</th>
									<th>Check Result</th>								
									<th>Permissions</th>
								</tr>
							</thead>
							<tbody>
								{section name=i loop=$directory}
								<tr>
									<!-- <td>{$smarty.section.i.index}</td> -->
									<td>{$directory[i].path} </td>
									<td class="{if $directory[i].result != 'writable'}text-error{/if}">{$directory[i].result}</td>								
									<td class="{if $directory[i].permission != '0777'}text-error{/if}">
										<div class="pull-left">{$directory[i].permission}</div>
										<div class="pull-right">{if $directory[i].permission == '0777'}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</div>
									</td>
								</tr>															
								{/section}						
							</tbody>
						</table>					
					</div>
					<div class="tab-pane{if $s=='fp'} active{/if}" id="tab2">
						{if $err.file}
							<form class="form-no-horizontal-spacing m-t-10 m-b-10" name="file_permissions" method="POST" action="index.php?m=check&s=fp">
								<input type="submit" name="file_fix" value="Fix Permissions" class="btn btn-success btn-cons">
							</form>
						{/if}
						<table class="table table-hover no-more-tables">
							<thead>
								<tr>
									<!-- <th>#</th> -->
									<th>Path</th>
									<th>Check Result</th>								
									<th>Permissions</th>
								</tr>
							</thead>
							<tbody>
								{section name=i loop=$file}
								<tr>
									<!-- <td>{$smarty.section.i.index}</td> -->
									<td>{$file[i].path} </td>
									<td class="{if $file[i].result != 'writable'}text-error{/if}">{$file[i].result}</td>								
									<td class="{if $file[i].permission != '0777'}text-error{/if}">
										<div class="pull-left">{$file[i].permission}</div>
										<div class="pull-right">{if $file[i].permission == '0777'}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</div>
									</td>
								</tr>															
								{/section}						
							</tbody>
						</table>
					</div>			
					<div class="tab-pane" id="tab3">
						<table class="table table-hover no-more-tables">
							<thead>
								<tr>
									<th>Name</th>
									<th>Value / Check Result</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Safe Mode</td>
									<td class="{if $restrictions.safe_mode != ''}text-error{/if}">
										<div class="pull-left">{if $restrictions.safe_mode == ''}passed{else}{$restrictions.safe_mode}{/if}</div>
										<div class="pull-right">{if $restrictions.safe_mode == ''}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</div>
									</td>								
								</tr>
								<tr>
									<td>Open Basedir</td>
									<td class="{if $restrictions.open_basedir != ''}text-error{/if}">
										<div class="pull-left">{if $restrictions.open_basedir == ''}passed{else}{$restrictions.open_basedir}{/if}</div>
										<div class="pull-right">{if $restrictions.open_basedir == ''}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</div>											
									</td>								
								</tr>
								<tr>
									<td>Maximum Upload Filesize</td>
									<td>
										<div class="pull-left">{$upload.max_upload_size}</div>
										<div class="pull-right"><i class="fa fa-asterisk text-info"></i></div>
									</td>								
								</tr>
								<tr>
									<td>Maximum Post Filesize</td>
									<td>
										<div class="pull-left">{$upload.max_post_size}</div>
										<div class="pull-right"><i class="fa fa-asterisk text-info"></i></div>
									</td>							
								</tr>								
							</tbody>
						</table>
						<div class="pull-right" style="padding-right: 13px">
							<i class="fa fa-asterisk text-info"></i> - maximum file upload size
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="tab-pane{if $s=='cr'} active{/if}" id="tab4">
						{if $err.requirements}
							<form class="form-no-horizontal-spacing m-t-10 m-b-10" name="requirements_results" method="POST" action="index.php?m=check&s=cr">
								<input type="submit" name="autofind_paths" value="Autofind Paths" class="btn btn-success btn-cons">
							</form>
						{/if}
						<table class="table table-hover no-more-tables">
							<thead>
								<tr>
									<th>Name</th>
									<th>Path</th>
									<th>Check Result</th>								
								</tr>
							</thead>
							<tbody>
								{section name=i loop=$requirements}
								<tr>
									<td>{$requirements[i].name}</td>								
									<td>{$requirements[i].path}</td>					
									<td class="{if $requirements[i].result != 'found'}text-error{/if}">
										<div class="pull-left">{$requirements[i].result}</div>
										<div class="pull-right">{if $requirements[i].result == 'found'}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</div>
									</td>
								</tr>															
								{/section}
								{section name=i loop=$support}
								<tr>
									<td><i>{$support[i].name}</i></td>				
									<td>{$support[i].path}</td>
									<td class="{if $support[i].result != 'found'}text-error{/if}">
										<div class="pull-left">{$support[i].result}</div>
										<div class="pull-right">{if $support[i].result == 'found'}<i class="fa fa-check text-success"></i>{else}<i class="fa fa-exclamation-triangle text-error"></i>{/if}</div>
									</td>
								</tr>															
								{/section}									
							</tbody>
						</table>
							
					</div>
				</div>	
			</div>			
			<!-- END PLACE PAGE CONTENT HERE -->
		</div>
	</div>
	<!-- END PAGE CONTAINER -->	