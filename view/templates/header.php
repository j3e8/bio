<?php
global $_js_includes_arr,
	$_css_includes_arr,
	$_page_title,
	$_with_nav;
?>

<html>
 <head>
  <title><?=$_page_title?></title>
  <?php foreach ($_js_includes_arr as $js_file): ?>
		<script language="javascript" type="text/javascript" src="view/js/<?=$js_file?>.js"></script>
  <?php endforeach; ?>
  <?php foreach ($_css_includes_arr as $css_file): ?>
		<link rel="stylesheet" type="text/css" href="view/css/<?=$css_file?>.css" />
  <?php endforeach; ?>
 </head>
 <body>
	 <div id="entirePage">
		<table id="pageStructure">
		<tr>
		<td id="leftBorder"></td>
		<td id="mainPage">
			<div id="header">
				<img src="view/images/biodeebee.png" />
			</div>
			<div id="headerBorder1"></div>
			<div id="headerBorder2"></div>
			<div id="mainContent">
				<div id="menuColumn">
					<div id="menuContainer">
						<div id="menuItemContainer">
							 <div class="menuBorder"></div>
							 <div id="menuItemInnerContainer">
								  <div class="menuItem"><a href="?page=search">search</a></div>
								  <div class="menuItem"><a href="?page=viewtsn">browse</a></div>
							 </div>
							 <div class="menuBorder"></div>
						</div>
						<div id="forks">
							 <div id="leftfork"></div>
							 <div id="rightfork"></div>
						</div>
					</div>
				</div>
				<div id="contentColumn">
