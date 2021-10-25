
app.controller('producttileCtrl', ['$scope','$rootScope','CommonShareService','ShortlistService','QueryService','myService','ShareStatusShortlistService','getRateInfo','numberFilter','$q','$routeParams','isFeaturedService', function ($scope,$rootScope,CommonShareService,ShortlistService,QueryService,myService,ShareStatusShortlistService,getRateInfo,numberFilter,$q,$routeParams,isFeaturedService) {
	
	 
	 	//////////////////////////////////////////////////////
	    
	$scope.testfeatured = {};
	
	//add to shortlist functions
	  $rootScope.count = ShortlistService.getcount();
	  
	$scope.addtoshortlist = function (prop) {
	 
		  console.log(prop);
		  $rootScope.count = ShortlistService.addProduct(prop);
	   		console.log($rootScope.count);
	};	  
	//console.log($scope.countryflag);
    //console.log($rootScope.countryflag);
	//$scope.countryflag = 'au';
    //$scope.countrylabel = 'AUD';
	//alerts
    
    $scope.alerts = [];

    $scope.addAlert = function(id) {
    	
    	$scope.alertid = id;
      $scope.alerts.push({msg: 'Property shortlisted successfully!'});
      $scope.autoHide();
    };
    $scope.autoHide =function(){
                    $timeout(function() {
                          $scope.alerts.splice(0, 1);
                    }, 3000000);
    }

    $scope.closeAlert = function(index) {
      $scope.alerts.splice(index, 1);
    };
	
	
		$scope.getPropertyDetails = function(id) {
	    	
	    	//console.log("Function Called");
			$scope.propertyDetailed={};
			
			$scope.propertyDetailed.id = id;
			
			console.log($scope.propertyDetailed.id);
			
			QueryService.create($scope.propertyDetailed).$promise.then(function(data) {
				
				
				 $scope.properties= data.properties;
				 console.log( $scope.properties);
				 myService.setMyData($scope.properties);
			});
			
		}
	    
		
	    /////////////////////////////////////////////////
		
		$scope.checkIfFeatured = function(property){
			$scope.getonlyfeatured = {};
			
			if(property.featured == true){
				$scope.getonlyfeatured.from = "home";
				$scope.getonlyfeatured.val = true ;
				//console.log($scope.featured);
			
			}
			else{
				
				$scope.getonlyfeatured.from = "home";
				$scope.getonlyfeatured.val = false ;
			}
			
			console.log($scope.getonlyfeatured);
			isFeaturedService.setAsFeatured($scope.getonlyfeatured);
		}
		
		$scope.checkIfFeaturedViewAll = function(property){
			$scope.getonlyfeatured = {};
			$scope.getonlyfeatured.from = "listing";
				$scope.getonlyfeatured.val = false ;
				
				console.log($scope.getonlyfeatured);
			isFeaturedService.setAsFeatured($scope.getonlyfeatured);
		}
		
		//console.log($scope.getonlyfeatured);
		
		
		 $scope.setsShortlistStatus = function(status){
			 ShareStatusShortlistService.setStatusShortlist(status);
		    }
		
	
	//function getAuctionCount(auctionDate) {
	 $scope.getAuctionCount = function (auctionDate) {	
		 var df = 'MM/DD/YYYY'
			    var d1 = moment(auctionDate, "YYYY-MM-DD-hh:mm:ss");

			    var d2 =  moment();
			  
			    var days1 = Math.round(moment.duration(d1.diff(d2)).asDays());
			  
			    $scope.days = days1;
			   // console.log(days);
			    
			    if($scope.days > 0){
			    	$scope.auctionstatus = 'yes';
			    }
			    else if($scope.days < 0){
			    	$scope.auctionstatus = 'no';
			    }
			    else if($scope.days == 0){
			    	$scope.auctionstatus = 'today';
			    }
			    
			    return $scope.days;
		}	
	//$scope.getAuctionCount(auctionDate);
	 
     
	
////////////////currency filters


function getRate(currency) {
return currency && currency.rate;
}

// Grab the promises from the two calls  
var namesPromise = getRateInfo();
//var ratesPromise = getRateInfo('latest');

$scope.to = {};

$scope.from = {};

// Use the $q.all method to run code only when both promises have been resolved
$q.all([namesPromise]).then(function(responses) {

// var currencyNames = responses[0];
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
label : code +" "+ name + " (" + numberFilter(rate*multiplier , 3) + " / AUD)",
rate: rate*multiplier
});


});



// set AUD as default currency
$scope.from.currency = $scope.currencies[7];
$scope.to.currency = $scope.currencies[7];
});


$scope.item.convertedcpx_home = undefined;
$scope.item.convertedlistedprice_home = undefined;
$scope.item.convertedsavingprice_home = undefined;
$scope.item.currencylabel_home = undefined;

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

}]);