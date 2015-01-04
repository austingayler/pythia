<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pythia</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/logo-nav.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	
	<?php
	
	$graph_data = array();
	include 'connect.php';
	$query = "SELECT * FROM audio WHERE audio.timestamp > DATE_SUB(NOW(), INTERVAL 48 HOUR)";
	$result = mysqli_query($conn, $query) or die(mysql_error() . "frick");
	
	while($row = mysqli_fetch_assoc($result)) {
		$cur_arr = array();
		$cur_arr['timestamp'] = strtotime($row['timestamp']);
		$cur_arr['avg'] = $row['avg'];
		$graph_data[] = $cur_arr;
	}
	mysqli_free_result($result);
	mysqli_close($conn);
	
	//var_dump($graph_data);
	
	$jsArr = array();
	foreach($graph_data as $array) {
		$jsArr[] = array(1000 * $array['timestamp'], (int) $array['avg']);
	}
	$xy = json_encode($jsArr);
	//var_dump($xy);
	$xy = str_replace( " \" " , " \\\" " ,$xy);
	
	?>
    <![endif]-->
    
    <script language="javascript" type="text/javascript" src="js/flot/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="js/flot/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="js/flot/jquery.flot.time.js"></script>
    
	<script type="text/javascript" language="javascript">
	$(function() {
		var d1 =<?php echo $xy; ?>;
		
		var now = new Date();
		
		var twoDaysAgo = new Date();
		twoDaysAgo.setTime(now.getTime() - 24*60*60*1000*2);
		
		var oneDayAgo = new Date();
		oneDayAgo.setTime(now.getTime() - 24*60*60*1000);
		
		var twelveHoursAgo = new Date();
		twelveHoursAgo.setTime(now.getTime() - 12*60*60*1000);
		
		var fourHoursAgo = new Date();
		fourHoursAgo.setTime(now.getTime() - 4*60*60*1000);
		
		
		$.plot("#graphs", [d1], {
			xaxis: {
				mode: "time", 
				twelveHourClock:true,
				timezone: "browser"
			}
		});

		$("#2DAYZ").click(function () {
			$.plot("#graphs", [d1], {
				xaxis: {
					mode: "time", 
					twelveHourClock:true,
					timezone: "browser",
					min: twoDaysAgo.getTime(),
					max: now.getTime()
				}
			});
		});

		$("#1day").click(function () {
			$.plot("#graphs", [d1], {
				xaxis: {
					mode: "time", 
					twelveHourClock:true,
					timezone: "browser",
					min: oneDayAgo.getTime(),
					max: now.getTime()
				}
			});
		});
		
		$("#12hours").click(function () {
			$.plot("#graphs", [d1], {
				xaxis: {
					mode: "time", 
					twelveHourClock:true,
					timezone: "browser",
					min: twelveHoursAgo.getTime(),
					max: now.getTime()
				}
			});
		});
		$("#4hours").click(function () {
			$.plot("#graphs", [d1], {
				xaxis: {
					mode: "time", 
					twelveHourClock:true,
					timezone: "browser",
					min: fourHoursAgo.getTime(),
					max: now.getTime()
				}
			});
		});

	});
	</script>

</head>

<body>
	
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">
                    <img height="60" width="90" src="img/pythia-logo.png" alt="">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
				<?php include 'navbar.html' ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Living Room Audio</h1>
                <div id="graphs" style="width:1000px; height:400px">
				</div>				
				<button id="2DAYZ" class="btn btn-default">2 Days</button>
				<button id="1day" class="btn btn-default">1 Day</button>
				<button id="12hours" class="btn btn-default">12 Hours</button>
				<button id="4hours" class="btn btn-default">4 Hours</button>
            </div>
        </div>
    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.0 -->
    <!--- <script src="js/jquery-1.11.0.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
