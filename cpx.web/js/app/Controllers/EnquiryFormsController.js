
app.controller('SubmitPropertyRequestCtrl', ['$scope' ,'$rootScope','ContactService','vcRecaptchaService','$http','$timeout','$window', function ($scope,$rootScope,ContactService,vcRecaptchaService,$http,$timeout,$window,widgetId) {

	$rootScope.title= "Central Property Exchange| Real Estate | Submit Your Property";	
	
    $scope.selectedmenu=[{id:0,selected:false},{id:1,selected:false},{id:2,selected:true},{id:3,selected:false},{id:4,selected:false},{id:5,selected:false}];
    
	$rootScope.showMenu = false;
	
    $scope.respone1 = '';
 
    $scope.setResponse = function (response) {
        console.log('Response available');
        $scope.response = response;
    };

     $scope.setWidgetId = function (widgetId) {
	        console.log('Created widget ID: %s', widgetId);
	        $scope.widgetId = widgetId;
	    };
	    	
	 $scope.sendContactEmail=function(){
		 console.log($scope.contact);
			console.log('trea',!$scope.contact.name || !$scope.contact.email);
			if(!$scope.contact.name || !$scope.contact.email || !$scope.contact.role){
				
//				console.log("kam fastay");
			}
			
			else{
			  
			 console.log($scope.widgetId);
			 
			 console.log($scope.respone1);
			 if($scope.respone1.length === 0){
				    $scope.alertcaps = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
				    $scope.closeAlertcap = function(index) {
					      $scope.alertcaps.splice(index, 1);
					    };
				    return;		
				    
				  }
			 
				
				else{
				 var valid;

		         console.log('sending the captcha response to the server');
				
			 
		       
		        
		         /* $scope.dummycontact = {};
			 angular.copy($scope.contact, $scope.dummycontact);*/
			 console.log($scope.contact);
			 //console.log($scope.contact,$scope.dummycontact);
			

			 ContactService.create($scope.contact).$promise.then(function() {
		        //$scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
				    $scope.closeAlert = function(index) {
					            
                          if($scope.alerts.length)
                          {
                                
                             $scope.alerts.splice(index, 1);       
                          } 
                            
					    };
				 
				 $scope.contact.name = "";
				 $scope.contact.email = "";
                 $scope.contact.role = "";
				 $scope.contact.subject = "Property request";
				 $scope.contact.message = 'Please provide a summary of what you are looking for. Example:\nPrice range\nSMSF suitable\nHouse or unit\nLocation\nOther relevant criteria\nOr simply paste a link here' ;
				 $scope.contact.dummysubject = "Submit property request";
				 //grecaptcha.reset(); 
				 $rootScope.loading = false;
             }, 2000);
             
                $timeout(function(){grecaptcha.reset($scope.widgetId); $scope.respone1 = '';}, 2000);
			 
		 }  
		 }
};
	
	
}]);



