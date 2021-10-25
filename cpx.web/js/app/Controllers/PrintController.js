app.controller('printCtrl', ['$scope','$rootScope','QueryService','CommonShareService','$timeout', function ($scope,$rootScope,QueryService,CommonShareService,$timeout) {

	//QueryService.success(function(data) { 
	$scope.currid = CommonShareService.getid();
	
	console.log($scope.currid );
	
	$scope.id= $scope.currid;
	
	$scope.propertDetails = {};
	$scope.propertDetails.id = $scope.id;	
	

	
	QueryService.create($scope.propertDetails).$promise.then(function(data) {
		$scope.properties = data.properties;	
	
		
		
		$scope.currentpage = CommonShareService.getblogprintid();
		
		$scope.currentproperty = $scope.properties[0];
		
     //console.log($scope.currentproperty);
			/*$scope.currentproperty = $scope.properties[0];
		
		
		for(i=0;i<$scope.properties.length;i++){
			
			if($scope.properties[i].id == $scope.currid){
				
			$scope.currentproperty = $scope.properties[i];	
			}
			
		}*/
		
     $scope.teststatus = $scope.currentproperty.gradestatus;
		
		console.log($scope.currentproperty.gradestatus);
		
		
		
		
		$scope.gradevalues = [1,2,3,4,5];
		/*$scope.map = { center: { latitude: $scope.currentproperty.coords.latitude, longitude: 1*$scope.currentproperty.coords.longitude + 0.0050}, zoom: 16, 

				 markersr: [
				               {
				                   id: 101,
				                   latitude:  $scope.currentproperty.coords.latitude,
				                   longitude: $scope.currentproperty.coords.longitude
				               }],
				     };*/
		
		$scope.map = {center: {latitude: $scope.currentproperty.coords.latitude, longitude: $scope.currentproperty.coords.longitude}, zoom: 18};
		
		 $scope.marker = {
			      id: 101,
			      coords: {
			        latitude: $scope.currentproperty.coords.latitude,
			        longitude: $scope.currentproperty.coords.longitude
			      },
			      options: { draggable: true },
			      
			    };
		
		
		
	
	
	
	
	
	});
	
	
	
	
	
	
	}]);