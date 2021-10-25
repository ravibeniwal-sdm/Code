app.controller('ListCtrl', ['$scope','$rootScope','$location','$anchorScroll','$timeout','CommonShareService', function ($scope,$rootScope,$location,$anchorScroll,$timeout,CommonShareService) {
	 
	$rootScope.metakeywords = "";
	
    var rateValue = false;
    if($location.$$hash=="rate")
        rateValue = true;
    
	$scope.listStatus ={rate:rateValue,offer:false};
	 
	 //console.log($location.$$hash);
     
	 var flag = CommonShareService.getgotorate2();
	 
	 if(flag == true){
		
		 $scope.listStatus.rate = true;
		 $location.hash('rate');
		
		 $timeout(function() {
        	 $anchorScroll();     
       }, 4000);
	 } 
	
}]);