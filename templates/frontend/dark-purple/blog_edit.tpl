<div class="container mt-3">
	<div class="well-filters">
		<h1>{t c='blog.edit'}: {$blog_title|escape:'html'}</h1>
	</div>
	<div class="row">
		<div class="col-12 mt-3 d-flex justify-content-center">		
			<form class="form-horizontal" name="addBlogForm" id="addBlogForm" method="post" action="{$relative}/blog/edit/{$bid}">
				<div class="form-group{if $err.title} has-error{/if}">
					<label for="blog_title">{t c='global.username'}</label>
					<input name="blog_title" type="text" class="form-control" value="{$blog_title}" maxlength="99" id="blog_title" placeholder="{t c='global.title'}" autocomplete="off">
				</div>

                <div class="form-group">
                    <textarea name="blog_content" id="blog_content"  class="form-control">{$blog_content}</textarea>
                </div>				
				<script>
					$(document).ready(function() {
						$('#blog_content').summernote({
							height: 300,   //set editable area's height
						});
					});
				</script>								
				<div class="form-group mt-3">
					<button name="blog_edit_submit" id="blog_submit" type="submit" class="btn btn-primary">{t c='global.update'}</button>						
				</div>				
			</form>
		</div>
	</div>
</div>