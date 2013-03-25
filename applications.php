<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Safe Environment</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<link href="<?php echo base_url();?>bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url();?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>flexigrid/css/flexigrid.pack.css" />
	<style type="text/css">
		html, body {
			height: 100%;
		}
		
		/* Wrapper for page content to push down footer */
		#wrap {
			min-height: 100%;
			height: auto !important;
			height: 100%;
			/* Negative indent footer by it's height */
			margin: 0 auto -40px;
		}
	  
		/* Set the fixed height of the footer here */
		#push,
		#footer {
			height: 40px;
		}
		#footer {
			background-color: #f5f5f5;
		}

		/* Custom page CSS
		-------------------------------------------------- */
		/* Not required for template or sticky footer method. */
		#wrap > .container-fluid {
			padding-top: 60px;
		}

		.container .credit {
			margin: 20px 0;
		}

		.sidebar-nav {
			padding: 9px 0;
		}

		@media (max-width: 980px) {
			/* Enable use of floated navbar text */
			.navbar-text.pull-right {
				float: none;
				padding-left: 5px;
				padding-right: 5px;
			}

			#footer {
				margin-left: -20px;
				margin-right: -20px;
				padding-left: 20px;
				padding-right: 20px;
			}

			#wrap > .container-fluid {
				padding-top: 0;
			}

		}
		
	</style>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="../assets/js/html5shiv.js"></script>
	<![endif]-->

</head>
<body>
	
	<!-- Part 1: Wrap all page content here -->
	<div id="wrap">

		<!-- Fixed navbar -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="#">Safe Environment</a>
					<div class="nav-collapse collapse">
						<p class="navbar-text pull-right">
							<a href="<?php echo base_url();?>users/logout">Logout</a>
						</p>
						<ul class="nav">
							<li class="active"><a href="#">Home</a></li>
							<li><a href="#about">About</a></li>
							<li><a href="#contact">Contact</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<!-- Begin page content -->
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span2">
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
						<li class="nav-header">Sidebar</li>
						<li class="active"><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						</ul>
					</div><!--/.well -->
				</div><!--/span-->
				<div class="span10">
					<div class="row-fluid" style="overflow: auto;">
						<table id="applications" style="display: none"></table>
					</div>
				</div><!--/span-->
			</div><!--/row-->
	    </div><!--/.fluid-container-->
		<div id="push"></div>
	</div>
	
	<div id="footer">
		<div class="container">
			<p>&copy; Company 2013</p>
		</div>
	</div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->	
	<script src="<?php echo base_url();?>js/jquery-1.8.3.min.js"></script>
	<script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>flexigrid/js/flexigrid.pack.js"></script>

	<script>
		$(function() {
			$("#applications").flexigrid({
				url: '<?php echo base_url();?>applications/get_all',
				dataType: 'json',
				colModel : [
					{display: 'Action', name : 'action', width : 40, sortable : false, align: 'left'},
					{display: 'Last Name', name : 'last_name', width : 60, sortable : true, align: 'left'},
					{display: 'First Name', name : 'first_name', width : 60, sortable : true, align: 'left', hide: false},
					{display: 'SSN', name : 'ssn', width : 60, sortable : true, align: 'left'},
					{display: 'Application Date', name : 'application_date', width : 80, sortable : true, align: 'right'},
					{display: 'External Status', name : 'ext_status', width : 80, sortable : true, align: 'left'},
					{display: 'Internal Status', name : 'int_status', width : 120, sortable : true, align: 'left'},
					{display: 'Last Status Update', name : 'last_status_update', width : 100, sortable : true, align: 'left'}
					],
				searchitems : [
					{display: 'First Name', name : 'first_name'},
					{display: 'Last Name', name : 'last_name', isdefault: true}
					],
				sortname: "last_name",
				sortorder: "desc",
				usepager: true,
				title: 'Applications',
				useRp: false,
				rp: 10,
				showTableToggleBtn: false,
				width: 700,
				height: 310,
				singleSelect: true
			});   
		});
	</script>
</body>
</html>