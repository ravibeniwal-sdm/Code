app.controller('ServiceRequestCtrl', ['$scope', 'ServiceRequestService','$rootScope','CommonShareService','ShortlistService','vcRecaptchaService','$http','$timeout','QueryService','$filter', function ($scope, ServiceRequestService, $rootScope, CommonShareService,ShortlistService,vcRecaptchaService,$http,$timeout,QueryService,$filter) {
	
	$rootScope.metakeywords = "CPx,Email,Contact,Message,Telephone,Management,Questions,Email address,Contact details,Key management,Telephone number,Central Property Exchange,Online right now,Chat via Skype with us,Find out more about CPx,Comments and questions,Based in Sydney and Perth,How to make contact with CPx";
	
	$rootScope.title= "Central Property Exchange | Real Estate| Contact";
	
	$rootScope.description="Central Property Exchange � Contact Page - Buy And Sell Residential And Investment Properties � Key Management in Sydney and Perth Australia.";
	
	$rootScope.loading=false;
	//$scope.contact=[];
	$scope.link= "";
    
    $scope.widgetId = "";	


    $scope.subject ="Service request: Help with evaluating/ buying property";


    $scope.selectedmenu=[{id:0,selected:false},{id:1,selected:false},{id:2,selected:true},{id:3,selected:false},{id:4,selected:false},{id:5,selected:false}];    
	
    var toggle_val = '';
    toggle_val = angular.fromJson(sessionStorage.toggle_val);
    $scope.toggle_val = toggle_val;
    
  var checkflag = CommonShareService.getallid();
  $scope.properties = {};   
  $scope.propertDetails = {};	
  $scope.currentproperty={};
 
  console.log(checkflag);
  $scope.currid ='';	  
  if(checkflag == false){
   
   currid = CommonShareService.getenquireid();	
	
       
	
	//PropertyService.success(function(data) {
	//QueryService.success(function(data) {

   
	if (currid != null && currid){	  
	   $scope.id = $scope.currid = currid;
       $scope.propertDetails.id = $scope.id;

//console.log("in if");         
  // console.log($scope.currid);
       
                    	QueryService.create($scope.propertDetails).$promise.then(function(data) {
                    			
                                $scope.properties =data.properties;
                                //console.log("in if currid "+$scope.properties);	
                                var current_index = $filter('get-property-filter')($scope.properties, $scope.id);
                                $scope.currentproperty = $scope.properties[current_index];
                            	
                                //console.log($scope.currentproperty.address[0].LotNumber);
                                var link = '<b>Property address: </b>'+ ($scope.currentproperty.address[0].subNumber!=null ? $scope.currentproperty.address[0].subNumber +'/ ':($scope.currentproperty.address[0].LotNumber!=null? $scope.currentproperty.address[0].LotNumber :" "))+ ($scope.currentproperty.address[0].StreetNumber!=null?$scope.currentproperty.address[0].StreetNumber+' ' :" " )+($scope.currentproperty.address[0].street!=null?$scope.currentproperty.address[0].street :" ")+($scope.currentproperty.address[0].suburb.text!=null?', '+$scope.currentproperty.address[0].suburb.text:" ")+($scope.currentproperty.address[0].city!=null?', '+$scope.currentproperty.address[0].city+' ':", ")+($scope.currentproperty.address[0].state!=null?$scope.currentproperty.address[0].state+' ':" ")+($scope.currentproperty.address[0].postcode!=null?$scope.currentproperty.address[0].postcode:"");
                                 
                                 
                                 link = link + "<br/><b>Property link: </b>http://centralpropertyexchange.com.au/#!/details/"+$scope.currid;
                                 
                                // console.log(link);
                                 
                                //$scope.contact.links = link;
                                                                        
                                $scope.contact.propertyIds = $scope.currid;
                                $scope.link = link;
                                
                        
                       }); 
   
               
    	   
    	   
        		
        		//$scope.link	= "Property link: http://centralpropertyexchange.com.au/#!/details/"+$scope.currid;
                
        	}
   
   
   //console.log("currentprop");         
   //console.log($scope.currentproperty);
         /*   
         */       
   
  }

	
  $scope.toggle_enquire_servicerequest = function (val) {
							
					
		  sessionStorage.toggle_val = angular.toJson(val); 	   
	  };
	
  if(checkflag == true){	
	

           $scope.list = ShortlistService.getProducts();

                             
           var link = "";
           
           if($scope.list != undefined) 
           {
               for(i=0;i<$scope.list.length;i++){
                                  
               var currentproperty = $scope.list[i]; 
                  
               link = link + '<b>Property address: </b>'+ (currentproperty.address[0].subNumber!=null ? currentproperty.address[0].subNumber +'/ ':(currentproperty.address[0].LotNumber!=null? currentproperty.address[0].LotNumber :" "))+ (currentproperty.address[0].StreetNumber!=null?currentproperty.address[0].StreetNumber+' ' :" " )+(currentproperty.address[0].street!=null?currentproperty.address[0].street :" ")+(currentproperty.address[0].suburb.text!=null?', '+currentproperty.address[0].suburb.text:" ")+(currentproperty.address[0].city!=null?', '+currentproperty.address[0].city+' ':", ")+(currentproperty.address[0].state!=null?currentproperty.address[0].state+' ':" ")+(currentproperty.address[0].postcode!=null?currentproperty.address[0].postcode:"");
                 
                 
               link = link + "<br/><b>Property link: </b>http://centralpropertyexchange.com.au/#!/details/"+currentproperty.id+"<br/><br/>";
               //console.log(link);
               //$scope.contact.links = link;                            
               $scope.link = link;
               }  
          
          }                              
        //  console.log(link);
                                 
                               
    
    
	/*
	if($scope.list != undefined){
				
		for(i=0;i<$scope.list.length;i++){
			
			$scope.link = $scope.link +"http://centralpropertyexchange.com.au/#!/details/"+$scope.list[i].id+"\n";		
		
		}
		

		}
      */  
    
	}
	
//  console.log("try1"+$rootScope.shownothing);
  
   if($rootScope.shownothing != false){
	   
	   $scope.link = '';
   }
	
   $scope.respone5 = '';
	 $scope.sendContactEmail=function(){
			if(!$scope.contact.name || !$scope.contact.email  || !$scope.contact.role){
				
//				console.log("kam fastay");
			}
			else
            {
			 if((typeof $scope.contact.rec_emails == 'undefined') || (typeof $scope.contact.rec_emails != 'undefined' && $scope.contact.rec_emails.length==0) ){
				    $scope.alertrecs = [ { type: 'danger', msg: 'Please add atleast one recipient.' } ];
				    $scope.closeAlertrec = function(index) {
					      $scope.alertrecs.splice(index, 1);
					    };
				    return;		
				    
				  }else if($scope.respone5.length === 0 ){
				    $scope.alertcaps = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
				    $scope.closeAlertcap = function(index) {
					      $scope.alertcaps.splice(index, 1);
					    };
				    return;		
				    
				  }
			 
				
				else{
				 var valid;

			 ServiceRequestService.create($scope.contact).$promise.then(function(msg) {
			     
		        $scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 if($scope.SuggestionBoxIsVisible==true)
			         $scope.ShowHideSuggestionBox();
				        $scope.alerts = [
			   	                  { type: 'success', msg: 'An email has been sent to inform the email recipients.' }
			   	                ];
				    $scope.closeAlert = function(index) {
					            
                          if($scope.alerts.length)
                          {
                                
                          if($scope.SuggestionBoxIsVisible==false)
                                $scope.ShowHideSuggestionBox();
                                
                          $scope.alerts.splice(index, 1);          
                          } 
                           
					    };

				 $scope.contact.name = "";
				 $scope.contact.email = "";
				 $scope.contact.role = "";
                 $scope.contact.message = "";
				 $scope.contact.links = $scope.link ;
				 $scope.contact.dummysubject = "Contact us Enquiry";

				 $rootScope.loading = false;
                 
                 $scope.records = [];
                 
                 
       }, 2000);
       
			     
                $timeout(function(){ grecaptcha.reset($scope.widgetId); $scope.respone5 = '';}, 2000);

                 
                 
		 }  
		 }
    };
    
    $scope.cbSelected = function() {
          if ($scope.myCheckbox) {  // when checked
            $scope.email_add = 'contact@centralpropertyexchange.com.au';
          } else {
            $scope.email_add = "";
          }
      };
       $scope.setWidgetId = function (widgetId) {
	        console.log('Created widget ID: %s', widgetId);
	        $scope.widgetId = widgetId;
	    };
      $scope.records = [];
      // $scope.contact.rec_emails = [];
        // Add new data
        $scope.Add = function () {
            // Do nothing if no state is entered (blank)
            if (!$scope.email_add)
               {
                  $scope.alertrecs = [ { type: 'danger', msg: 'Please add valid email address.' } ];
				    $scope.closeAlertrec = function(index) {
					      $scope.alertrecs.splice(index, 1);
					    };
				    return;	
                
               }
                  
                
            
            if (!$scope.role)
                
                {
                    $scope.alertrecs = [ { type: 'danger', msg: 'Please select role.' } ];
				    $scope.closeAlertrec = function(index) {
					      $scope.alertrecs.splice(index, 1);
					    };
				    return;	
                }
                
                 
           $scope.alertrecs = null;
                            
            // Add to main records
            $scope.records.push({
                email_add: $scope.email_add,
                role: $scope.role,
            });
            $scope.contact.rec_emails = $scope.records;
            $scope.Reset();
        }
        
        // Reset new data model
            $scope.Reset = function () {
                $scope.myCheckbox = false,
                $scope.email_add = '';
                $scope.role = '';
            }
            $scope.Reset();
        
        // Delete data
        $scope.Delete = function (index) {
            // Remove from main records (using index)
            $scope.records.splice(index, 1);
            $scope.contact.rec_emails = $scope.records;
        };  
    
    
        $scope.SuggestionBoxIsVisible = true;
        $scope.ShowHideSuggestionBox = function () {
            //If DIV is visible it will be hidden and vice versa.
            $scope.SuggestionBoxIsVisible = !$scope.SuggestionBoxIsVisible;
        }

	}]);