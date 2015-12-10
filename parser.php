<html>
<head>
	<title>:: LogISO8583 Parser ::</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<style type=text/css>
html {
 overflow-y: scroll;
}

.footer{
	margin-top:45px;
	border-top: 1px solid #eaeaea;
	color: gray-light;
	small{
		float: center;
	}
}

.pull-left{
	margin-left: 30px;
}
</style>
<body>
<header class = "navbar navbar-fixed navbar-static-top navbar-inverse">
		<div class="pull-left">
			<!--<a class="brand" href="#"></a>-->
			<font color=white><h2><img src="aset/fmlogo.png" alt="fm" style="width:35px; heigth:57px;"> ISO8583 Parser</h2></font>
		</div>
</header>
<div class="container">
	<div class="col-md-9">
		<!-- <div class="page-header">
			<h2>ISO 8583 Parser</h2>
		</div> -->
			<div class="row">
				<div class="col-md-6">
					<form method="POST" action="http://10.200.3.3/iso8583/parser_result.php" role="form"">
					<!-- <form action="" method="POST" id="pr"> -->
							<div class="form-group">
									<label for="ISOMessage" class="col-sm-6 control-label col-sm-pad">ISO Message Data :</label>
							</div>
							<div class="form-group">
								<div class="col-sm-6 col-sm-pad">
									<textarea id="isomsg" style="padding:0px;" rows="10" cols="70" name="isomsg"></textarea>
									<!--<textarea id="isomsg" style="padding:0px; width:550px; height:50px;"></textarea>-->
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6 col-sm-pad">
									<input class="btn btn-success" type="submit" value="Parse">
									<input class="btn" type="reset" value="Reset">
								</div>
							</div>
					</form>
				</div>	
			</div>
		<div class="footer">
			<small>
				<center>Copyright 2015 INFOKOM ELEKTRINDO</center>
			</small>
		</div>
	</div>
</div>
</body>
</html>