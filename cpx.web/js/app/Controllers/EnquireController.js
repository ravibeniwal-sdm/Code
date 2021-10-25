app.controller('EnquireCtrl', ['$scope', 'EnquireService','$rootScope','CommonShareService','ShortlistService','vcRecaptchaService','$http','$timeout','QueryService','$filter', function ($scope, EnquireService, $rootScope, CommonShareService,ShortlistService,vcRecaptchaService,$http,$timeout,QueryService,$filter) {
	
	$rootScope.metakeywords = "CPx,Email,Contact,Message,Telephone,Management,Questions,Email address,Contact details,Key management,Telephone number,Central Property Exchange,Online right now,Chat via Skype with us,Find out more about CPx,Comments and questions,Based in Sydney and Perth,How to make contact with CPx";
	
	$rootScope.title= "Central Property Exchange | Real Estate| Contact";
	
	$rootScope.description="Central Property Exchange � Contact Page - Buy And Sell Residential And Investment Properties � Key Management in Sydney and Perth Australia.";
	
	$rootScope.loading=false;
	//$scope.contact=[];
	$scope.link= "";
	$scope.auction_add="";
    $scope.widgetId = "";

  
    var toggle_val = '';
    toggle_val = angular.fromJson(sessionStorage.toggle_val);
    $scope.toggle_val = toggle_val;
	
  var checkflag = CommonShareService.getallid();
  $scope.properties = {};   
  $scope.propertDetails = {};	
  $scope.currentproperty={};	  
  if(checkflag == false){
   $scope.currid = CommonShareService.getenquireid();	
	
        
    
	//console.log($scope.id);
	
	//PropertyService.success(function(data) {
	//QueryService.success(function(data) {

	console.log($scope.currid);
   
	if ($scope.currid != null){	  
	   $scope.id = $scope.currid;
       $scope.propertDetails.id = $scope.id;

//console.log("in if");         
  // console.log($scope.currid);
       
                    	QueryService.create($scope.propertDetails).$promise.then(function(data) {
                    			
                                $scope.properties =data.properties;
                                
                                var current_index = $filter('get-property-filter')($scope.properties, $scope.id);
                                $scope.currentproperty = $scope.properties[current_index];
                            	
                                //console.log($scope.currentproperty.address[0].LotNumber);
                                $scope.propertyAdd = ($scope.currentproperty.address[0].subNumber!=null ? $scope.currentproperty.address[0].subNumber +'/ ':($scope.currentproperty.address[0].LotNumber!=null? $scope.currentproperty.address[0].LotNumber :" "))+ ($scope.currentproperty.address[0].StreetNumber!=null?$scope.currentproperty.address[0].StreetNumber+' ' :" " )+($scope.currentproperty.address[0].street!=null?$scope.currentproperty.address[0].street :" ")+($scope.currentproperty.address[0].suburb.text!=null?', '+$scope.currentproperty.address[0].suburb.text:" ")+($scope.currentproperty.address[0].city!=null?', '+$scope.currentproperty.address[0].city+' ':", ")+($scope.currentproperty.address[0].state!=null?$scope.currentproperty.address[0].state+' ':" ")+($scope.currentproperty.address[0].postcode!=null?$scope.currentproperty.address[0].postcode:"");
                                
                                $scope.contact.subject = 'Enquiry: '+ $scope.propertyAdd;
                                
                                $scope.contact.propertyIds = $scope.currid;
                                var inspect = [];
    	   
   	                        console.log($scope.currentproperty);
                            
                                $scope.contactexist = false;
                                $scope.ownerexist = false;
                                angular.forEach($scope.currentproperty.contact, function(contact_arr, i) {
                                     if(contact_arr.display_val == undefined || contact_arr.display_val)
                                        $scope.contactexist = true;  
                                    
                                    if(contact_arr.type =='vendorDetails')
                                    {
                                        if(contact_arr.display_val !== undefined && contact_arr.display_val)
                                            $scope.ownerexist = true;     
                                    }                                                
                                });         
                                
                                console.log("contactexist");	
                               console.log($scope.contactexist);	  
                               console.log("ownerexist");	
                                console.log($scope.ownerexist);                                 
                            
                        	   if($scope.currentproperty.inspectionTimes.length!=0){
                        		   //console.log($scope.currentproperty.inspectionTimes.length);
                        	    angular.forEach($scope.currentproperty.inspectionTimes, function(inspector, index) {
                        	    	//inspect.push(inspector.inspection.slice(0,11));
                        	    	//inspect.push(moment(inspector.inspection.slice(0,11)));
                        	    	var str = inspector.inspection.slice(0,11);
                        	       var res = str.replace(/-/g, "/");
                        	       var formattedinspect = moment(res , 'DD/MMM/YYYY').format('MM/DD/YYYY')
                                   
                                   	var strtime = inspector.inspection.slice(12);
                                    var restime = strtime.replace("to", "-");
                        	       //console.log(res);
                        	       //console.log(formattedinspect);
                        	    	//inspect.push({label :moment(formattedinspect), time : inspector.inspection.slice(12)});
                                    inspect.push({label :moment(formattedinspect), time : restime});
                      	        });
                        	   }
                        	   inspect.sort(function(a, b){
                    
                        	       if(a.label > b.label){
                        	        return 1;
                        	       }
                        	        else if(a.label < b.label){
                        	        return -1;
                        	       } 
                        	       return 0;
                        	       });
                                
                               // console.log("inspect");               
                        	   //console.log(inspect);
                        	   
                        	   var inspect3 = [];
                        	    angular.forEach(inspect , function(dateobj , index) {
                        	    	inspect3.push({label : moment(dateobj.label).format('dddd DD MMM YYYY') , time : dateobj.time});
                      	        });
                        	    
                        	    $scope.inspect3 = inspect3;
                        	    
                    			 //$scope.currentproperty.auction_date  = "2017-02-22";
                                 if($scope.currentproperty.auction_date.length!=0){
                        			 var s =  $scope.currentproperty.auction_date;
                        			    $scope.parsedDate = {            
                        			        DDt: Date.parse(s)
                        			    }
                        			    var df = 'MM/DD/YYYY'
                        			    var d1 = moment($scope.currentproperty.auction_date , "YYYY-MM-DD-hh:mm:ss");
                        
                        			    var d2 =  moment();
                        			  
                        			    var days1 = Math.round(moment.duration(d1.diff(d2)).asDays());
                        			  
                        			    $scope.days = days1;
                        			    console.log("auction days to go "+$scope.days);
                        			    if($scope.days > 0){
                        			    	$scope.auctionstatus = 'yes';
                        			    }
                        			    else if($scope.days < 0){
                        			    	$scope.auctionstatus = 'no';
                        			    }
                        			    else if($scope.days == 0){
                        			    	$scope.auctionstatus = 'today';
                        			    }
                                        console.log("auction status "+$scope.auctionstatus);
                        			    //console.log(days1);
                        			    
                        			    
                        			 }
                    			 if($scope.currentproperty.auction_date.length!=0){
                    				 var auction_dateformatted =  $scope.currentproperty.auction_date;
                    				 
                    				 var newauct = moment(auction_dateformatted , "YYYY-MM-DD-hh:mm:ss").format('DD MMM YYYY h:mm A');
                    				 
                    				 
                    				 $scope.auctionDate = newauct;
                    				 
                    				 }    
                                            
                                
                                
                        
                       }); 
   
               
    	   
    	   
        		
        		$scope.link	= "<b>Property link: </b>http://centralpropertyexchange.com.au/#!/details/"+$scope.currid;
                
        	}
   
   //console.log("currentprop");         
   //console.log($scope.currentproperty);
         /*   
         */       
   
  }

    
    $scope.toggle_enquire_servicerequest = function (val) {
							
					
		  sessionStorage.toggle_val = angular.toJson(val); 	   
	  };
    	
  var checkflag = CommonShareService.getallid();
	
  if(checkflag == true){	
	
	
	$scope.list = ShortlistService.getProducts();
	
	
	if($scope.list != undefined){
				
		for(i=0;i<$scope.list.length;i++){
			
			$scope.link = $scope.link +"http://centralpropertyexchange.com.au/#!/details/"+$scope.list[i].id+"\n";		
		
		}
		

		}
        
    // $scope.properties = ShortlistService.getProducts();
    // console.log($scope.properties);	   
        
	
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

			 EnquireService.create($scope.contact).$promise.then(function(msg) {
			     
		        $scope.msg = msg.toJSON();
		     });
            
			 $rootScope.loading = true;
			 $timeout(function() {

                 if($scope.SuggestionBoxIsVisible==true)
			         $scope.ShowHideSuggestionBox();
                     
                     
                     $scope.alerts = [
			   	                  { type: 'success', msg: 'An email has been sent to inform the property owner/agent and their team.' }
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
                 
                    }, 2000);
                
                $timeout(function(){grecaptcha.reset($scope.widgetId); $scope.respone5 = '';}, 2000);
                			 
		 }  
		 }
};

        $scope.SuggestionBoxIsVisible = true;
        $scope.ShowHideSuggestionBox = function () {
            //If DIV is visible it will be hidden and vice versa.
            $scope.SuggestionBoxIsVisible = !$scope.SuggestionBoxIsVisible;
        }

	}]);