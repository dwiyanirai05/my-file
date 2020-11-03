<html>
	<head>
		<title>monte carlo</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/main.css">
	  	<link rel="stylesheet" href="css/bootstrap.min.css">
	  	<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="icon" href="img/favicon.ico">
	  	<script src="js/jquery.min.js"></script>
	  	<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<h1>Monte Carlo</h1>
				</div>
			</div>
		</nav>
			<?php
				error_reporting(E_ERROR);

				$demand = $_POST['demand'];
				$freq = $_POST['freq'];
				$total = 0;
				
				$probability[-1] = 0;
				$amount = count($freq);
				$botInterval = [];
				$topInterval = [];

				//menghitung total frekuensi permintaan
				for($i=0;$i<count($freq);$i++){
					$total = $total + $freq[$i];
				}

				//menghitung peluang/Probabilitas terjadinya permintaan
				for($i=0;$i<count($freq);$i++){
					$probability[$i] = round($freq[$i]/$total,3);
					$cumulative[$i] =  round($cumulative[$i-1] + $probability[$i],3);
				}

				//menghitung panjang angka dibelakang koma
				$length = 0;
				for($i=0;$i<count($freq);$i++){
					if($length < strlen($cumulative[$i])){
						$length = strlen($cumulative[$i]) - 2;
					}
				}

				//menghitung interfal paling bawah
				$lowestInterval = 1;
				for($j=0;$j<$length;$j++){
					$lowestInterval = $lowestInterval/10;
				}

				$lowestInterval = round($lowestInterval,3);

				//menentukan interval bawah dan atas pertama
				$botInterval[0] = $lowestInterval;
				$topInterval[0] = $cumulative[0];

				//menentukan interval bawah dan atas
				for($i=1;$i<count($freq);$i++){
					$botInterval[$i] = round($topInterval[$i-1] + $lowestInterval,3);
					$topInterval[$i] = round($cumulative[$i],3);
				}

				//menghitung untuk perkalian desimal agar bisa digunakan untuk interval bilangan acak
				$pangkat = 1;
				for($j=0;$j<$length;$j++){
					$pangkat = $pangkat * 10;
				}

			?>

		<!-- Container -->
		<div class="container">
			<div class="panel panel-primary">
				
				<div class="panel-body">
					<div class="input-group">
					  <h1><center>Hasil</center></h1>
					 
					  <div class="table table-responsive">
						<table class="table table-hover custom-table-header">
						  <tr>
							  <th>Permintaan</th>
							  <th>Probabilitas</th>
							  <th>Probabilitas Kumulatif</th>
							  <th>Interval Bilangan Acak</th>
						  </tr>
					<?php for($i=0; $i<count($freq); $i++): ?>
						  <tr>
							  <td> <?php echo $demand[$i]; ?> </td>
							  <td> <?php echo $probability[$i]; ?> </td>
							  <td> <?php echo $cumulative[$i]; ?> </td>
							  <td>
								<?php
									echo $botInterval[$i]." - ";
									echo $topInterval[$i]."<br>";
								?>
							  </td>
						  </tr>
					<?php endfor; ?>
						</table>
					  </div>
					</div>
					
			</div>
		</div>
	</body>
</html>