app.controller('ListYourPropertyCtrl' , ['$scope','$rootScope','$route','ContactService','RegisterService','vcRecaptchaService','$http','$timeout','$window', function ($scope,$rootScope,$route,ContactService,RegisterService,vcRecaptchaService,$http,$timeout,$window,widgetId) {
	
	$rootScope.title= "Central Property Exchange| Real Estate | List Your Property";	

    $scope.selectedmenu=[{id:0,selected:false},{id:1,selected:false},{id:2,selected:false},{id:3,selected:true},{id:4,selected:false},{id:5,selected:false}]; 
	
    $scope.listpropertystatus=[{id:0,value:false},{id:1,value:false}];
    
    $scope.serverPath = baseWebUrl;
    
    $scope.forms = {};
    $scope.forms1 = {};
	
     $scope.respone2 = '';
	 $scope.respone6 = '';
	    $scope.setResponse6 = function (response) {
	        console.log('Response available1');
            $scope.alertcaps1 = [];
	        $scope.respone6 = response;
	    };
	   
       $scope.setResponse2 = function (response) {
	        console.log('Response available');
            $scope.alertcaps = [];
	        $scope.respone2 = response;
	    };
        
        $scope.setWidgetIdRegister = function (widgetId) {
		        console.log('Created widget ID for register for: %s', widgetId);
		        $scope.widgetId = widgetId;
		    };
        
        $scope.setWidgetIdContact = function (widgetId) {
		        console.log('Created widget ID for contact: %s', widgetId);
		        $scope.widgetId = widgetId;
		    };
        
	     
        $scope.redirectpage=function(){
               window.location=$scope.serverPath+"/auth/login";
        };            
            
	 $scope.sendContactEmail=function(){
		 //console.log($scope.forms1.contact);
            
            jQuery.validator.addMethod("lettersonly", function(value, element) {
                      return this.optional(element) || /^[a-z]+$/i.test(value);
                    }, "Letters only please"); 
            
            
            $('#contact-form').validate({
                errorElement: 'div',
                errorClass: 'error-block',
                focusInvalid: false,
                rules: {
                    name: {
                        required: true,
                         lettersonly: true,
                    },                
                    con_email:{
                        required: true,
                        email:true,
                    },
                    
                    role: {
                        required: true,
                        
                    },
                },
        
                messages: {
                    name: {
                        required: "Please enter name .",
                        lettersonly: "Please enter alphabets only .",
                    },
                    con_email:{
                        required:"Please enter email.",
                        email: "Please provide a valid email."
                    },
                    
                    role: {
                        required: "Please select role.",
                        
                    },
                },
        
                invalidHandler: function (event, validator) { //display error alert on form submit   
                    $('.alert-danger', $('.login-form')).show();
                },
        
                highlight: function (e) {
                    $(e).closest('label.block').addClass('has-error');
                },
        
                success: function (e) {
                    $(e).closest('label.block').removeClass('has-error');
                    $(e).remove();
                },
                errorPlacement: function (error, element) {
                    if(element.is(':checkbox') || element.is(':radio')) {
                        var controls = element.closest('div[class*="col-"]');
                        
                        if(controls.find(':checkbox,:radio').length > 1)
                        { 
                            controls.append(error);
                        }
                        else
                        { 
                            error.insertAfter('div[class*="checkb"]');
                        }
                    }
                    else if(element.is('.select2')) {
                        error.insertAfter('div[class*="selectbox"]');
                    }
                    else if(element.is('.chosen-select')) {
                        error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                    }
                    else
                    { 
                        error.insertAfter(element.parent());
                    }
                },
        
                submitHandler: function (form) {
                },
                invalidHandler: function (form) {
                }
            });
            
            $scope.contact = $scope.forms1.contact;
            
            $scope.contact.email = $scope.contact.con_email;
            
			console.log('trea',!$scope.contact.name || !$scope.contact.con_email);
            
            if ($("#contact-form").valid()){
                
    			if(!$scope.contact.name || !$scope.contact.con_email || !$scope.contact.role){
    				
    //				console.log("kam fastay");
    			}
    			
    			else{
              		console.log($scope.widgetId);
    			 
    			 console.log($scope.respone2);
    			 if($scope.respone2.length === 0)                
                 {
    				    $scope.alertcaps = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
    				    $scope.closeAlertcap = function(index) {
    					      $scope.alertcaps.splice(index, 1);
    					    };
    				    return;		
    				    
    				  }
    			 
    				
    				else{
    				 var valid;
    
    		         console.log('sending the captcha response to the server');
    				
    			 
    		       
    		        
    		         /* $scope.dummycontact = {};
    			 angular.copy($scope.contact, $scope.dummycontact);*/
    			 console.log($scope.contact);
    			 //console.log($scope.contact,$scope.dummycontact);
    			
    
    			 ContactService.create($scope.contact).$promise.then(function() {
    		        //$scope.msg = msg.toJSON();
    		     });
    			 $rootScope.loading = true;
    			 $timeout(function() {
    				 $scope.alerts = [
    			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
    			   	                ];
    				    $scope.closeAlert = function(index) {
    					            
                              if($scope.alerts.length)
                              {
                                    
                                 $scope.alerts.splice(index, 1);       
                              } 
                                
    					    };
    				 
    				 $scope.contact.name = "";
    				 $scope.contact.con_email = "";
                     $scope.contact.role = "";
    				 $scope.contact.subject = "List my Property on CPx";
    				 $scope.contact.message = 'Please provide a summary of your property\nOr simply paste a link here' ;
    				 $scope.contact.dummysubject = "List your property";
    				 grecaptcha.reset(); 
    				 $rootScope.loading = false;
              }, 2000);
    			     
                     $timeout(function(){grecaptcha.reset($scope.widgetId); $scope.respone2 = '';}, 2000);
    		 }  
    		 }
       }
    };
        
        $scope.registerUser=function(){
            
            jQuery.validator.addMethod("lettersonly", function(value, element) {
              return this.optional(element) || /^[a-z]+$/i.test(value);
            }, "Letters only please"); 
        
            jQuery.validator.addMethod('fnType', function(value, element) {
                return value.match(/^\+?\d+(?:[0-9] ?){6,14}[0-9]$/);
                },'Enter Valid phone number');
            
            
            $('#register-form').validate({
                errorElement: 'div',
                errorClass: 'error-block',
                focusInvalid: false,
                rules: {
                    email:{
                        required: true,
                        email:true,
                    },
                    password: {
                        required: true,
                        minlength:6,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password",
                    },
                    firstname: {
                        required: true,
                         lettersonly: true,
                    },
                    phone_number: {
                         fnType: {
                            depends: function(element) {
                              return $('#phone_number').val().length > 0;
                            }
                          },
                    },
                    termsandcondition: {
                        required: true,
                        
                    },
                },
        
                messages: {
                    email:{
                        required:"Please enter email.",
                        email: "Please provide a valid email."
                    },
                    password: {
                        required: "Please enter password.",
                        minlength:"Please enter atleast 6 characters password.",
                    },
                    confirm_password: {
                        required: "Please enter confirm password.",
                        equalTo: "Password and confirm password should match."
                        
                    },
                    firstname: {
                        required: "Please enter first name .",
                        lettersonly: "Please enter alphabets only .",
                    },
                    phone_number: {
                        fnType: "Please specify a valid number .",
                    },
                    termsandcondition: {
                        required: "Please select terms and conditions.",
                        
                    },
                },
                
                invalidHandler: function (event, validator) { //display error alert on form submit   
                    $('.alert-danger', $('.login-form')).show();
                },
        
                highlight: function (e) {
                    $(e).closest('label.block').addClass('has-error');
                },
        
                success: function (e) {
                    $(e).closest('label.block').removeClass('has-error');
                    $(e).remove();
                },
                errorPlacement: function (error, element) {
                    if(element.is(':checkbox') || element.is(':radio')) {
                
                        var controls = element.closest('div[class*="col-"]');
                        
                        if(controls.find(':checkbox,:radio').length > 1)
                        { 
                            controls.append(error);
                        }
                        else
                        { 
                            error.insertAfter('div[class*="checkb"]');
                        }
                    }
                    else if(element.is('.select2')) {
                        error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                    }
                    else if(element.is('.chosen-select')) {
                        error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                    }
                    else error.insertAfter(element.parent());
                },
        
                submitHandler: function (form) {
                },
                invalidHandler: function (form) {
                }
            });
            
            if ($("#register-form").valid()){
            
                $scope.register = $scope.forms.register;
                
    			if(!$scope.register.email || !$scope.register.password || !$scope.register.confirm_password || !$scope.register.firstname  || !$scope.register.termsandcondition)
                {
    				
    //				console.log("kam fastay");
    			}
    			
    			else
                {
              		console.log('widgetid==>'+$scope.widgetId);
    			 
        			 console.log($scope.respone6);
        			 if($scope.respone6.length === 0)
                     {
        				    $scope.alertcaps1 = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
        				    $scope.closeAlertcap = function(index) {
        					      $scope.alertcaps1.splice(index, 1);
        					    };
        				    return;		
        				    
        				  }
        			 
        				
        				else{
        				 var valid;
        
        		         console.log('sending the captcha response to the server');
        				
        			 
        		       
        		        
        		         /* $scope.dummyregister = {};
        			 angular.copy($scope.register, $scope.dummyregister);*/
        			 console.log($scope.register);
        			 //console.log($scope.register,$scope.dummyregister);
        			
                    
        
        			 RegisterService.create($scope.register).$promise.then(function(data) {
        			     
        		        $timeout(function() {
            				 $scope.alerts = [
            			   	                  { type: data.message_type, msg: data.message }
            			   	                ];
            				    $scope.closeAlert = function(index) {
            					            
                                      if($scope.alerts.length)
                                      {
                                            
                                         $scope.alerts.splice(index, 1);       
                                      } 
                                        
            					    };
            				 
            				 
                      }, 2000);
        		     });
        			 $rootScope.loading = true;
        			 $timeout(function() {
        				  
        				    $scope.closeAlert = function(index) {
        					            
                                  if($scope.alerts.length)
                                  {
                                        
                                     $scope.alerts.splice(index, 1);       
                                  } 
                                    
        					    };
        				 
        				 $scope.register.email = "";
        				 $scope.register.password = "";
                         $scope.register.confirm_password = "";
        				 $scope.register.firstname = "";
                         $scope.register.lastname = "";
                         $scope.register.phone_number = "";
                         $scope.register.company_name = "";
        				 $scope.register.dummysubject = "Registration";
                         $scope.register.termsandcondition="";
        				 grecaptcha.reset(); 
        				 $rootScope.loading = false;
                  }, 2000);
        			     
                    $timeout(function(){grecaptcha.reset($scope.widgetId); $scope.respone6 = '';}, 2000);
        		 }  
    		 }
            }
        };
        
	    }]);





