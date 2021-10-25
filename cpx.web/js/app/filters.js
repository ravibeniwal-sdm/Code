//custom filter
app.filter('get-property-filter', function () {
    return function (prop,idd) {
    	
   	 var current_index =0;
   	 //console.log(idd+"idd");
   	//console.log(prop.length+"lenght");
    	 for (var i = 0; i < prop.length; i++) {
        
    	if(prop[i].id == idd)
    	{
    		current_index = i;
    	break;
    	}
    	}
    	
    	return current_index;
    	 //return prop[current_index];
    };
});

app.filter('get-next-filter', function () {
    return function (propid,idd) {
    	
   	 var current_index =0;
   	 console.log(idd+" <= idd");
   	//console.log(propid.length+"lenght");
    	 for (var i = 0; i < propid.length; i++) {
        
    	if(propid[i] == idd)
    	{
    		current_index = i;
    		
    	break;
    	}
    	}
    	
    	//console.log(current_index);
    	//return propid[current_index];
    	 return current_index;
    };
});


//search filter
/*app.filter('get-search-filter',['$filter'  , function ($filter) {
    return function (prop, obj) {
    	
    	var Items = []; 
    	
    	
    	
    	       
    	 for (var i = 0; i < prop.length; i++) {
     		validproperty=true;
     		
     	
     
     		
     			
     			
     			if (!(obj.minprice === undefined || obj.minprice === "Any" || obj.minprice === "") && validproperty==true){
     				
     				
         			if(parseFloat(prop[i].cpxprice, 10) >= obj.conv_minprice){
         				validproperty=true;
         			}else{
         				validproperty=false;
         			}
         		}
     			
     			
                 if (!(obj.maxprice === undefined || obj.maxprice === "Any" || obj.maxprice === "") && validproperty==true){
     				//console.log(prop[i].cpxprice);
         			if(parseFloat(prop[i].cpxprice, 10) <= obj.conv_maxprice){
         				validproperty=true;
         			}else{
         				validproperty=false;
         			}
         		}
     			
                 
                 
                 if (!(obj.minbeds === undefined || obj.minbeds === "Any" || obj.minbeds === null) && validproperty==true){
      				
          			if(prop[i].beds >= obj.minbeds){
          				validproperty=true;
          			}else{
          				validproperty=false;
          			}
          		}
     			
                 
                 
                 if (!(obj.maxbeds === undefined || obj.maxbeds === "Any" || obj.maxbeds === null) && validproperty==true){
       				
       				
           			if(prop[i].beds <= obj.maxbeds){
           				validproperty=true;
           			}else{
           				validproperty=false;
           			}
           		}
     			
     			
     			
     			
     			
     			
     			if (!(obj.type === undefined || obj.type === "Any" || obj.type === null) && validproperty==true){
     				
     				
         			if(prop[i].category == obj.type){
         				validproperty=true;
         			}else{
         				validproperty=false;
         			}
         		}
     		
     			
     			
     			if (!(obj.searchid === undefined) && validproperty==true){
     				
         			if(prop[i].id == obj.searchid){
         				validproperty=true;
         			}else{
         				validproperty=false;
         			}
         		}
     		
     		
     			
     			if (!(obj.searchtext === undefined) && validproperty==true){
         				
             			if(prop[i].name.toLowerCase().indexOf(obj.searchtext) >= 0 || prop[i].address[0].suburb.toLowerCase().indexOf(obj.searchtext) >= 0 || prop[i].address[0].state.toLowerCase().indexOf(obj.searchtext) >= 0){
             				validproperty=true;
             			}else{
             				validproperty=false;
             			}
     				
     				var tokens = obj.searchtext.toLowerCase().split(/[ ,]+/);
     				
     			//	console.log(tokens);
     				
     				var count1 = 0;
     			
     				
     				for(j=0; j< tokens.length ; j++){
     					
     					if(prop[i].name.toLowerCase().indexOf(tokens[j]) >= 0){
     						
     						count1++;
     						}
     						
                        
						if(prop[i].address[0].suburb.toLowerCase().indexOf(tokens[j]) >= 0){
							count1++;
							}
						
						if(prop[i].address[0].state.toLowerCase().indexOf(tokens[j]) >= 0){
							count1++;
							}


						
     				}
     				
     			
     				
       				prop[i].rel = count1;
     				
       		//		console.log(prop[i]);
     				
     				
     				if(count1 > 0){
     			
						validproperty=true;
     					}else{validproperty=false;}
     			
     			
     			}
     				
     				
     		
    	
     			
                 if (!(obj.left === undefined || obj.left === false ) && validproperty==true){
     				
         			if(prop[i].smsf == obj.left){
         				validproperty=true;
         			}else{
         				validproperty=false;
         			}
         		}
                 
                 
                 if (!(obj.domacom === undefined || obj.domacom === false ) && validproperty==true){
      				
          			if(prop[i].domacom == obj.domacom){
          				validproperty=true;
          			}else{
          				validproperty=false;
          			}
          		}

                 
                 if (!(obj.sold === undefined || obj.sold === false ) && validproperty==true){
      				
          			if(prop[i].sold == obj.sold){
          				validproperty=true;
          			}else{
          				validproperty=false;
          			}
          		}

                 
              
                 
                 if (!(obj.grade === undefined || obj.grade === '' || obj.grade === null || obj.grade === 'Filter by grade: Any' ) && validproperty==true){
      				
                	 
          			if(prop[i].grade == obj.grade){
          				validproperty=true;
          			}else{
          				validproperty=false;
          			}
          		}
                 
                 
                 if (!(obj.repay === undefined || obj.repay === '' || obj.repay === null || obj.repay < 0 || isNaN(obj.repay) === true ) && validproperty==true){
       				
                	var maxrepay = obj.repay * 1.2; 
                	var minrepay = obj.repay * 0.8;
                	
                	
                	if((prop[i].conv_IOrepayments > minrepay && prop[i].conv_IOrepayments < maxrepay) || (prop[i].conv_PIrepayments > minrepay && prop[i].conv_PIrepayments < maxrepay)){
                		
                		validproperty=true;	
                	}
                	
                  	else{validproperty=false;}
           		}
     			
    	
    	
         	  
       if(validproperty){

    	   Items.push(prop[i]);   
       }
       }
    	return Items;
    };
}]);
*/



