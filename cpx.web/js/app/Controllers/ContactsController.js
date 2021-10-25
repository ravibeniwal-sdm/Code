app.controller('ContactCtrl', ['$scope', 'ContactService','$rootScope','CommonShareService','ShortlistService','vcRecaptchaService','$http','$timeout', function ($scope, ContactService, $rootScope, CommonShareService,ShortlistService,vcRecaptchaService,$http,$timeout) {
	
	$rootScope.metakeywords = "CPx,Email,Contact,Message,Telephone,Management,Questions,Email address,Contact details,Key management,Telephone number,Central Property Exchange,Online right now,Chat via Skype with us,Find out more about CPx,Comments and questions,Based in Sydney and Perth,How to make contact with CPx";
	
	$rootScope.title= "Central Property Exchange | Real Estate| Contact";
	
	$rootScope.description="Central Property Exchange � Contact Page - Buy And Sell Residential And Investment Properties � Key Management in Sydney and Perth Australia.";
	
	$rootScope.loading=false;
	//$scope.contact=[];
	$scope.link= "";
	$scope.widgetId = "contactFormRecaptcha";


	
	
 
	
  var checkflag = CommonShareService.getallid();
	
  if(checkflag == false){
   $scope.currid = CommonShareService.getenquireid();	
	
	if ($scope.currid != null){
		
		$scope.link	= "http://centralpropertyexchange.com.au/#!/details/"+$scope.currid;
	}
  }
	
	
  var checkflag = CommonShareService.getallid();
	
  if(checkflag == true){	
	
	
	$scope.list = ShortlistService.getProducts();
	
	
	if($scope.list != undefined){
				
		for(i=0;i<$scope.list.length;i++){
			
			$scope.link = $scope.link +"http://centralpropertyexchange.com.au/#!/details/"+$scope.list[i].id+"\n";		
		
		}
		

		}
	
	}
	
//  console.log("try1"+$rootScope.shownothing);
  
   if($rootScope.shownothing != false){
	   
	   $scope.link = '';
   }
    
    $scope.setWidgetId = function (widgetId) {
	        console.log('Created widget ID: %s', widgetId);
	        $scope.widgetId = widgetId;
	    };
    	
   $scope.respone5 = '';
   
	 $scope.sendContactEmail=function(){
			if(!$scope.contact.name || !$scope.contact.email || !$scope.contact.role){
				
//				console.log("kam fastay");
			}
			else
            {
			 if($scope.respone5.length === 0){
				    $scope.alertcaps = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
				    $scope.closeAlertcap = function(index) {
					      $scope.alertcaps.splice(index, 1);
					    };
				    return;		
				    
				  }
			 
				
				else{
				 var valid;

			 ContactService.create($scope.contact).$promise.then(function(msg) {
		        $scope.msg = msg.toJSON();
		     });
			 
             $rootScope.loading = true;
             
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };

                                  
				 $scope.contact.name = "";
				 $scope.contact.email = "";
                 $scope.contact.role = "";
				 $scope.contact.subject = "";
				 $scope.contact.message = '' ;
				 $scope.contact.dummysubject = "Contact us Enquiry";
				 
				 $rootScope.loading = false;
       }, 2000);
                
                $timeout(function(){ grecaptcha.reset(); $scope.respone5 = '';}, 2000);
			 
		 }  
		 }
};
	}]);