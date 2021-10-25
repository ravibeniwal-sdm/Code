app.controller('LogoslideCtrl' , ['$scope','$rootScope', function ($scope,$rootScope) {
	



	$scope.options = {
			    visibleItems: 4,
	            animationSpeed: 1000,
	            autoPlay: true,
	            autoPlaySpeed: 3000,
	            pauseOnHover: true,
	            enableResponsiveBreakpoints: true,
	            responsiveBreakpoints: {
	                portrait: {
	                    changePoint: 480,
	                    visibleItems: 1
	                },
	                landscape: {
	                    changePoint: 640,
	                    visibleItems: 2
	                },
	                tablet: {
	                    changePoint: 768,
	                    visibleItems: 1
	                }
	            }
	}
	
	 
	  
	//console.log($scope.options.visibleItems);
}]);