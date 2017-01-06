<!DOCTYPE html>
<html>
<head>
	<title>Ornothology</title>
	<script type="text/javascript" language="javascript" src="view/js/angular.min.js"></script>
	<script type="text/javascript" language="javascript" src="view/js/taxonomy.js"></script>
	<script type="text/javascript" language="javascript" src="view/js/birds.js"></script>
</head>
<body ng-app="Taxonomy" ng-controller="Birds">
	<div>
		<img ng-src="{{imgUrl}}" />
	</div>

	<div>
		<form name="birdform">
			{{scientificName}}


			<div>
				<h4>Extinct?</h4>
				<input type="radio" name="extinct" ng-model="extinct" ng-value="true" /> yes
				<input type="radio" name="extinct" ng-model="extinct" ng-value="false" /> no
			</div>

			<div>
				<input type="button" value="Save" ng-click="save()" />
			</div>
		</form>
	</div>

</body>
</html>