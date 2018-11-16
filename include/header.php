<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><h1><img src="images/logo1.png" alt="" /></h1></a>
		</div>

		<div id="navbar" class="navbar-collapse collapse">
			<div class="top-search">
				<form class="navbar-form navbar-right">
					<input type="text" class="form-control" placeholder="Search...">
					<input type="submit" value=" ">
				</form>
			</div>
			<div class="header-top-right">

				<a><?=$_GET['userFullname']?></a>

				
				<div class="signin">
					<button href="" onclick="mncdigLogout()" class="btn btn-info">Log Out</button>
				</div>

			
				<div class="signin">
					<button href="" onclick="mncdigRegister()" class="btn btn-info">Sign Up</button>
				</div>

				<div class="signin">
					<button href="" onclick="mncdigLogin('CAjRrVH4uhnyp0sh')" class="btn btn-info">Log In</button>
				</div>

				<div class="clearfix"> </div>

			
			</div>

		</div>
		<div class="clearfix"> </div>
	</div>
</nav>