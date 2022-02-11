<html lang="en" ng-app="Neaop">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Ne-aop</title>
		<link rel="stylesheet" type="text/css" href="app/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="app/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="app/css/sb-admin-2.css" />
		<link rel="stylesheet" type="text/css" href="app/css/toastr.min.css" />
		<link rel="stylesheet" type="text/css" href="app/css/neaop.css" />
		<link rel="stylesheet" type="text/css" href="app/css/bootstrap-dialog.min.css" />
		<link rel="stylesheet" type="text/css" href="app/css/metisMenu.min.css" />
		<link rel="stylesheet" type="text/css" href="app/css/angular-ui-tree.min.css" />
	</head>
	<body ng-controller="AppCtrl">
		<div class="splash" ng-hide="hideSplash">
			<div style="margin-top: 200px;">Neaop</div>
			<div style="margin-top: 20px;">Loading...</div>
			<div style="margin-top: 20px;"><i class="fa fa-spinner fa-spin"></i></div>
		</div>
		
		<div ng-include="'app/templates/partials/navbar.html'" ng-if="logged"></div>


		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12 content">
	 				<div ng-view></div>
	 			</div>
	 		</div>
 		</div>

 		<footer class="footer">
 			<div class="container"> 
 				<div class="row">
 					NEAOP/A-A
 					<div class="pull-right ">
 						v0.0.1
 					</div>
 				</div>
 			</div>
	 	</footer>

		<script type="text/javascript" src="app/js/vendor/jquery.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/bootstrap.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/angular.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/angular-route.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/angular-translate.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/angular-translate-loader-static-files.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/toastr.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/ui-utils.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/bootstrap-dialog.min.js"></script>		
		<script type="text/javascript" src="app/js/vendor/metisMenu.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/metisMenu.min.js"></script>
		<script type="text/javascript" src="app/js/vendor/angular-ui-tree.min.js"></script>

		<script type="text/javascript" src="app/js/app.js"></script>
		<script type="text/javascript" src="app/js/routes.js"></script>
		<script type="text/javascript" src="app/js/settings/api.js"></script>
		<script type="text/javascript" src="app/js/settings/lang.js"></script>
		<script type="text/javascript" src="app/js/settings/dialog.js"></script>
		<script type="text/javascript" src="app/js/neaop.js"></script>

		<script type="text/javascript" src="app/js/controllers/pages/login/index.js"></script>
		<script type="text/javascript" src="app/js/controllers/pages/login/logout.js"></script>
		<script type="text/javascript" src="app/js/controllers/pages/profile-settings/index.js"></script>
		<script type="text/javascript" src="app/js/controllers/pages/roles/users/index.js"></script>
		<script type="text/javascript" src="app/js/controllers/pages/roles/permissions/index.js"></script>
		<script type="text/javascript" src="app/js/controllers/pages/settings/index.js"></script>
		<script type="text/javascript" src="app/js/controllers/pages/categories/index.js"></script>

		<script type="text/javascript" src="app/js/directives/user-data.js"></script>
		<script type="text/javascript" src="app/js/directives/second-menu.js"></script>
		<script type="text/javascript" src="app/js/directives/db-table.js"></script>
		<script type="text/javascript" src="app/js/directives/db-form.js"></script>
		<script type="text/javascript" src="app/js/directives/select-branches.js"></script>

	</body>
</html>
