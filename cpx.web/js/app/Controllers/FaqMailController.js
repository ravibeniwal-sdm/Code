
app.controller('FaqmailCtrl', ['$scope', 'items', '$location', '$routeParams', 'ShareMailService', '$rootScope', '$modalInstance', function ($scope, items, $location, $routeParams, ShareMailService, $rootScope, $modalInstance) {
	
	//console.log(items);
	
	 $scope.absurl = "http://centralpropertyexchange.com.au/#!/blog/"+items;
	  
     
	  
	  
	  $scope.subject = "BLOG / "+$routeParams.pid.replace("_", " "); 
	  
	  $scope.txtmsg = "Hello,"+"\n\nPlease have a look/ review"+"\n"+$scope.absurl+"\n\nRegards";
	  
	  
//	  console.log($scope.txtmsg);
	 
//	  console.log($scope.sharemail);
	
	  $scope.ok = function () {
	        $modalInstance.close();
	      };
	
	
	
	$rootScope.loading=false;
	
	 $scope.sendEmail=function(){
		 
		 console.log($scope.sharemail);
		 
		 
		 
		 $rootScope.loading = true;
		 ShareMailService.create($scope.sharemail).$promise.then(function() {
	       // $scope.msg = msg.toJSON();
//	        console.log($scope.msg);
//	        console.log($scope.msg.status);
	        $rootScope.loading = false;
	        if($scope.msg.status=='OK'){
			        $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
	        }else{
	        	$scope.alerts = [
	        	                 { type: 'danger', msg: 'Oops! something went wrong please try again.' },
			   	                ];
	        }
	        $scope.contact = null;
            $scope.closeAlert = function(index) {
              $scope.alerts.splice(index, 1);
            };
	     });
	       
		 $scope.ok();
		 
	    };
	    
	    
	    
	    
	    
	    $scope.cancel = function () {
		    $modalInstance.dismiss('cancel');
		  };
	}]);


app.controller('PublicSpeakingmailCtrl', ['$scope', 'items', '$location', '$routeParams', 'ShareMailService', '$rootScope', '$modalInstance', function ($scope, items, $location, $routeParams, ShareMailService, $rootScope, $modalInstance) {
	
	//console.log(items);
	
	 $scope.absurl = "http://centralpropertyexchange.com.au/#!/public-speaking-profiles/"+$routeParams.pid;
	  
     
	  
	  
	  $scope.subject = "PUBLIC SPEAKING PROFILES -"+$routeParams.pid.replace("_", " "); 
	  
	  $scope.txtmsg = "Hello,"+"\n\nPlease have a look/ review"+"\n"+$scope.absurl+"\n\nRegards";
	  
	  
//	  console.log($scope.txtmsg);
	 
//	  console.log($scope.sharemail);
	
	  $scope.ok = function () {
	        $modalInstance.close();
	      };
	
	
	
	$rootScope.loading=false;
	
	 $scope.sendEmail=function(){
		 $rootScope.loading = true;
		 ShareMailService.create($scope.sharemail).$promise.then(function(msg) {
	        $scope.msg = msg.toJSON();
//	        console.log($scope.msg);
//	        console.log($scope.msg.status);
	        $rootScope.loading = false;
	        if($scope.msg.status=='OK'){
			        $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
	        }else{
	        	$scope.alerts = [
	        	                 { type: 'danger', msg: 'Oops! something went wrong please try again.' },
			   	                ];
	        }
	        $scope.contact = null;
            $scope.closeAlert = function(index) {
              $scope.alerts.splice(index, 1);
            };
	     });
	       
		 $scope.ok();
		 
	    };
	    
	    
	    
	    
	    
	    $scope.cancel = function () {
		    $modalInstance.dismiss('cancel');
		  };
	}]);