app.controller('SubmitFreeMembershipCtrl' , ['$scope','$rootScope','ContactService','vcRecaptchaService','$http','$timeout', function ($scope,$rootScope,ContactService,vcRecaptchaService,$http,$timeout) {
	
	$rootScope.title= "Central Property Exchange| Industry Professionals | Submit Free Membership Request";	
	
	$scope.respone4= '';

	 
	    $scope.setWidgetId = function (widgetId) {
	        console.info('Created widget ID: %s', widgetId);
	        $scope.widgetId = widgetId;
	    };
	
	
	 $scope.sendContactEmail=function(){
		 console.log($scope.contact);
			console.log('trea',!$scope.contact.name || !$scope.contact.email);
			if(!$scope.contact.name || !$scope.contact.email){
				
//				console.log("kam fastay");
			}
			
			else{
			  
			 console.log($scope.widgetId);
			 
			 console.log($scope.respone4);
			 if($scope.respone4.length === 0){
				    $scope.alertcaps = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
				    $scope.closeAlertcap = function(index) {
					      $scope.alertcaps.splice(index, 1);
					    };
				    return;	
				    
				  }
			 
				
				else{
				 var valid;

		         console.log('sending the captcha response to the server');
				
			 
		       
		        
		         /* $scope.dummycontact = {};
			 angular.copy($scope.contact, $scope.dummycontact);*/
			 console.log($scope.contact);
			 //console.log($scope.contact,$scope.dummycontact);
			

			 ContactService.create($scope.contact).$promise.then(function() {
		        //$scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
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
				 $scope.contact.subject = "Industry professionals new membership request";
				 $scope.contact.message = '' ;
				 $scope.contact.dummysubject = "Submit free membership request";
				 grecaptcha.reset(); 
				 $rootScope.loading = false;
       }, 2000);
			 
		 }  
		 }
};
	
}]);


