app.controller('ModalInstanceCtrl', ['$scope','$modalInstance','items' ,function ($scope, $modalInstance, items) {

	  $scope.items = items;
//	  console.log($scope.items);
//	  $scope.selected = {
//	    item: $scope.items[0]
//	  };
//
//	  $scope.ok = function () {
//	    $modalInstance.close($scope.selected.item);
//	  };

	  $scope.cancel = function () {
	    $modalInstance.dismiss('cancel');
	  };
	}]);