<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>OpenSeaDragon - Test</title>
	<script src="<?php echo base_url('openseadragon')?>/openseadragon.js"></script>
</head>
<body>

<?php $img = $data['data']['output']['DZI']; ?>

<div id="openseadragon1" style="width: 800px; height: 600px;"></div>
<script type="text/javascript">
	var viewer = OpenSeadragon({
		id: "openseadragon1",
		prefixUrl: "openseadragon/images/",
		tileSources: "<?php echo $img?>"
	});
</script>

</body>
</html>
