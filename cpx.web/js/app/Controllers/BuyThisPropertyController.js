app.controller('BuyThisPropertyCtrl', ['$scope', 'BuyThisPropertyService','$rootScope','CommonShareService','ShortlistService','vcRecaptchaService','$http','$timeout','QueryService','$filter', '$routeParams','$window', function ($scope, BuyThisPropertyService, $rootScope, CommonShareService,ShortlistService,vcRecaptchaService,$http,$timeout,QueryService,$filter,$routeParams,$window) {
	
	$rootScope.metakeywords = "CPx,Email,Contact,Message,Telephone,Management,Questions,Email address,Contact details,Key management,Telephone number,Central Property Exchange,Online right now,Chat via Skype with us,Find out more about CPx,Comments and questions,Based in Sydney and Perth,How to make contact with CPx";
	
	$rootScope.title= "Central Property Exchange | Real Estate| Contact";
	
	$rootScope.description="Central Property Exchange � Contact Page - Buy And Sell Residential And Investment Properties � Key Management in Sydney and Perth Australia.";
	$scope.pid = $routeParams.pid;
    
	$rootScope.loading=false;
	//$scope.contact=[];
	$scope.link= "";
	$scope.domacomflag = "";
    $scope.smfsflag = "";
    $scope.vendorfinanceflag = "";
    $scope.widgetId = "";
    
console.log($scope.pid);
  if($scope.pid == 'traditional' || $scope.pid == 'smsf' || $scope.pid == 'domacom' || $scope.pid == 'vendorfinance'  || $scope.pid == 'affordassist')
  {
  
  console.log($scope.pid);
  $scope.properties = {};   
  $scope.propertDetails = {};	
  $scope.currentproperty={};	  
  
  var pass_params = "";
  var header = "";
  var subject = "";
  var msg = "";
    
  $scope.currid = CommonShareService.getbuythisid();
  	
    if($scope.pid == 'traditional' || $scope.pid == 'domacom')
    {
        pass_params = $filter('ucfirst')($scope.pid);
        header = subject = 'Buy this property via '+pass_params;        
        msg = 'buy this property via '+pass_params;        
    }
    else if($scope.pid == 'vendorfinance')
    {
        pass_params = 'Vendor Finance';
        header = subject = 'Buy this property with '+pass_params; 
        msg = 'buy this property with '+pass_params;          
    }
    else if($scope.pid == 'affordassist')
    {
        pass_params = 'AffordAssist';
        header = subject = 'Buy this property via '+pass_params; 
        msg = 'buy this property via '+pass_params;          
    }
    else
    {
        pass_params = $filter('uppercase')($scope.pid);
        header = subject = 'Buy this property via '+pass_params;    
        msg = 'buy this property via '+pass_params;    
    }
        
   $scope.pass_params = pass_params;                
   $scope.subject = subject;
   $scope.header = header;
    
   console.log($scope.currid);
   
	if ($scope.currid != null){	  
        $scope.id = $scope.currid;
        $scope.propertDetails.id = $scope.id;
        

console.log("in if");         
console.log($scope.propertDetails);
console.log("in after if");
       
                    	QueryService.create($scope.propertDetails).$promise.then(function(data) {
                    			
                                $scope.properties =data.properties;
                                console.log(data);
                                
                                console.log($scope.properties);
                                
                                var current_index = $filter('get-property-filter')($scope.properties, $scope.currid);
                                $scope.currentproperty = $scope.properties[current_index];
                                
                                
                                var link1 ="Dear property owner/ agent, <br/><br/> I / we would like to "+msg+' <br/><br/>';
                                                            	                                
                              var link =  '<b>Property address: </b>'+ ($scope.currentproperty.address[0].subNumber!=null ? $scope.currentproperty.address[0].subNumber +'/ ':($scope.currentproperty.address[0].LotNumber!=null? $scope.currentproperty.address[0].LotNumber :" "))+ ($scope.currentproperty.address[0].StreetNumber!=null?$scope.currentproperty.address[0].StreetNumber+' ' :" " )+($scope.currentproperty.address[0].street!=null?$scope.currentproperty.address[0].street :" ")+($scope.currentproperty.address[0].suburb.text!=null?', '+$scope.currentproperty.address[0].suburb.text:" ")+($scope.currentproperty.address[0].city!=null?', '+$scope.currentproperty.address[0].city+' ':", ")+($scope.currentproperty.address[0].state!=null?$scope.currentproperty.address[0].state+' ':" ")+($scope.currentproperty.address[0].postcode!=null?$scope.currentproperty.address[0].postcode:"");
                                 
                                 var link_tag = "http://centralpropertyexchange.com.au/#!/details/"+$scope.currid;
                                 link = link + "<br/><b>Property link: </b><a href='"+link_tag+"'>"+link_tag+"</a>";
                                 
                                // console.log(link);
                                 
                                //$scope.contact.links = link;
                                                                        
                               // $scope.contact.propertyIds = $scope.currid;
                                $scope.link = link;
                                $scope.link1 = link1;
                                

                                $scope.domacomflag = $scope.currentproperty.domacom;
                                $scope.smsfflag = $scope.currentproperty.smsf;
                                 
                                 if(typeof $scope.currentproperty.vendorfinance != "undefined")
                                    $scope.vendorfinanceflag = $scope.currentproperty.vendorfinance;
                        
                       }); 
   
               
    	   
    	   
        		
        		//$scope.link	= "Property link: http://centralpropertyexchange.com.au/#!/details/"+$scope.currid;
                
        	}
	
//  console.log("try1"+$rootScope.shownothing);
  
   if($rootScope.shownothing != false){
	   
	   $scope.link = '';
   }
	  
  }
  
  
   $scope.respone5 = '';
   
	 $scope.sendContactEmail=function(redirect){
	   
       
			if(!$scope.contact.name || !$scope.contact.email  || !$scope.contact.role)
            {
				
				//console.log("kam fastay");
			}
			else
            {
    			 if($scope.respone5.length === 0)
                 {
    				    $scope.alertcaps = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
    				    $scope.closeAlertcap = function(index) {
    					      $scope.alertcaps.splice(index, 1);
    					    };
    				    return false;		
    				    
    		      }
    			 else
                 {
        			 BuyThisPropertyService.create($scope.contact).$promise.then(function(msg) {
        			     
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
			     
                 //console.log(grecaptcha);
                 //var response111 = vcRecaptchaService.getResponse($scope.widgetId);
                 //console.log(response111);
                 $timeout(function(){ grecaptcha.reset($scope.widgetId); $scope.respone5 = '';}, 2000);
                 
                 if(redirect)
                 {
                     document.getElementById('newWindow').click();
                 }
                 
                 
		      }  
		 }
};
         $scope.setWidgetId = function (widgetId) {
	        console.log('Created widget ID: %s', widgetId);
	        $scope.widgetId = widgetId;
	    };
        
        $scope.gotomail = function (param) {
            var landingUrl = "#!/buy_this_property/"+param;
            $window.location.href = landingUrl;
        }

	}]);