<style type="text/css">
.header_bar{
	background-color: #E6DED4;
	font-family: "Times New Roman";
}

.header_base_bar{
	background-color: #C54C20;
}

#pageHeader{
	font-size:22px;
	font-weight:bold;
	color:white;
	text-shadow: 0px 0px 2px #333;
}

#famuLogo{
  padding-bottom:10px;
  padding-left:95px;
}
</style>

<div class="header_bar">
	<div class="container">
		<img id="famuLogo" src="/bootstrap/images/famulogo2014.png" alt="" />
	</div>
</div>

<div class="header_base_bar">
	<div class="container">
		<div class="row">
			<span id="pageHeader"><?php echo $headerText ?></span>
		</div>
	</div>
</div>