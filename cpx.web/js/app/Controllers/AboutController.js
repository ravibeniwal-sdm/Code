app.controller('AboutCtrl', ['$scope','$rootScope','$routeParams','$location', '$anchorScroll','$window','$modal','$log','$timeout','CommonShareService', function ($scope,$rootScope,$routeParams,$location, $anchorScroll,$window,$modal,$log,$timeout,CommonShareService) {
	
	
	$rootScope.shownothing = true;
	$scope.pid = $routeParams.pid;
	$scope.subid = $routeParams.subid;
    $scope.path = $location.path();
    //console.log($scope.path.indexOf("blog/"));
    if($scope.path.indexOf("blog/")>= 0)
    {
        
        $scope.selectedmenu=[{id:0,selected:false},{id:1,selected:false},{id:2,selected:false},{id:3,selected:false},{id:4,selected:false},{id:5,selected:true}];
    }else
    {
        
        $scope.selectedmenu=[{id:0,selected:false},{id:1,selected:false},{id:2,selected:false},{id:3,selected:false},{id:4,selected:true},{id:5,selected:false}];
    }

    

	
	$scope.keywordset = [{pid: 'what-is-cpx', keywords: 'What is CPx,CPx,Real estate,Real estate agents,Real estate sales,Real estate services,Real estate advertising,Cost savings,Property buying,Real estate websites,Purchase a property,Central Property Exchange,Independent representation,Property seller and buyer,No real estate agent selling fees,Independent property review,Listing properties ready for sale,Independent real estate sales,Fair and independent representation',
		description:"Central Property Exchange � Independent Real Estate Advertising  � Cost Savings for Property Sellers and Buyers � New Market for Real Estate Agents, Buyers, Advisors, Property Developers, Builders.",title:"Central Property Exchange | Real Estate Advertising | What is CPx"},

		{pid: 'independent-process', keywords: 'CPx,Real estate,Property seller,Real estate sales,Sellers and buyers,Central Property Exchange,Do it yourself,Industry professional,Real estate agents,Independent process,Alternative process,Independently represented,Properties across Australia,Independent property review,Significant cost savings,Independent real estate sales,The financial services industry,A fresh approach to buying property',
			description:"Central Property Exchange � Independent Process for Real Estate Sales � Buy and Sell Residential and Investment Properties � A Fresh Approach To Buying Property.",title:"Central Property Exchange | Buy & Sell Real Estate| Independent Process"},

			{pid: 'independent-property-review', keywords: 'CPx,IPR,Property review,Australian property,Central Property Exchange,Property specific,IPR report,Listed price,Property attributes,Independent commentary,Real estate properties,Construction completion date,Independent property review,Properties available for sale,Historical property and area data',
				description:"Central Property Exchange � Property Specific Reports - Buy and Sell Residential and Investment Properties � Independent Commentary on Properties Available for Sale.",title:"Central Property Exchange | Real Estate| Independent Property Review"},


				{pid: 'what-is-graded', keywords: 'CPx,Graded,Price risk,Real estate,New concept,National valuers,Save money,Property score,Property grade,Individualised service,Comparing properties,Property demographics,Historical growth rate,Propell National Valuers,The world of real estate,General property search,Property across Australia,Offers buyers several benefits',
					description:"Central Property Exchange � Scored And Graded Individual Property Reports - Buy And Sell Residential And Investment Properties � A Smart New Concept In The World Of Real Estate.",title:"Central Property Exchange | Real Estate Report| What is graded"},	 

					{pid: 'find-industry-professionals', keywords: 'CPx,Sellers,Buyers,Service,Agreements,Recommendations,Benefit,Fixed fee,CPx governance,Customer loyalty,Industry professionals,Central Property Exchange,Indicative service fees,Significant cost savings ,Property seller and buyer,Percentage of the sale price,Independent representation,Finding an industry professional',
						description:'Central Property Exchange � Find Industry Professionals � CPx Allows The Property Seller And Buyer To Appoint Their Personal Industry Professional.',title:'Central Property Exchange | Find Industry Professionals | Appoint your own Professional'},
					{pid: 'view-directory', keywords: 'directory,view,list'},
					
					{pid: 'public-speaking-profile', keywords: 'public,speaking profiles,list'},
					
					{pid: 'profileindex', keywords: '',
						description:'Central Property Exchange � Public speaking profiles.',title:'Central Property Exchange | Real Estate| Public speakingn profiles'},

					{pid: 'press-releases', keywords: 'CPx,Blog,New property,Property price,Buyer�s agent,Press Releases,Villa World,Domacom,No middle man ,Financial services,Property investing,Central property exchange,Buy and sell property,Buy property through CPx,Save thousands of dollars ,List your property with CPx,Fractional property investing,Residential builders and developers,The future of real estate buying and selling',
						description:'Central Property Exchange � Blog � Press Releases � Buy and sell property without a middle-man.',title:'Central Property Exchange | Real Estate| Press Releases'},


						{pid: 'Publications', keywords: 'CPx,Blog,SMSF,Real Estate,Publications,Buy property,Independent Process,Confidis,DomaCom,Villa World,Save thousands,Finance professionals,Advertising properties,Central property exchange,Cut out the middle-man,Self managed super fund,Buy property through CPx,Fractional property investing,List your properties with CPx,Buy and sell property for less,Finance professionals benefit',	                    
							description:"Central Property Exchange � Blog � Publications � Buy and sell property for less with CPx.",title:'Central Property Exchange | Real Estate| Publications'},


							{pid: 'cpx-announcements', keywords: 'CPx,Real Estate,Developers,Announcements,Private Vendors,Save thousands,Property for sale,Mortgage Brokers,Financial Planners,Real estate agents,Graded properties,Central property exchange,Property Developers,New Real Estate service,No real estate agent fees,Deal directly with the vendor,Independent online real estate,Advertise your property for sale',
								description:'Central Property Exchange � Blog � CPx announcements � List your property with CPx and save thousands.',title:'Central Property Exchange | Real Estate| Announcements'},

								{pid: 'blogindex', keywords: 'blog,subscribe,faq,cpx,announcement,press,release,publications',
									description:'Central Property Exchange � Blog � CPx announcements � FAQ - Press Releases - Publications.',title:'Central Property Exchange | Real Estate| Blog'},

								{pid: 'FAQs', keywords: 'CPx,FAQ,Confidis,DomaCom,Real Estate,Commission,Vendor direct,Property seller,Advertise on CPx,Property Developer,Currency conversions,Real estate advertising,Central property exchange,Sell my properties,Questions and Answers,Attract property buyers,Vendor direct advertising,Best price for my property,Major real estate advertising websites,Property is already listed with an agent',
									description:'Central Property Exchange � Blog � FAQ � Questions and answers on common queries when using CPx.',title:'Central Property Exchange | Real Estate| FAQ'},

									{pid: 'working-with-cpx', keywords: 'CPx,Fees,Buyers,Real Estate,Membership,Accountants,Full Disclosure,Free membership,Financial Planners,Mortgage Brokers,Industry Professionals,Central property exchange,No referral fees,Real Estate Agents,No transaction fees,Fixed fee-for-service,Receive free referrals,Property sellers and buyers',
										description:'Central Property Exchange � Industry Professionals � Working With CPx � This Page Is For Industry Professionals Wanting To Know More About Working With CPx.',title:'Central Property Exchange | Industry Professionals | Working with CPx'},

										{pid: 'free-publish-your-listings', keywords: 'Extend your advertising reach,New sales channels,FREE property listings,FREE property advertising,FREE real estate advertising,FREE listing service',
											description:'Central Property Exchange � Industry Professionals � Free publish your listings � This Page Is For Industry Professionals Wanting To Know More About Working With CPx.',title:'Central Property Exchange | Industry Professionals | Free publish your listings'},

											{pid: 'listing-affiliate', keywords: 'Comparison between CPx and Realestate.com.au,Comparison between CPx and Domain.com.au,Earn passive revenue,Extend your advertising reach,New sales channels',
												description:'Central Property Exchange � Industry Professionals � Listing affiliate � This Page Is For Industry Professionals Wanting To Know More About Working With CPx.',title:'Central Property Exchange | Industry Professionals | Listing affiliate'},


												{pid: 'list-property', keywords: 'CPx,List,Vendors,Advertise,Properties,Developers,Selling fees,Real estate,Selling property,Financial Services,Significant savings,Central property exchange,Real Estate agents,Apples with apples,List your property on CPx,Listing a property for sale,Independent Property Review,Dealing directly with the vendor,No real estate agent selling fees',
													description:'Central Property Exchange � Properties � List Your Property On Cpx � Let�s Start With A Pressing Question.  Why List Or Advertise With CPx?',title:'Central Property Exchange | Properties | List your Property on CPx'}
											
										];

	
	
	//FAQ's page
	$scope.status =[{url:'how-cpx-traffic-compare',value:false,id:'one',keywords: 'CPx,FAQ,Hits,Buyer,Properties,Advertising,Millions,Page views,Find a buyer,Website Traffic,Advertising fees,Central Property Exchange,Millions of hits,Properties for clients,Major real estate sites,Financial services industry,Real estate website traffic,Independent listing process,Short list suitable properties',
		description:'Central Property Exchange � FAQ � Website Traffic � How Does CPx Website Traffic Compare To Major Sites',title:'Central Property Exchange | FAQ| Website Traffic'},


		{url:'how-cpx-attract-property-buyers',value:false,id:'two',keywords: 'CPx,FAQ,Online,Buyers ,Properties,Marketing,Sales team,Attract buyers,Marketing plan,Business network,Financial services,Central Property Exchange,Significant savings,Marketing to buyers,Industry professionals,Properties ready for sale,Property seller and buyer,Independent property review',
			description:'Central Property Exchange � FAQ � CPx Marketing � How Does CPx Attract Property Buyers',title:'Central Property Exchange | FAQ| CPx Marketing'},


			{url:'advertise-with-cpx',value:false,id:'three',keywords: 'CPx,FAQ,Agency,Property,Advertising,Marketplace,Selling-fee,Open agency,Non-exclusive,Already Listed,Exclusive agency,Central Property Exchange,Procure a buyer,Multiple mediums,Real estate agents,Property is already listed,Project Marketing Company,Exclusive agency agreement',
				description:'Central Property Exchange � FAQ � Already Listed � My Property Is Already Listed With An Agent Or Project Marketing Company',title:'Central Property Exchange | FAQ| Already Listed'},


				{url:'real-estate-licence',value:false,id:'four',keywords: 'CPx,FAQ,Listing,License,Property,Advertise,Real estate,License to list ,Listing process,Governance section,Independent process,Central Property Exchange,Anyone can list,Advertise on CPx,List your property,Real estate license,For more information,Governance listing process',
					description:'Central Property Exchange � FAQ � No License to List � Must I Have A Real Estate License To List Advertise On CPx',title:'Central Property Exchange | FAQ| No License to List'},


					{url:'cpx-vs-direct-vendor',value:false,id:'five',keywords: 'CPx,FAQ,Agent,Vendor,Compare,Advertising,Real estate,Listed price,Vendor agent,Property advertising,Compare CPx,Central Property Exchange,List client properties,Independent process,Propell National Valuers,Real estate agent selling-fee,Independent property review,Vendor direct advertising sites',
						description:'Central Property Exchange � FAQ � Vendor Advertising � How does CPx compare to vendor direct advertising sites',title:'Central Property Exchange | FAQ| Vendor Advertising'},


						{url:'less-properties',value:false,id:'six',keywords: 'CPx,FAQ,Buyer,Listed,Australia,Properties,Secondary keywords,Real estate,New listings,Listed properties,Rental estimates,Properties Australia,Central Property Exchange,Long tail keywords,Real estate sites,Contract-of-sale,Properties for purchase,Propell National Valuers,Properties listed on CPx,Independent property review,No real estate agent selling fee',
							description:'Central Property Exchange � FAQ � Properties Listed � Why Are There Are Small Number Of Properties Listed On CPx?',title:'Central Property Exchange | FAQ| Properties Listed'},


							{url:'property-developer-network',value:false,id:'seven',keywords: 'CPx,Sell,FAQ ,Buyer,Property,Network,Commissions,Advertising,Sell properties,Selling strategy,Network to sell,Property Developer,Central Property Exchange,Listed for sale,Procure a buyer,Value for money,Property sale price,Sell your properties,Savings to the buyer,Network to sell my properties',
								description:'Central Property Exchange � FAQ � Property Network � I Am A Property Developer Who Uses A Network To Sell My Properties.  Will My Network Be Compromised If The Same Property Is Also Listed For Sale On CPx?',title:'Central Property Exchange | FAQ| Property Network'},


								{url:'commission-listing-fees',value:false,id:'eight',keywords: 'CPx,FAQ,Fees,Buyer,Service,Property,Commission,Open house,Admin support,Scope of service,Representing sellers,Industry professionals,Central Property Exchange,Scope of service,CPx Administration,Listing support fees,Indicative service fees,How much commission,Included in the listed price',
									description:'Central Property Exchange � FAQ � Retained Commission � How Much Of The Commission Can Be Retained To Offset CPx Administration/ Listing Support Fees?',title:'Central Property Exchange | FAQ| Retained Commission'},


									{url:'low-grade-advertise',value:false,id:'nine',keywords: 'CPx,FAQ ,Score,Property,Categories,Advertising,Overall score,Property pricing,Graded property,Assist the vendor ,Property categories,Central Property Exchange,Best for a buyer,Advertising on CPx,Low Graded Property,Comparative attributes,The score of a property,CPx recommends buyers',
										description:'Central Property Exchange � FAQ � Low Graded Property � Is A Property With A Low Graded Score Worthwhile Advertising On CPx?',title:'Central Property Exchange | FAQ| Low Graded Property'},


										{url:'best-price-for-property',value:false,id:'ten',keywords: 'CPx,FAQ ,Fees,Profit,Property,Advertising,Low rate,Best price,Sale profit,Property seller,Advertising fees,Central Property Exchange,Best market price,View current rates,Profit in your pocket,Best price for my property,Listing your property with CPx,Not paying agent commissions',
											description:'Central Property Exchange � FAQ � Best Price � I Am A Property Seller And I Want The Best Price For My Property.  Can I Achieve This Using CPx?',title:'Central Property Exchange | FAQ| Best Price'},


											{url:'domacom-fractional-property-investing',value:false,id:'eleven',keywords: 'CPx,FAQ,Share,DomaCom,Properties,Investment,Unit holders,Property rent,Property shares,Safe investment,Property to invest in,Central Property Exchange,Public book build,Manage the properties,Buying investment property,Diversified property portfolio,Managed Investment Scheme,Earn money from my investment,Fractional Property Investing Fund,Sell some or all of my property units,Property ownership and management costs',
												description:'Central Property Exchange � FAQ � DomaCom � DomaCom Fractional Property Investing.',title:'Central Property Exchange | FAQ| DomaCom'},


												{url:'self-managed-super-fund-smsf',value:false,id:'twelve',keywords: 'CPx,FAQ ,SMSF,Super,Trustees,Retirement,Trust fund,Super fund,Buying property,Investment property,Superannuation monies,Central Property Exchange,Trustees of the fund,Self Managed Super Fund,Bought through a managed SMSF,Property purchase through my SMSF,Investing in property through your SMSF,Limited Recourse Borrowing Arrangements,Growing wealth to provide retirement income',
													description:'Central Property Exchange � FAQ � SMSF � Self Managed Super Fund.',title:'Central Property Exchange | FAQ| SMSF'},


													{url:'currency-conversion',value:false,id:'thirteen',keywords: 'CPx,FAQ ,Rates,Currency,Exchange,Conversions,Investment,Breach,User rule,Exchange rates,Trusted sources,Currency Conversions,Central Property Exchange,Third party suppliers,Investment decisions,Open Exchange Rates,Breach of this user rule,Accuracy of information,Making investment decisions',
														description:'Central Property Exchange � FAQ � Currency Conversions � Currency Conversions Is A Guide To Open Exchange Rates.',title:'Central Property Exchange | FAQ| Currency Conversions'},


														{url:'confidis-pty-ltd',value:false,id:'fourteen',keywords: 'CPx,ANZ,AIG,FAQ,Audit,Confidis,Transactions,Underwritten,Security,Trust Fund,Trust Account,Confidis Pty Ltd,Independent trust,Central Property Exchange,Certificate of Funds,Money is held safely,Australia�s leading banks,Trust Account transaction,Underwritten by AIG Australia,Deposits and disbursements of commissions and monies',
															description:'Central Property Exchange � FAQ � Confidis � What does Confidis Pty Ltd do?',title:'Central Property Exchange | FAQ| Confidis Pty Ltd'},
															

															{url:'loan-search',value:false,id:'fifteen',keywords: 'CPx,LVR,Loan,View,Costs,Search,Glossary,Announcements,Loan view,Interest rate,Interest only,Cash amount,Purchase costs,Estimated total,Search property,Add loan scenario,Monthly repayments,Loan to value ratio,Principle & Interest,Financial loan scenario,Find affordable properties,Central property exchange,Loan view glossary of terms,Financial search facility for property buyers,',
																description:'Central Property Exchange � FAQ � Loan View Glossary Of Terms – Loan View Is A Search Facility For Property Buyers.',title:'Central Property Exchange | FAQ | Loan View Glossary of Terms'},
															
																{url:'why-grade-a-property',value:false,id:'sixteen',keywords: 'CPx',
																description:'Central Property Exchange � FAQ ',title:'Central Property Exchange | FAQ | Why Grade a Property'}
														];

	 
	 // Press Release
	 
	$scope.pressstatus =[{url:'residential-builders-and-developers',value:false,id:'two',keywords: 'CPx,Agent,Profits,Builders,Developers,Press Release,Dealing direct,New way to sell,Negotiate directly,Real estate agency,Independent professionals,Central property exchange,Reap the rewards,Builders and Developers,Vendor can list their property,List your properties with CPx,New property selling process,The future of real estate trading',
		description:'Central Property Exchange � Press Release � Residential Builders and Developers� List Properties with CPx and Reap the Rewards.',title:'Central Property Exchange | Press Release| Builders & Developers'},


		{url:'private-residential-property-sellers',value:false,id:'three',keywords: 'CPx,Sell,Vendor,Real Estate,Press Release,Representative,No set fee,Property expert,Sellers and buyers ,Agent and vendor,Changing properties,Central property exchange,New property website,Sales commission fees,Save thousands of dollars,Eliminates high selling fees,Future of real estate buying and selling,Cut out the middle-man and save thousands',
			description:'Central Property Exchange � Press Release � Private Residential Property Sellers � Cut out the middle-man and save thousands.',title:'Central Property Exchange | Press Release| Private Sellers'},


			{url:'cpx-launch',value:false,id:'four',keywords: 'CPx,Fees,Launch,Real Estate,Negotiated,Commissions,Press Release,Advertising,Referral fees,Property gallery,Service providers,Independent agents,Central property exchange,Real estate website,Buying property online,Cut out the middle man,Real estate industry first,Buy and sell properties for less,Commissions and advertising fees,Listing and selling a property through CPx',
				description:'Central Property Exchange � Press Release � CPx Launch � Buy and sell property through CPx.',title:'Central Property Exchange | Press Release| CPx Launch'},


				{url:'property-buyers',value:false,id:'one',keywords: 'CPx,Purchase,Saving,Sale price,Property price,Press Release,Selling fees,Buy property,Property for sale,Agent commissions,Independent representative,Central property exchange,No set agent fees,Real estate agents,Current market guide,Buy property through CPx,Independently list property,Online property listing website',
					description:'Central Property Exchange � Press Release � Property Buyers � Be In Charge When You Buy Property Through Cpx.',title:'Central Property Exchange | Press Release| Property Buyers'},

					{url:'financial-services',value:false,id:'five',keywords: 'CPx,Finance,Investors,Properties,Real Estate,Press Release,Accountants,Financial Services,Financial Planners,Mortgage Brokers,Independent vendors,Central property exchange,Site feedback,Property grade,New property website,Quality service providers,Saving thousands of dollars,Finance Professionals Benefit with CPx',
						description:'Central Property Exchange � Press Release � Financial Services � Finance Professionals Benefit with Cpx.',title:'Central Property Exchange | Press Release| Financial Services'},

						{url:'buyers-agents',value:false,id:'six',keywords: 'CPx,Agent,Buyer ,Real Estate,Press Release,Representative,Buyers Agent,Buying Property,Negotiate directly,Free membership,Source properties,Central property exchange,Add more value,No fee for referrals,Portfolio of properties,Expand agency business,Negotiate with the vendor,Listed as a service provider',
							description:'Central Property Exchange � Press Release � Buyers Agents � Agents Get To Add More Value With CPx.',title:'Central Property Exchange | Press Release| Buyers Agents'},


							{url:'fractional-property-investing',value:false,id:'seven',keywords: 'CPx,Property,Investing,Fractional,DomaCom,Press Release,Equity release,Property fund,Capital growth,SMSF Trustees,Choose property,Australian properties,Long term investors,Fractional property investing,Property Investment solution,Financial services professionals,Independently listed properties,Buy property without the middleman',
								description:'Central Property Exchange � Press Release � Fractional Property Investing � DomaCom Collaborates With CPx.',title:'Central Property Exchange | Press Release| Fractional Investing'},


								{url:'villa-world',value:false,id:'eight',keywords: 'CPx,Private,Brokers,Investors,Villa World,Press Release,New homes,Property sales,List properties,Negotiated price,Industry professionals,Central Property Exchange,Buyers and sellers,Buy and sell property,Significant cost savings,Saving thousands of dollars,Property development group,Advertise completed new homes',
									description:'Central Property Exchange � Press Release � Villa World � Villa World Lists New Homes With CPx.',title:'Central Property Exchange | Press Release| Villa World'},

								{url:'power-exchange',value:false,id:'nine',keywords: '',
									description:'',title:'Central Property Exchange | Press Release| Power Exchange'},
									
									{url:'amended-act',value:false,id:'ten',keywords: 'Minister for Innovation and Better Regulations,Grossly unfair and unethical practice,Better reflect community expectations,Victor Dominello,John Ajaka,Underquoting Prohibition,Property, Stock and Business Agents Amendment (Underquoting Prohibition) Act 2015',
										description:'',title:'Central Property Exchange | Press Release| Power Exchange'},
                                        
                                        
                                        {url:'self-sufficiency',value:false,id:'eleven',keywords: 'Methods to sell a property,Methods to buy a property,Fractional property ownership,Comparing best way to sell a property',
										description:'',title:'Central Property Exchange | Press Release| Self Sufficiency'},
                                        
                                        {url:'best-alternative',value:false,id:'twelve',keywords: 'realestate.com.au,domain.com.au,alternative to REA,alternative to realesate.com.au,alternative to domain.com.au,independent properties,vendor listed properties',
										description:'',title:'Central Property Exchange | Press Release| Best Alternative'},

								];

	 //cpx announcement 	
	 
	$scope.cpxanoustatus =[{url:'new-service-for-private-vendors-and-developers',value:false,id:'one',keywords: 'CPx,Real Estate,Developers,Announcements,Private Vendors,Save thousands,Property for sale,Mortgage Brokers,Financial Planners,Real estate agents,Graded properties,Central property exchange,Property Developers,New Real Estate service,No real estate agent fees,Deal directly with the vendor,Independent online real estate,Advertise your property for sale',
		description:'Central Property Exchange � Blog � CPx announcements � List your property with CPx and save thousands.',title:'Central Property Exchange | Real Estate| Announcements'},
		
		{url:'loan-view',value:false,id:'two',keywords: 'CPx,LVR,Loan,Budget,Deposit, Shortlist,Announcements,Loan view,Search tool,Interest only,Loan amount,Cash amount,Search for property,Borrowing capacity,Monthly repayments,Central property exchange,Loan to value ratio,Principle & Interest,Repayment life cycle,View graded properties,Real estate sales website,Experience the loan view difference,Be the power behind the interest rate,The smart new way to search property,',
			description:'Central Property Exchange � Cpx Announcements � Loan View � The smart new way to search property!',title:'Central Property Exchange | CPx Announcements| Loan View '},
			
			{url:'advertising-governance-updated',value:false,id:'three',keywords: 'CPx',
				description:'Central Property Exchange � Cpx Announcements � Advertising governance updated',title:'Central Property Exchange | CPx Announcements| Advertising governance updated '},
			
				{url:'refined-cpx-business-model',value:false,id:'four',keywords: 'Extend your advertising reach,New sales channels,FREE property listings,FREE property advertising,FREE real estate advertising,FREE listing service,Vendor free advertising,No sales commissions,No agents free,CPx,Properties for financial planners,Property sellers and buyers,Graded properties',
					description:'Central Property Exchange � Cpx Announcements � Refined CPx Business Model Offers FREE LISTING',title:'Central Property Exchange | CPx Announcements| Refined CPx Business Model Offers FREE LISTING '}
		 	                 ];
				
	 
	 
	$scope.viewgradedstatus =[{value:false},
	                          {value:false}
    ];
	
	
	
	
	
	
	
	if($scope.pid != undefined){
	//console.log($scope.pid);
	
	for(i=0;i<$scope.keywordset.length;i++){
		
		if($scope.keywordset[i].pid == $scope.pid){
		
			$rootScope.metakeywords = $scope.keywordset[i].keywords;
			$rootScope.description = $scope.keywordset[i].description;
			$rootScope.title = $scope.keywordset[i].title;
			
		//	console.log($scope.keywordset[i]);
		}
		
	}
	}
		
	
	if($scope.subid != undefined && $scope.subid != "subid"){
		
		// faq's
		 if($scope.pid == 'FAQs'){
			 
			 for(i=0;i<$scope.status.length;i++){
				 
				 if($routeParams.subid == $scope.status[i].url){
					 
					 $rootScope.metakeywords = $scope.status[i].keywords; 
					 $rootScope.description = $scope.status[i].description; 
					 $rootScope.title = $scope.status[i].title; 
				
					}
				 }}
		
		 
		//for press release
		 else if($scope.pid == 'press-releases'){
		 for(i=0;i<$scope.pressstatus.length;i++){
			 
			 if($routeParams.subid == $scope.pressstatus[i].url){
				 
				 $rootScope.metakeywords = $scope.pressstatus[i].keywords;
				 $rootScope.description = $scope.pressstatus[i].description; 
				 $rootScope.title = $scope.pressstatus[i].title; 
				}
			 }
             
             if($routeParams.subid == "frac"){
		

				 
                 
                 $location.hash($scope.pressstatus[6].id);
				 $scope.pressstatus[6].value = true;
			       
			        
			        $timeout(function() {
			        	 $anchorScroll();     
		           }, 4000);
				  
				}
             
             }
		 
		 
		//for cpx announcement
		 else if($scope.pid == 'cpx-announcements'){
		 for(i=0;i<$scope.cpxanoustatus.length;i++){
			 
			 if($routeParams.subid == $scope.cpxanoustatus[i].url){
				
				 $rootScope.metakeywords = $scope.cpxanoustatus[i].keywords; 
				 $rootScope.description = $scope.cpxanoustatus[i].description; 
				 $rootScope.title = $scope.cpxanoustatus[i].title; 
				 
				}
			 }}
		 
		 }
	
	
	
	//console.log($scope.subid);
	 $scope.isCPxCollapsed = true;

	
	 
//	 $scope.aboutmenu = {What_is_CPx:true, Independent_process:false,Independent_property_review:false,What_is_graded:false,find_industry_professionals:false,FAQs:false,list-property:false,advertise-property:false,mnucontactus:false,
//			 working_with_cpx:false,view_directory:false,Sign_up:false,Business_login:false,Contact_us_for_more:false,press_releases:false,Publications:false,cpx_announcements:false,blogindex:false,
//			 view_directory:false,submit-service-request:false};
	 
	 
	 $scope.aboutmenu =[
			 
			 {name:'what-is-cpx',value:true},
			 {name:'independent-process',value:false},
			 {name:'independent-property-review',value:false},
			 {name:'what-is-graded',value:false},
			 
			 {name:'find-industry-professionals',value:false},
			 
			 {name:'FAQs',value:false},
			 {name:'list-property',value:false},
			 
			 {name:'advertise-property',value:false},
			 {name:'mnucontactus',value:false},
			 
			 {name:'working-with-cpx',value:false},
			 {name:'view-directory',value:false},
			 {name:'submit-free-membership-form',value:false},
			 {name:'Business_login',value:false},
			
			 {name:'Contact_us_for_more',value:false},
			 
			 {name:'press-releases',value:false},
			 {name:'Publications',value:false},
			 {name:'cpx-announcements',value:false},
			 {name:'blogindex',value:false},
			 
			 {name:'submit-service-request',value:false},
			 
			 {name:'profileindex',value:false},
			 {name:'free-publish-your-listings',value:false},
			 {name:'listing-affiliate',value:false},
		];

	 

	// $scope.isCollapsed = true;
	 $scope.toggleStatus ={first:true,second:false,third:false,fourth:false,fifth:false,sixth:false,seventh:false};
	 
	
	 
	 $scope.selectMenuItem = function (itemkey){
		// alert( itemkey);
		 for (var key in $scope.aboutmenu) {
			
			 if($scope.aboutmenu[key].name==itemkey){
				 $scope.aboutmenu[key].value=true;

			 }else{
				 $scope.aboutmenu[key].value=false;
			 }
		 }
	
	 };
	 $scope.selectMenuItem($scope.pid );
	 
	
	 
//	 $scope.isMenuSelected = function (itemkey){
//		 
//		 var selected=false;
//		 for (var key in $scope.aboutmenu) {
//			 if(key==itemkey.mnu){
//				 selected=true;
//				 break;
//			 }
//		 }
//		 //alert( JSON.stringify($scope.aboutmenu) + ' return ' + selected);
//		 return selected;
//	 };
	 
	 
	 // function for anchor schroll
 
	 
	 $scope.gotoBottom = function() {
	       
		 
	     var flag = CommonShareService.getgotorate();
		 
		 
		 
		 if(flag == true){
			 
			 
			 $scope.viewgradedstatus[1].value = true; 
		//	 console.log($scope.viewgradedstatus[1].value);
			 $location.hash('grade');

			 $timeout(function() {
	        	 $anchorScroll();     
           }, 4000);
			 
			 
			 
		 }
		 
		 
		 
		 
		 //for faq's
		 
		 if($scope.pid == 'FAQs'){
		 for(i=0;i<$scope.status.length;i++){
			 
			 if($routeParams.subid == $scope.status[i].url){
				 
				 
				 
				 $location.hash($scope.status[i].id);
				 $scope.status[i].value = true;   
			        // call $anchorScroll()
			       
			        
			        $timeout(function() {
			        	 $anchorScroll();     
		           }, 4000);
			        
				}
			 }}
		 
		 
		//for press release
		 else if($scope.pid == 'press-releases'){
		 for(i=0;i<$scope.pressstatus.length;i++){
			 
			 if($routeParams.subid == $scope.pressstatus[i].url){
				 $location.hash($scope.pressstatus[i].id);
				 $scope.pressstatus[i].value = true;   
			        // call $anchorScroll()

				 $timeout(function() {
		        	 $anchorScroll();     
	           }, 4000);
				 
				}
			 }}
		 
		 
		//for cpx announcement
		 else if($scope.pid == 'cpx-announcements'){
		 for(i=0;i<$scope.cpxanoustatus.length;i++){
			 
			 if($routeParams.subid == $scope.cpxanoustatus[i].url){
				 $location.hash($scope.cpxanoustatus[i].id);
				 $scope.cpxanoustatus[i].value = true;   
			        // call $anchorScroll()
			       
				 $timeout(function() {
		        	 $anchorScroll();     
	           }, 4000);
				 
				}
			 }}
		 
		
	        
	      };
	      
	      
	    
	      $scope.gotorate = function (){
		    	 
	    	  CommonShareService.passgotorate();
		    }  
	      
	      
	      $scope.gotorate2 = function (){
		    	 
	    	  CommonShareService.passgotorate2();
		    }
	      
	      
	       
	      if($scope.pid == 'FAQs' || $scope.pid == 'press-releases' || $scope.pid == 'cpx-announcements' || $scope.pid == 'what-is-graded'){
	      $scope.gotoBottom();     
	      }	  
	      
	    //share via mail
	      
	      var firstmail = '';
	      $scope.openfaqmail = function (aid) {
	    	  	
	    	//for faq's
	 		 if($scope.pid == 'FAQs'){
	 		 for(i=0;i<$scope.status.length;i++){
	 			 if(aid == $scope.status[i].id){
	 				firstmail = $scope.pid+"/"+$scope.status[i].url;
	 				
	 			 	}
	 			 }
	 		 } else if($scope.pid == 'press-releases'){
	 			 for(i=0;i<$scope.pressstatus.length;i++){
		 			 if(aid == $scope.pressstatus[i].id){
		 				firstmail = $scope.pid+"/"+$scope.pressstatus[i].url;
		 			 	}
		 			 }
	 		 } else if($scope.pid == 'cpx-announcements'){
	 			 for(i=0;i<$scope.cpxanoustatus.length;i++){
		 			 if(aid == $scope.cpxanoustatus[i].id){
		 				firstmail = $scope.pid+"/"+$scope.cpxanoustatus[i].url;
		 			 	}
		 			 }
	 		 }
	 		console.log($scope.pid);
	 		if($scope.pid == 'anthonyaoun'){
	 			
	     	    var modalInstance2 = $modal.open({
		     	      templateUrl: 'mymailcontent2.html',
		     	      controller: 'PublicSpeakingmailCtrl',
		     	      size: '',
		     	      resolve: {
		     	        items: function () {
		     	          return firstmail;
		     	        }
		     	      }
		     	    });
	     	    
	     	    
	     	   modalInstance2.result.then(function (selectedItem) {
	     		      $scope.selected = selectedItem;
	     		    }, function () {
	     		      $log.info('Modal dismissed at: ' + new Date());
	     		    });
	     	   }
	    	  
	 		else{
	    	  
	     	    var modalInstance = $modal.open({
	     	      templateUrl: 'mymailcontent.html',
	     	      controller: 'FaqmailCtrl',
	     	      size: '',
	     	      resolve: {
	     	        items: function () {
	     	          return firstmail;
	     	        }
	     	      }
	     	    });
	     	    
	     	   

	     	    modalInstance.result.then(function (selectedItem) {
	     		      $scope.selected = selectedItem;
	     		    }, function () {
	     		      $log.info('Modal dismissed at: ' + new Date());
	     		    });
	 		}
	     	    
	     	  
	     		  };
	     		  
		     	   
		     		

	 //blog print function
	     		 
	     $scope.setprintpage = function (page){
	    	 
	    	 
	    	 CommonShareService.passblogprintid(page);
	    	 
	     }  
	     
	  //subscribe form
	     
	     $scope.registrationForm = {
	    		    'email'     : ''
	    		};
	     
	     $scope.resetform = function (){
	    	 
	    	 alert($scope.registrationForm.email);
	    	 
	    	 $timeout(function() {
	    		 $scope.registrationForm.email = '';      
           }, 3000);
	    
	    	 
	     }  
	     
	       $scope.clearPropertyID = function () {
                           
                //console.log("function  clicked ssss");
                sessionStorage.toggle_val = angular.toJson('');
                CommonShareService.passenquireid(null);
                 
            };
	    	$scope.goToServiceRequest = function () {
                           
               // console.log("function  clicked ssss");                
                $window.location.href='#!/service_request'; 
            };
	       		 
	     
}]);