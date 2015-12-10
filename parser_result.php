<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//																																			   //
//				iso8583/PARSER8583.php																						   //
//				LAST UPDATED: 10/12/2015 17:56:55 UTC+7	   														   //
//																																			   //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//include parser iso8583
include_once('ISO8583.class.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//$iso = '0200723A400108418002179714011515210003637000000000000000011170854259921121540231117111760100700070009008001540230000000040115050121000000032  360003POS';
//$iso	= '0800822000000000000004000000000000001201085803992256301';
//$iso = '0200723A400108418002179714011515210000138000000000000000011170245349920250931431117111760100700070009000450931430000000040115050101000000057360003POS';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$init_iso = $_POST['isomsg'];
$iso = ltrim($init_iso); //remove left whitespaces

$parser	= new ISO8583();  //menjalankan class iso8583

//add message iso
$parser->addISO($iso);


//get parsing result
//print 'ISO: '. $iso. "\n";
//print 'MTI: '. $parser->getMTI(). "\n";
//print 'Bitmap: '. $parser->getBitmap(). "\n";
?>
<html>
<head>
	<title>:: LogISO8583 Parser - Result ::</title>
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

.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  background-color: #afd7ff;
}

footer{
	margin-top:45px;
	padding-top:5px;
	border-top: 1px solid #eaeaea;
	color: gray-light;
	small{
		float: center;
	}
}

.pull-left{
	margin-left: 30px;
}

.pull-right{
	margin-top: 45px;
	margin-right: 30px;
}
</style>
<body>
<header class = "navbar navbar-fixed navbar-static-top navbar-inverse">
	<div class = "pull-left">
		<font color=white><h2><img src="aset/fmlogo.png" alt="fm" style="width:35px; heigth:57px;"> ISO8583 Parser</h2></font>
	</div>
	<div class = "pull-right">
		<a href="http://10.200.3.3/iso8583/parser.php" class="navbar-link" style="text-decoration:none;"><strong>Back</strong></a>
	</div>
