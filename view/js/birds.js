tax.controller("Birds", ['$scope', '$http', function($scope, $http) {
	$scope.commonNames = [];
	$scope.scientificName = '';
	$scope.images = [];
	$scope.extinct = false;
	$scope.habitats = [];

	$scope.tmp = 'loading';


	// load some unknown bird for categorization
	$http.get('/bio/ng/Bird/getUnknownBird', {})
	.success(function(data) {
		console.log('success');
		console.log(data);

		$scope.scientificName = data.results.complete_name;
		$scope.extinct = false;
		$scope.images = [];
		$scope.habitats = [];
		$scope.commonNames = [];

		$scope.tmp = 'loaded';

	}).error(function(data) {
		console.log('ERROR ' + data);
	});

	// save the data for this bird
	$scope.save = function() {

	}
}]);