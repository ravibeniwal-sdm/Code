
app.controller('DefaultCtrl', ['$scope','$rootScope','$location','$routeParams', function ($scope,$rootScope,$location,$routeParams) {
	
	
	$scope.pid = $routeParams.pid;
	
	if($scope.pid=='yes'){
		$scope.response = true;
	}
	else if($scope.pid=='no'){
		$scope.response = false;
	}
	console.log($scope.fh);
	
	$scope.currenturl = $location.absUrl();
	
	if($scope.currenturl.indexOf("privacy") >= 0){
		
		$rootScope.title = "Central Property Exchange | Legals | Privacy";
		$rootScope.metakeywords = "CPx,Laws,Privacy,Security,Disclosure,Protection,Information,Third party,Privacy laws,Landlord Central,Privacy protection,Personal information,Correcting information,Central property exchange,Make an enquiry,Internet privacy policy,Apply for a job with us,Protecting your privacy,Your personal information,We will not sell or pass on your details,Information collected about visitors to our website";
		$rootScope.description="Central Property Exchange � Legals � Privacy � We Recognise The Importance Of Protecting The Privacy Of Information Collected About Visitors To Our Website.";
	}
	
	else if($scope.currenturl.indexOf("terms-and-conditions") >= 0){
		
		$rootScope.title = "Central Property Exchange | Legals | Terms & Conditions"
		$rootScope.metakeywords = "CPx,Terms,Access,Website,Material,Copyright,Disclaimer,Conditions,Third party ,Exclusive right,This agreement,Landlord Central,Property Compass,Intellectual property,Central property exchange,Use of material,Terms and conditions,For personal use only ,Termination of access,Links to other websites,Network of professionals,The legal and rightful owner of the intellectual property";
		$rootScope.description="Central Property Exchange � Legals � Terms & Conditions � Landlord Central Has Developed An Online Property Evaluation System For The Property Seller Or Buyer. The Business Process Is Also Licensed To Our Network Of Professionals.";
	}else
	{
		$rootScope.metakeywords = "CPx,Free,Order,Rental,Report,Property,Buy now,Contract,Valuation,Summary,Property Review,Central property exchange,Property Valuation,Depreciation Report,Independent Rental Estimate,Population and Capital Growth,Independent Property Review,Independent Contract Summary";
		$rootScope.description="Central Property Exchange � Reports � Order Independent Reports � Order Report, Buy Now, Free Estimate, Free Summary";
		$rootScope.title="Central Property Exchange | Reports | Order Independent Reports";
	}

}]);