app.controller('SubmitServiceRequestCtrl' , ['$scope','$rootScope','ContactService','vcRecaptchaService','$http','$timeout', function ($scope,$rootScope,ContactService,vcRecaptchaService,$http,$timeout,widgetId,widgetId1) {
	
	$rootScope.title= "Central Property Exchange| CPx Marketplace | Submit Service Request";	
	
	 $scope.respone3= '';

	    
	 
	    $scope.setResponse = function (response) {
	       // console.log('Response available');
	        $scope.response = response;
	    };
	    $scope.cbExpiration = function() {
	        //console.log('Captcha expired. Resetting response object');
	        $scope.response = null;
	     };

	     $scope.setWidgetId = function (widgetId) {
		        //console.log('Created widget ID: %s', widgetId);
		        $scope.widgetId = widgetId;
		    };
   
	
	$scope.sendContactEmail=function(){
		// console.log($scope.contact);
			//console.log('trea',!$scope.contact.name || !$scope.contact.email);
			if(!$scope.contact.name || !$scope.contact.email){
				
//				console.log("kam fastay");
			}
			
			else{
			  
			 //console.log($scope.widgetId);
			 
			 //console.log($scope.respone3);
			 if($scope.respone3.length === 0){
				    $scope.alertcaps = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
				    $scope.closeAlertcap = function(index) {
					      $scope.alertcaps.splice(index, 1);
					    };
				    return;	
				    
				  }
			 
				
				else{
				 var valid;

		        
			 ContactService.create($scope.contact).$promise.then(function() {
		        //$scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
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
				 $scope.contact.subject = "Service request";
				 $scope.contact.message = '' ;
				 $scope.contact.dummysubject = "Submit service request";
				 grecaptcha.reset(); 
				 $rootScope.loading = false;
          }, 2000);
			 
		 }  
		 }
}
}]);


