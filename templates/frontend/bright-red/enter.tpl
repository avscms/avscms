<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>
    <title>{if isset($self_title) && $self_title != ''}{$self_title|escape:'html'}{else}{$site_name}{/if}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">	
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 days" />
    <meta name="keywords" content="{if isset($self_keywords) && $self_keywords != ''}{$self_keywords|escape:'html'}{else}{$meta_keywords}{/if}" />
    <meta name="description" content="{if isset($self_description) && $self_description != ''}{$self_description|escape:'html'}{else}{$meta_description}{/if}" />

	<link rel="Shortcut Icon" type="image/ico" href="/favicon.ico" />
	<link rel="apple-touch-icon" href="{$relative_tpl}/img/webapp-icon.png">

    <script type="text/javascript">
    var base_url = "{$baseurl}";
    var tpl_url = "{$relative_tpl}";
	</script>
    <script src="https://code.jquery.com/jquery-3.1.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">	
	<link href="{$relative_tpl}/css/style.css" rel="stylesheet">
	<link href="{$relative_tpl}/css/enter.css" rel="stylesheet">	
	
</head>
<body>
	<div class="container">
	
	<table height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
	  <tbody>
	  <tr>
		<td valing="middle" align="center">
			<div class="enter">
				<img src="{$relative}/images/logo/logo.png" height="46" alt="{$site_name|escape:'html'}" title="{$site_name|escape:'html'}">
				<h3>
					WARNING: This website contains explicit adult material.
				</h3>
				<p>
					You may only enter this Website if you are at least
					18 years of age, or at least the age of majority in the jurisdiction
					where you reside or from which you access this Website.  If you do not
					meet these requirements, then you do not have permission to use the
					Website.
				</p>
				<a class="btn btn-primary" href="{$baseurl}">Enter</a>
				<a class="btn btn-default m-l-5" href="http://www.google.com">Leave</a>
			</div>		  
		</td>
	  </tr>
	  </tbody>
	</table>	
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{$relative_tpl}/js/bootstrap.min.js"></script>
	<script>
	{literal}
			if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
		  var msViewportStyle = document.createElement('style')
		  msViewportStyle.appendChild(
			document.createTextNode(
			  '@-ms-viewport{width:auto!important}'
			)
		  )
		  document.querySelector('head').appendChild(msViewportStyle)
		}
	{/literal}
	</script>
	
</body>
</html>