app.controller('dashBoardCtrl', ['$scope','$rootScope','$location', 'FileUploader','$http', function ($scope,$rootScope,$location,FileUploader,$http ) {

	
	/*$scope.showMenu = sideMenuStatus.setShowsidemenu('true');
	
	console.log($scope.showMenu);
	*/
	$rootScope.showMenu = true;
	
	$scope.address = {};
	$scope.physicalAttributes = {};

	//console.log('hfjh');
	var starttime = new Date();
	  starttime.setHours(8);
	  starttime.setMinutes(0);
	  var endtime = new Date();
	  endtime.setHours(17);
	  endtime.setMinutes(0);
	  
	  $scope.item = {
	    startDate: starttime,
	    endDate: endtime,
	    duration: function () { return moment.duration(moment(this.endDate) - moment(this.startDate)).asHours() }
	  }

	  $scope.setEndDate = function() {
	    $scope.item.endDate.setDate($scope.item.startDate.getDate());
	    $scope.item.endDate.setMonth($scope.item.startDate.getMonth());
	    $scope.item.endDate.setFullYear($scope.item.startDate.getFullYear());
	  }

	  $scope.openPicker = function ($event, pickerInstance) {
	    $event.preventDefault();
	    $event.stopPropagation();
	    $scope[pickerInstance] = true;
	  };

	    
	$scope.toggleClass = function() {
	    	var myEl = angular.element( document.querySelector('.row-offcanvas' ) );
	        myEl.toggleClass('active1');  
	        var toggles = angular.element( document.querySelector('.c-hamburger' ) );
		    toggles.toggleClass('is-active');
	       }
	
	$scope.animatebutton = function() {
	   
	
	}
	
	
	/////////////FORM WIZARD///////////////////
	
	$scope.steps = [
	  		      { badge:'1', title:'PROPERTY DETAILS' },              
	  		      { badge:'2', title:'CONTACT/INQUIRY DETAILS' },
	  		      { badge:'3', title:'CONFIRM DETAILS' },
	  		      { badge:'4', title:'MAKE PAYMENT' }
	  		     
	  		  ];
	
	
	//console.log($scope.steps.title);
	
	 /*$scope.steps = [
	     		    'Step 1: Team Info',
	     		    'Step 2: Campaign Info',
	     		    'Step 3: Campaign Media'
	     		  ];*/
		  /*$scope.badges=['1','2','3']*/
		  
		  $scope.selection = $scope.steps[0];

		  $scope.getCurrentStepIndex = function(){
		    // Get the index of the current step given selection
			// console.log($scope.steps.indexOf($scope.selection)); 
		    return $scope.steps.indexOf($scope.selection);
		   
		  };

		  // Go to a defined step index
		  $scope.goToStep = function(index) {
		    if ($scope.steps[index] != undefined)
		    {
		      $scope.selection = $scope.steps[index];
		    }
		  };

		  $scope.hasNextStep = function(){
		    var stepIndex = $scope.getCurrentStepIndex();
		    var nextStep = stepIndex + 1;
		    // Return true if there is a next step, false if not
		    
		    if($scope.steps[nextStep] !=undefined){
		    	return true;
		    }else{
		    	return false;
		    }
		    
		  };

		  $scope.hasPreviousStep = function(){
		    var stepIndex = $scope.getCurrentStepIndex();
		    var previousStep = stepIndex - 1;
		    // Return true if there is a next step, false if not
		    
		    if($scope.steps[previousStep] !=undefined){
		    	return true;
		    }else{
		    	return false;
		    }
		    
		    //return !_.isUndefined($scope.steps[previousStep]);
		  };

		  $scope.incrementStep = function() {
		    if ( $scope.hasNextStep() )
		    {
		      var stepIndex = $scope.getCurrentStepIndex();
		      var nextStep = stepIndex + 1;
		      $scope.selection = $scope.steps[nextStep];
		    }
		  };

		  $scope.decrementStep = function() {
		    if ( $scope.hasPreviousStep() )
		    {
		      var stepIndex = $scope.getCurrentStepIndex();
		      var previousStep = stepIndex - 1;
		      $scope.selection = $scope.steps[previousStep];
		    }
		  };
	
		  
		  //////////////////////////////
		  
		  
		  var uploader = $scope.uploader = new FileUploader({
	            url: 'upload.php'
	        });

	        // FILTERS

	        uploader.filters.push({
	            name: 'imageFilter',
	            fn: function(item /*{File|FileLikeObject}*/, options) {
	                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
	               return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
	            }
	        });

			  var uploader2 = $scope.uploader2 = new FileUploader({
		            url: 'upload.php'
		        });

		        // FILTERS

		        uploader2.filters.push({
		            name: 'imageFilter',
		            fn: function(item /*{File|FileLikeObject}*/, options) {
		                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
		                return '|jpg|png|jpeg|gif|pdf|doc|xls|'.indexOf(type) !== -1;
		            }
		        });
		        
		        
		        var uploader3 = $scope.uploader3 = new FileUploader({
		            url: 'upload.php'
		        });

		        // FILTERS

		        uploader3.filters.push({
		            name: 'imageFilter',
		            fn: function(item /*{File|FileLikeObject}*/, options) {
		                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
		                return '|jpg|png|jpeg|gif|pdf|doc|xls|'.indexOf(type) !== -1;
		            }
		        });
		        
		        var uploader4 = $scope.uploader4 = new FileUploader({
		            url: 'upload.php'
		        });

		        // FILTERS

		        uploader4.filters.push({
		            name: 'imageFilter',
		            fn: function(item /*{File|FileLikeObject}*/, options) {
		                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
		                return '|jpg|png|jpeg|gif|pdf|doc|xls|'.indexOf(type) !== -1;
		            }
		        });
	        
	        // CALLBACKS

	        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
	            console.info('onWhenAddingFileFailed', item, filter, options);
	        };
	        uploader.onAfterAddingFile = function(fileItem) {
	            console.info('onAfterAddingFile', fileItem);
	        };
	        uploader.onAfterAddingAll = function(addedFileItems) {
	            console.info('onAfterAddingAll', addedFileItems);
	        };
	        uploader.onBeforeUploadItem = function(item) {
	            console.info('onBeforeUploadItem', item);
	        };
	        uploader.onProgressItem = function(fileItem, progress) {
	            console.info('onProgressItem', fileItem, progress);
	        };
	        uploader.onProgressAll = function(progress) {
	            console.info('onProgressAll', progress);
	        };
	        uploader.onSuccessItem = function(fileItem, response, status, headers) {
	            console.info('onSuccessItem', fileItem, response, status, headers);
	        };
	        uploader.onErrorItem = function(fileItem, response, status, headers) {
	            console.info('onErrorItem', fileItem, response, status, headers);
	        };
	        uploader.onCancelItem = function(fileItem, response, status, headers) {
	            console.info('onCancelItem', fileItem, response, status, headers);
	        };
	        uploader.onCompleteItem = function(fileItem, response, status, headers) {
	            console.info('onCompleteItem', fileItem, response, status, headers);
	        };
	        uploader.onCompleteAll = function() {
	            console.info('onCompleteAll');
	        };

	        //console.log('uploader', uploader);
	   
	        
	   //SCREEN 1
	        	     
	        	/*$scope.symbol = '₹';
	        	  $scope.propertyForSale = {
	        	     availableOptions: [
	        	       {id: "1", name: "$"},
	        	       {id: "2", name: "₹"},
	        	       {id: "3", name: "£"},
	        	       {id: "4", name: "¥"},
	        	       {id: "5", name: "€"}
	        	     ],
	        	     selectedOption: {id: "1", name: "$"} //This sets the default value of the select in the ui
	        	     };*/
	        
	        //SCRREN 2
	        

		$scope.contacts={};
		$scope.inquiries=[];
		$scope.inquiryinput={};
		$scope.property={};
		//$scope.inquiry={};
		$scope.showInquiryForm = true;	
		
		if($scope.inquiries.length=== 0 ){
			$scope.showInquiryForm = true;
		}
		
		$scope.showForm = function(){
			return $scope.showInquiryForm = false;		
		} 
		$scope.showFormAfterAdd = function(){
			return $scope.showInquiryForm = true;
		}
		
	
	        
			$scope.addcontact = function(inquiry){
				$scope.inquiryinput={};
			    /*var inquiry = {
			        email: $scope.email,
			        mobile: $scope.mobile,
			        includemobile: $scope.includemobile,
			        role: $scope.role,
			        primarycontact: $scope.primarycontact,
			        includeas: $scope.includeas,
			    };*/
			    
				//console.log(inquiry);
			    $scope.inquiries.push(inquiry);
			    //console.log($scope.inquiries.length);
			    
			    $scope.inquiryinput={};
			 /*   $scope.inquiryinput = null;*/
  
			  };
			   
			   $scope.removecontact = function(index){
				   $scope.inquiries.splice(index, 1);
				   if($scope.inquiries.length==0){
					   $scope.showInquiryForm = true;
				   }		
			   };    
			   
			   $scope.editcontact = function(index,inquiry){
				   $scope.inquiryinput = inquiry;
				   $scope.inquiries.splice(index, 1);
				  
				  
			  }
	
}]);