</header>
	<div class="col-md-9 ">
	<?
	//iso message
	print 'ISO: '. $iso. "\n";?>
		<div class="container">
			<!-- Alert untuk validasi input message iso -->
			<?if(empty($_POST['isomsg'])) { //kalau iso message kosong?>
				<div class = "alert alert-danger" style="margin-top: 30px;">Error ! No ISO Message to be parse.</div> <!-- menamplikan alert -->
			<?exit();}
				$error = 0;
				foreach($parser->getData() as $key => $value){
					if(strpbrk($value,"+") !== FALSE){ //kalau hasil parsing tidak valid
						$error = 1; //flag error 
					}
					if(strpbrk($value,"?") !== FALSE){
						$error = 1;
					}
					if(empty($value)){ //kalau ada value yang kosong
						$error = 1;
					}
				}
				if($error == 1){?>
					<div class = "alert alert-warning" style="margin-top: 30px;">Warning ! Invalid parsing result, make sure that you are entering a valid ISO Message</div> <!-- menampilkan hasil alert -->
				<?}
				else{?>
					<div class = "alert alert-success" style="margin-top: 30px;">Parsing OK...</div> <!--Parsing berhasil/valid --> 
				<?}?>
			<!--<div class="page-header">
				<h2>Result</h2>
			</div>-->
			<div class="row">
				<br/>
				<table class="table table-condensed table-hover">
					<!--<tr>
						<thead>
							<td colspan=3 style="background-color:#333333;"><strong><font color=white>ISO 8583 PARSER</font></strong></td>
						</thead>
					</tr>-->
					<tr>
						<td colspan=3><strong>MTI:</strong> 
						<?
						$mti = $parser->getMTI(); //mengambil nilai MTI 
						$data = $parser->getData(); //mengambil hasil parser
						print $mti;
						
						//mencantumkan nama service berdasarkan MTI dan Proc. codenya
						
						//Inquiry/Payment (0200/0210)
						if($mti == '0200' && $data[3] == '170000') echo ' (Payment Request)';
						if($mti == '0200' && ($data[3] == '370000' || $data[3] == '380000')) echo ' (Inquiry Request)';
						
						if($mti == '0210' && $data[3] == '170000') echo ' (Payment Response)';
						if($mti == '0210' && ($data[3] == '370000' || $data[3] == '380000')) echo ' (Inquiry Response)';
						
						//Reversal (0400)
						if($mti == '0400') echo ' (Reversal Request)';
						if($mti == '0410') echo ' (Reversal Response)';

						//Network Management (0800/0810)
						if($mti == '0800' && $data[70] == '001') echo ' (Network Management Request - Sign On)';
						if($mti == '0800' && $data[70] == '002') echo ' (Network Management Request - Sign Off)';
						if($mti == '0800' && $data[70] == '301') echo ' (Network Management Request - Echo Test)';
						
						if($mti == '0810' && $data[70] == '001') echo ' (Network Management Response - Sign On)';
						if($mti == '0810' && $data[70] == '002') echo ' (Network Management Response - Sign Off)';
						if($mti == '0810' && $data[70] == '301') echo ' (Network Management Response - Echo Test)';
						?>
						
						</td></tr>
						<tr><td colspan=3><strong>Bitmap:</strong> <?
						//mengambil nilai bitmap iso
						$oribitmap = $parser->getBitmap();
						//mengganti setiap angka 1 dengan karakter '|'
						$bitmap_replace = str_replace('1','|',$oribitmap); 
						//mengganti setiap angka 0 dengan karakter '-'
						$bitmap = str_replace('0','-',$bitmap_replace); 
						print $bitmap; ?>
						</td>
					</tr>
				</table>
				<?
				function myprint_r($iso_array) {
					if (is_array($iso_array)) {?>
						<!--<table border=1 cellspacing=0 cellpadding=3 width=40%> -->
						<table class = "table table-condensed table-hover">
						<tr>
						<!-- table header -->
							<thead>
								<td valign = "center" align = "center" style="width:40%;background-color:#2a38a1;"><strong><font color=white>DESCRIPTION</font></strong></td>
								<td valign = "center" align = "center" style="width:20%;background-color:#2a38a1;"><strong><font color=white>ELEMENT No.</font></strong> </td>
								<td valign = "center" align = "center" style="width:10%;background-color:#2a38a1;"><strong><font color=white>TYPE</font></strong></td>
								<td valign = "center" align = "center" style="width:10%;background-color:#2a38a1;"><strong><font color=white>LENGTH</font></strong></td>
								<td valiegn = "center" align = "center" style="width:20%;background-color:#2a38a1;"><strong><font color=white>FORMAT</font></strong></td>
								<td valign = "center" align = "center" style="background-color:#2a38a1;"><strong><font color=white>VALUE</font></strong></td>
							</thead>
						</tr>
						<?foreach ($iso_array as $key => $value) {
							
								//////////////////////////// ('Description', Element no. , 'Type', Length, Format) 
								
								if($key == 1) $key = array('Bitmap','','H',16,'Fix length');
								if($key == 2) $key = array('Primary Account Number', 2, 'N', 17,'Fix length');
								if($key == 3) $key = array('Processing Code', 3, 'N', 6, 'Fix length');
								if($key == 4) $key = array('Transaction Amount', 4, 'N', 12,'Zero left padding');
								if($key == 7) $key = array('Transmission Date & Time', 7, 'N', 10, 'MMDDhhmmss');
								if($key == 11) $key = array('STAN', 11, 'N', 6, 'Fix length');
								if($key == 12) $key = array('Time, Local Transaction', 12, 'N', 6, 'hhmmss');
								if($key == 13) $key = array('Date, Local Transaction', 13, 'N', 4, 'MMDD');
								if($key == 15) $key = array('Date Settlement', 15, 'N', 4, 'MMDD');
								if($key == 18) $key = array('Merchant Type', 18, 'N', 4);
								if($key == 19) $key = array('Acquiring Institution Country Code', 19, 'N', 3);
								if($key == 32) $key = array('Acquiring Institution Identification Code', 32, 'N', 3);
								if($key == 37) $key = array('Retrieval Reference Number' , 37, 'AN', 12);
								if($key == 39) $key = array('Response Code', 39, 'N', 2, 'Fix length');
								if($key == 42) $key = array('Card Acceptor Identification Code', 42, 'ANS', 15, 'Space right-padding');
								if($key == 48) $key = array('Additional Data', 48, 'ANS', 999, 'LLLVAR');
								if($key == 49) $key = array('Currency Code', 49, 'N', 3);
								if($key == 63) $key = array('Institution Code', 63, 'N', 3);
								if($key == 70) $key = array('Network Infomation Code', 70, 'N', 3);?>
								
								<tr>
									<td><strong><? echo $key[0]; ?></strong></td> <!--Description -->
									<td align = "center"><? echo $key[1]; ?></td> <!--Element No. -->
									<td align = "center"><? echo $key[2]; ?></td> <!--Type -->
									<td align = "center"><? echo $key[3]; ?></td> <!--Length -->
									<td align = "center"><? echo $key[4]; ?></td> <!--Format -->
									<td><? echo $value; ?></td> <!--Value -->
								</tr><?
						}
						?>
						</table><?
						return;
					}
					echo $iso_array;
				}
				//print tabel
				myprint_r($parser->getData());?>
			</div>
			<footer class=footer>
			 <small>
				<center>Copyright 2015 INFOKOM ELEKTRINDO</center>
			 </small>
			</footer>
		</div>
	</div>
</body>
</html>



