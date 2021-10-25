app.controller('HomePageCtrl', ['$scope','$rootScope','$window','QueryService','isFeaturedService','CommonShareService','getRateInfo','numberFilter','$q','shareIdArrayService','$timeout','endorsementservice', function ($scope,$rootScope, $window, QueryService,isFeaturedService,CommonShareService,getRateInfo,numberFilter,$q,shareIdArrayService,$timeout,endorsementservice) {
	
	
	
$rootScope.showMenu = false;
$scope.isviewgradedpage = false;		
$rootScope.metakeywords = "CPx,Real estate,Buy property,Sell property,Investment property,Property Sydney,No agent,Advertise property,Graded properties,Real estate advertising,Property Melbourne,No agent fees,Real estate sales,Buy real estate,Independently reviewed and graded properties,Independent real estate sales,Central Property Exchange,Advertise property for free,List for free,No real estate fees,No property selling fees ,Save thousands on buying a property,Properties for financial planners,Properties for mortgage brokers,Alan Kholer,Qantas,Qantas Talking Business,Anthony Aoun,realestate.com.au,Vendor finance, Property discounts, Property savings, Property deals";
$rootScope.title= "Central Property Exchange | Independent Real Estate Sales| Home Page";
$rootScope.description="Central Property Exchange | Independent Real Estate Sales  |  Residential and Investment Properties  | A Fresh Approach to Buying Property";

	
    endorsementservice.success(function(data) {
        
        $scope.endorsement_list = data.endorsements;
        $scope.baseWebUrl = baseWebUrl;
        $scope.baseAmazonUrl = baseAmazonUrl;
        
        console.log($scope.baseWebUrl);
        console.log($scope.endorsement_list);
	});

	//PropertyService.success(function(data) { 
    QueryService.success(function(data) { 
		
		$scope.properties = data.properties;
		
        
	});
	

	$scope.feature ="feature";
    $scope.update ="update";
    
	$scope.go = function (url) {
	      $window.open(url);
	};
	
	
	function checkClickedview() {
		
	     $scope.$emit('viewEvent');
   	
	}
	
	$scope.sortdate = function(itemP) {
	    var date = new Date(itemP.date_created);
	    return date;
	};
	
	 $scope.myInterval = 4000;
	 
	 $scope.slides = [

	                  {
	                	  	text: 'Get free, instant access to independently reviewedand graded properties '
					  },
	                  {
						  	text: 'Know the outcome before you buy'
	                  },
	                  {
	                	  	text: 'Know the outcome before you sell'
	                  },
	                  {
	                	  	text: 'Know the outcome first '
	                  },
	                  {
	                	  	text: 'Know the opportunity before buy or sell'
	                  },
	                  {
		                    text: 'Independently reviewed and graded properties '
		              },
		              {
		                    text: 'Connecting property buyers with sellers  '
		              },
		              {
		                    text: 'Minimising risk for property buyers '
		              },
		              {
		                    text: 'No negotiating necessary '
		              },
		              {
		                    text: 'CPx is the ideal property platform for the financial services industry '
		              },
		              {
		                    text: 'Fee-for-Service '
		              },
		              {
		                    text: 'Buyers and Sellers save money'
		              },
		              {
		                    text: 'A fresh approach to buying property '
		              },
		              {
		                    text: 'CPx is all about independent real estate sales'
		              },
		              {
		                    text: 'CPx is a real estate advertising platform with a difference '
		              },
		              {
		                    text: 'CPx delivers services from the property buyer perspective '
		              },
		              {
		                    text: 'It is an Australian first'
		              },
		              {
		                    text: 'NO listing-agent selling-fees'
		              },
		              {
		                    text: 'Buyers can save $6,000 to $30,000 off the selling price '
		              },
		              
	                ];
	 
	 
	 $scope.myInterval2 = 3000;
	
	 $scope.homeslides = [
	                      {
	                    	  text : 'SELLERS Can List Properties For FREE'
 	                      },
 	                     {
	                    	  text : 'BUYERS Can Deal Direct And Save Thousands'
 	                      }
	                      ]
		
    /*code for view selected properties start here*/        
    $scope.countryflag = 'au';
    $scope.countrylabel = 'AUD';
    
     // Grab the promises from the two calls  
	    var namesPromise = getRateInfo();
	    //var ratesPromise = getRateInfo('latest');

	    $scope.to = {};
	    //     $scope.currency2 = {};
	    $scope.from = {};

	    // Use the $q.all method to run code only when both promises have been resolved
	    $q.all([namesPromise]).then(function(responses) {

	    	//var currencyNames = responses[0];
	    	var currencyRates = responses[0].quotes;

	    	// Generate the currencies array
	    	$scope.currencies = [];



	    	var currencyNames = CommonShareService.getcurrencyNames();

	    	
	    	var USDrate=currencyRates['USDUSD'];
     	       var AUDrate=currencyRates['USDAUD'];
     	       var multiplier=USDrate/AUDrate;
	    	
	   angular.forEach(currencyNames, function(name, code) {
		   		
		   var rate = currencyRates['USD'+code];
	    		$scope.currencies.push({
	    			code: code,
	    			label : code +" "+ name + " (" + numberFilter(rate*multiplier, 3) + " / AUD)",
	    			rate: rate*multiplier
	    		});


	    	});

	    	
	    	// set default currency as AUD
	    	$scope.from.currency = $scope.currencies[7];
	    	$scope.to.currency = $scope.currencies[7];
	    });
        
        
        
        
        $scope.setVal = function () {

              $scope.storeAffordableCriteria = function (vals) {
				   
            	  // sessionStorage.searchAffordableVal = angular.toJson(vals);
                  shareIdArrayService.setIdArray(vals);  	   
        	   };
        	   
               $scope.searchcriteria.tocurrency = $scope.to.currency;
               $scope.searchcriteria.from = $scope.from;
               $scope.searchcriteria.repay = $scope.searchcriteria.repay;
               
        	   $scope.storeAffordableCriteria($scope.searchcriteria);
                          

               //$scope.go('#!/view-graded-properties/affordable');
               $window.location.href = '#!/view-graded-properties/affordable';
    	};    
        
        $scope.searchcriteria = {};
        
        $scope.updateCurrency = function(from, to) {

		    	$scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);
		    	$scope.countrylabel = to.currency.code;
        }                
        
        
        
        $scope.countryflag = 'au';
		    $scope.countrylabel = 'AUD';
		    $scope.updateValueAll = function(from, to, items) {

		    	

		    	$scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);

		    	$scope.countrylabel = to.currency.code;
                
                                                                                                
		    	angular.forEach(items, function(item, key) {

//console.log(item);

		    		item.currencylabel = to.currency.code;
		    		//	console.log(item.currencylabel);

		    		if(to.currency.code == "AUD"){item.currencylabel = undefined;}  
		    		from.value = item.cpxprice;

		    		item.convertedcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);
		    		
		    		item.convertedlistedprice = item.listedprice / getRate(from.currency) * getRate(to.currency);
                    
                    item.convertedsavingprice = item.saving / getRate(from.currency) * getRate(to.currency);

		    	});
		    };
                        
        function getRate(currency) {
            return currency && currency.rate;
            }
                                
        $scope.convertedcpx_home = undefined;
        $scope.convertedlistedprice_home = undefined;
        $scope.convertedsavingprice_home = undefined;
        $scope.currencylabel_home = undefined;
        
        $scope.updateValue = function(from, to, item) {
            
            $scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);
            $scope.countrylabel = to.currency.code;
        
            
            item.currencylabel = to.currency.code;
            
            item.currencylabel_home = to.currency.code;
            //	console.log(item.currencylabel);
            
            if(to.currency.code == "AUD"){item.currencylabel_home = undefined;}  
            
            
            item.convertedcpx_home = item.cpxprice / getRate(from.currency) * getRate(to.currency);
            item.convertedlistedprice_home = item.listedprice / getRate(from.currency) * getRate(to.currency);
            item.convertedsavingprice_home = item.saving / getRate(from.currency) * getRate(to.currency);
        
        
        };
             
    //  $timeout((function() { $(".scrollable").scrollable()}), 5000);  
    
    $timeout((function() { 
    $('.logoSlider').slick({
        			    centerMode: false,
        			    slidesToShow: 8,
        			    arrows: true,
        			    dots: false,
        			    variableWidth: true,
        
        			}) 
                    }), 5000);  
    
     // $("ul.tabs").tabs("div.panes > div");       
      
      $scope.tabClick = function (tab) {
                           
              $(".tabli").removeClass("current");
              $("#"+tab).addClass("current");
              $("div.panes > div").hide();
              $("."+tab+"_prop").show()
             
             
    	};   
    
        $(function () {
            var ink, d, x, y;
            $(".ripplelink").click(function (e) {
                if ($(this).find(".ink").length === 0) {
                    $(this).prepend("<span class='ink'></span>");
                }

                ink = $(this).find(".ink");
                ink.removeClass("animate");

                if (!ink.height() && !ink.width()) {
                    d = Math.max($(this).outerWidth(), $(this).outerHeight());
                    ink.css({ height: d, width: d });
                }

                x = e.pageX - $(this).offset().left - ink.width() / 2;
                y = e.pageY - $(this).offset().top - ink.height() / 2;

                ink.css({ top: y + 'px', left: x + 'px' }).addClass("animate");
            });
        });
                
    /*code for view selected properties end here*/
    	 
}]);