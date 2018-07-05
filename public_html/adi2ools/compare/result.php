<?php
$totalTime = util()->friendlyTime($filesLoadingTime+ $compareTime);
$filesLoadingTime = util()->friendlyTime($filesLoadingTime);
$compareTime = util()->friendlyTime($compareTime);
?>
<!<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Compare Results</title>
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="assets/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
	<link href="assets/custom.css" rel="stylesheet">
</head>
<body>
	<div class="container">

		<div class="panel panel-primary" style="margin-top:10px;">
			<div class="panel-heading">Compare Files with Remote Server:</div>
			<div class="panel-body"><span class="bold">Process took </span> <?= $totalTime ?>.</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<table data-toggle="table" id="result-table">
					<thead>
					<tr>
						<th data-sortable="true">#</th>
						<th data-sortable="true">File</th>
						<th data-sortable="true">Status</th>
						<th data-sortable="true">Local Modified Time</th>
						<th data-sortable="true">Remote Modified Time</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach($result as $status => $files) {
							if($status == 'missing') {
								$status = 'LOCAL FILE MISSING';
							}
							else if($status == 'new') {
								$status = 'REMOTE FILE MISSING';
							}
							else {
								$status = 'CHANGED';
							}
							foreach($files as $file) {
								?>
								<tr>
									<td><?= $i++ ?></td>
									<td><?= $file['name'] ?></td>
									<td><span class='bg-info'><?= $status ?></span></td>
									<td><?= $file['oldTime'] ?></td>
									<td><?= $file['newTime'] ?></td>
								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div><!-- main container -->
	<script src="assets/jquery/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/bootstrap-table/bootstrap-table-locale-all.min.js"></script>
	<script src="assets/bootstrap-table/bootstrap-table.min.js"></script>
</body>
</html>