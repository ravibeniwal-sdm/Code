
app.controller('advancesearchCtrl', ['$scope','$rootScope','CommonShareService','ShortlistService','QueryService','myService','ShareStatusShortlistService','getRateInfo','numberFilter','$q','$routeParams','isFeaturedService', function ($scope,$rootScope,CommonShareService,ShortlistService,QueryService,myService,ShareStatusShortlistService,getRateInfo,numberFilter,$q,$routeParams,isFeaturedService) {
	
	 

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


$scope.countryflag = 'au';
$scope.countrylabel = 'AUD';
$scope.affordabilitysearchcountryflag = 'au';
$scope.updateValue = function(from, to, item) {

	$scope.affordabilitysearchcountryflag= to.currency.code.toLowerCase().substr(0, 2);

	
};

}]);