app.controller('RequestFreeIprCtrl', ['$scope' ,'$rootScope','$location','RequestIprService','CommonShareService','vcRecaptchaService','$http','$timeout','$window', function ($scope,$rootScope,$location,RequestIprService,CommonShareService,vcRecaptchaService,$http,$timeout,$window,widgetId) {

	$rootScope.title= "Central Property Exchange| Real Estate | Submit Your Property";	
	
	 $scope.respone5= '';
	 
	 var host = $location.host();
	 
	 console.log('THe host is : ' +host);
	 
	 $scope.thisProperty=  CommonShareService.getid();
	 
	 console.log($scope.thisProperty);
	 
	 $scope.currpropid =  $scope.thisProperty.id;
	 
	 console.log($scope.currpropid);
	 
	 $scope.propertyContacts=$scope.thisProperty.contact;
	 
     $scope.requestformsubject ="Request for ipr and grade report on your CPx listed property";
     
	 $scope.emails =[];
	 $scope.uniemails=[];
	 
	/* for(i = 0; i< $scope.propertyContacts.length; i++){    
	       if( $scope.emails.indexOf($scope.propertyContacts[i].email) === -1){
	    	   $scope.emails.push( $scope.propertyContacts[0].email);        
	    	   
	       } 
	       
	   }*/
	 /*
	 angular.forEach($scope.propertyContacts, function(contact, index) {
         $scope.emails.push({label : contact.email});
       });
	 
	 for(i = 0; i< $scope.emails.length; i++){    
	       if( $scope.uniemails.indexOf($scope.emails[i]).label === -1){
	    	   $scope.uniemails.push($scope.emails[0].label);        
	       } 
	 }
	 //$scope.vurrid = ShareURLService.getPropertyId()
	 console.log($scope.propertyContacts);
	 console.log($scope.uniemails);*/
	 
	 
	    $scope.emaillabels = [];
	    angular.forEach( $scope.propertyContacts, function(contact, index) {
	          $scope.emaillabels.push({name: contact.name, label : contact.email});
	        });
	    
	   
	   
	 $scope.uniqueNames = [];
	
	   /*for(i = 0; i< $scope.emaillabels.length; i++){    
	       if( ($scope.uniqueNames.indexOf($scope.emaillabels[i].label) === -1) && ($scope.emaillabels[i].label != '') ){
	    	  
	    	   $scope.uniqueNames.push($scope.emaillabels[i].label);        
	    	   
	       } 
	       
	   }*/
	 
	 for(i = 0; i< $scope.emaillabels.length; i++){    
	       if( $scope.emaillabels[i].label != '') {
	    	  
	    	  // $scope.uniqueNames.push($scope.emaillabels[i].label);        
	    	   $scope.uniqueNames.push({name: $scope.emaillabels[i].name, label : $scope.emaillabels[i].label});
	       } 
	       
	   }
	 console.log($scope.uniqueNames);
	   $scope.contact ={};
	   
	   $scope.contact.propertyid=  $scope.currpropid;
	   //$scope.contact.emailRecipients = $scope.uniqueNames.join(',');
	   $scope.contact.emailRecipients = $scope.uniqueNames;
	   
	   
	   //console.log($scope.uniqueNames.join(',')); // 'a1,b1,c1'
	  
	 //console.log($scope.uniqueNames);
	
	    $scope.setResponse = function (response) {
		       // console.log('Response available');
		        $scope.response = response;
		    };
		    $scope.cbExpiration = function() {
		        //console.log('Captcha expired. Resetting response object');
		        $scope.response = null;
		     };

		     $scope.setWidgetId = function (widgetId) {
			        //console.log('Created widget ID: %s', widgetId);
			        $scope.widgetId = widgetId;
			    };
	   
			   	    
	//$scope.propertyContacts.contacts= myService.getMyData();
				
	
			    
		
			    
		$scope.sendRequestIprFormEmail=function(){
			 //console.log($scope.contact);
				//console.log('trea',!$scope.contact.name || !$scope.contact.email);
			console.log($scope.contact);
			//console.log();
				if(!$scope.contact.name || !$scope.contact.email || ($scope.contact.requestformrole == 'Please select role') || !$scope.contact.requestformplace || !$scope.contact.requestformstate){
					
//					console.log("kam fastay");
				}
				
				else{
				  
				 //console.log($scope.widgetId);
				 
				 //console.log($scope.respone5);
				 if($scope.respone5.length === 0){
					    $scope.alertcaps = [ { type: 'danger', msg: "Please select I'm not a robot." } ];
    				    $scope.closeAlertcap = function(index) {
    					      $scope.alertcaps.splice(index, 1);
    					    };
					    return;		
					    
					  }
				 
					
					else{
					 var valid;
					 
				//$scope.contact ={};	 
					 
					 
				//$scope.contact.mailSendto = $scope.
			     
				RequestIprService.create($scope.contact).$promise.then(function(msg) {
						 $scope.msg = msg.toJSON();
			     });
                                  
				 $rootScope.loading = true;
				 $timeout(function() {
					 $scope.alerts = [
				   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
				   	                ];
					    $scope.closeAlert = function(index) {
					            
                          if($scope.alerts.length)
                          {                                                
                             $scope.alerts.splice(index, 1);       
                          } 
                            
					    };
					 
					 $scope.contact.name = "";
					 $scope.contact.email = "";
					 $scope.contact.requestformrole = "";
                     $scope.contact.requestformplace = "";
					 $scope.contact.message = '' ;
					 $scope.contact.dummysubject = "Submit service request";
					 
					 $rootScope.loading = false;
	          }, 2000);
              
                    $timeout(function(){grecaptcha.reset($scope.widgetId); $scope.respone5 = '';}, 2000);
				 
			 }  
			 }
	}
	 
		
	 
}]);	