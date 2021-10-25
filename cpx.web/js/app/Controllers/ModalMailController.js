app.controller('ModalmailCtrl', ['$scope', 'items', '$location', 'ShareMailService', '$rootScope', '$modalInstance', function ($scope, items, $location, ShareMailService, $rootScope, $modalInstance) {
	
//	console.log(items);
	
	 $scope.absurl = "http://centralpropertyexchange.com.au/#!/details/"+items.id;
	 
	 $scope.propid = items.id;
	  
    var area = items.address[0].StreetNumber+" "+items.address[0].street+", "+items.address[0].suburb.text+", "+items.address[0].state+" "+items.address[0].postcode;
	  
    $scope.proparea = area;
    
	  $scope.subject = "Sharing property link with you;"+" "+items.name+" "+area;
	  
	  $scope.txtmsg = "Hello,\n"+"I found this property on CPx.\n\nPlease have a look/ review"+" "+items.name+", "+items.type+"\n"+area+"\n"+$scope.absurl+"\n\nRegards";
	  
	  
//	  console.log($scope.txtmsg);
	 
//	  console.log($scope.sharemail);
	
	  $scope.ok = function () {
	        $modalInstance.close();
	      };
	
	
	
	$rootScope.loading=false;
	
	 $scope.sendEmail=function(){
		/* $scope.sharemail = {};
		 $scope.sharemail.propid = items.id;
		 $scope.sharemail.address = area;*/
		 
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