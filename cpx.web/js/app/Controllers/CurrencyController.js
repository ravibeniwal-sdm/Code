
app.controller('currencyCtrl', ['$scope','CommonShareService','getRateInfo','numberFilter','$q', function ($scope,CommonShareService,getRateInfo,numberFilter,$q) {
	
	
	
////////////////currency filters


function getRate(currency) {
return currency && currency.rate;
}

//Grab the promises from the two calls  
var namesPromise = getRateInfo();
//var ratesPromise = getRateInfo('latest');

$scope.to = {};

$scope.from = {};

//Use the $q.all method to run code only when both promises have been resolved
$q.all([namesPromise]).then(function(responses) {

//var currencyNames = responses[0];
var currencyRates = responses[0].quotes;

//Generate the currencies array
$scope.currencies = [];


var currencyNames = CommonShareService.getcurrencyNames();

var USDrate=currencyRates['USDUSD'];
var AUDrate=currencyRates['USDAUD'];
var multiplier=USDrate/AUDrate;

console.log(USDrate);
angular.forEach(currencyNames, function(name, code) {

var rate = currencyRates['USD'+code];
$scope.currencies.push({
code: code,
label : code +" "+ name + " (" + numberFilter(rate*multiplier, 3) + " / AUD)",
rate: rate*multiplier
});

});


//set AUD as default currency
$scope.from.currency = $scope.currencies[7];
$scope.to.currency = $scope.currencies[7];
});



$scope.updateValue = function(from, to, value) {
	$scope.animatebtn = false;
$scope.convertedvalue = value / getRate(from.currency) * getRate(to.currency);

$scope.ratebase_from = (to.currency.rate / from.currency.rate).toFixed(2);

$scope.ratebase_to = (from.currency.rate / to.currency.rate).toFixed(2);

$scope.getDatetime = new Date();
};

$scope.animatebtn = false;
$scope.animate = function (value) {
   
	if(value == 'on'){	
		$scope.animatebtn = true;
	}
	
};
}]);