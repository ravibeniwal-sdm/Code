function validateOnlyNumberCharDashStrict(){
	 $('.onlyNumberCharDashStrict').keyup(function() {
		  if(!(/^[a-zA-Z0-9-]+$/.test(this.value))){
	        this.value = this.value.replace(/[^0-9\^A-Z\^a-z\-]/g, '');
		  }
	    });
}
function validateOnlyNumberStrict(){
	$('.onlyNumberStrict').keyup(function() {
		if(!(/^[0-9]+$/.test(this.value))){
        this.value = this.value.replace(/[^0-9]/g, '');
        this.value = this.value.replace(/\-?\d+\.\d{9}$/g, '');
		}
    });
}
function validnumeric(){
	$(".validnumeric").keydown(function (event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {
        } else {
            event.preventDefault();
        }
        if($(this).val().indexOf('.') !== -1 && (event.keyCode == 190 || event.keyCode == 110))
            event.preventDefault();
    });
}

function deleteRowTable(){
	$('.deleteRow').click(function(){
		var classtr =  $(this).closest("tr").next('.userid_error');
		classtr.remove();
		var whichtr = $(this).closest("tr");
	    //alert('worked'); // Alert does not work
	    whichtr.remove();    
	});
}
$(document).ready(function() {
	validateOnlyNumberCharDashStrict();
	validateOnlyNumberStrict();
	validnumeric();
	$(".validnumeric").each(function(){
		  $(this).val(parseFloat($(this).val()).toFixed(2));
		});
 
    $("#addrecipientForm").validate();
    $("#form-admin").validate();
    $("#annexure-admin").validate();
    /*$("#admin_add_subscriber").submit(function() {
     alert('here');
     var startValue = $("#start_date").children().children().val();
     alert(startValue);
     var renewalValue = $("#renewal_date").children().children().val();
     alert(renewalValue);
     if(startValue != ''){
     if(startValue > renewalValue){
     alert('error');
     return false;
     }
     }
     });*/
    /*$("#renewal_date").blur(function(){
     var startValue= $("#start_date").val();
     var renewalValue = $("#renewal_date").val();      
     if(startValue !=''){
     if(startValue >renewalValue){
     alert('error');
     }
     }
     
     });*/

    $('#renewal_date_sub').on('change.bfhdatepicker', function(e) {
        var red = $("input[name='data[User][renewal_date]']").val();
        var subval = $("input[name='data[User][subscription_date]']").val();
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);

        if (subval > red) {
            alert("Subscription start date should not be greater than Renewal date");
            $("input[name='data[User][renewal_date]']").val('');
            $("input[name='data[User][subscription_date]']").val('');
        }
    });
    $('#summary_dash_from').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[Summary][to]']");
        var b=$("input[name='data[Summary][from]']");
        var red = a.val();
        var subval = b.val();

        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);
        if(red != ''){
        if (subval > red) {
            alert("Summary 'From' date should not be greater than Summary 'To' date");
            $(b).val('');
        }
        }
    });
 $('#summary_dash').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[Summary][to]']");
        var b=$("input[name='data[Summary][from]']");
        var red = a.val();
        var subval = b.val();

        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);

        if (subval > red) {
            alert("Summary 'From' date should not be greater than Summary 'To' date");
            $(b).val('');
        }
    });
 $('#subscriberdashfrom').on('change.bfhdatepicker', function(e) {
     var a=$("input[name='data[User][to]']");
     var b=$("input[name='data[User][from]']");
     var red = a.val();
     var subval = b.val();
     
     sddd = subval.substr(0, 2);
     sMMM = subval.substr(3, 2);
     sYYY = subval.substr(6, 4);
     rddd = red.substr(0, 2);
     rMMM = red.substr(3, 2);
     rYYY = red.substr(6, 4);
     subd = sYYY + "-" + sMMM + "-" + sddd;
     rubd = rYYY + "-" + rMMM + "-" + rddd;

     subval = Date.parse(subd);
     red = Date.parse(rubd);
     if(red != ''){
     if (subval > red) {
         alert("Subscribers 'From' date should not be greater than Subscribers 'To' date");
         $(b).val('');
     }
     }
 });
    $('#subscriberdashto').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[User][to]']");
        var b=$("input[name='data[User][from]']");
        var red = a.val();
        var subval = b.val();
        
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);

        if (subval > red) {
            alert("Subscribers 'From' date should not be greater than Subscribers 'To' date");
            $(b).val('');
        }
    });
    $('#funddashidfrom').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[FundPercent][to]']");
        var b=$("input[name='data[FundPercent][from]']");
        var red = a.val();
        var subval = b.val();
        
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);
        if(red != ''){
        if (subval > red) {
            alert("Fund percentage 'From' date should not be greater than Fund percentage 'To' date");
            $(b).val('');
        }
        }
    });
    $('#funddashid').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[FundPercent][to]']");
        var b=$("input[name='data[FundPercent][from]']");
        var red = a.val();
        var subval = b.val();
        
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);

        if (subval > red) {
            alert("Fund percentage 'From' date should not be greater than Fund percentage 'To' date");
            $(b).val('');
        }
    });
    $('#fundsiddashfrom').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[fundsDash][to]']");
        var b=$("input[name='data[fundsDash][from]']");
        var red = a.val();
        var subval = b.val();
        
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);
        if(red != ''){
        if (subval > red) {
            alert("Funds 'From' date should not be greater than Funds 'To' date");
            $(b).val('');
        }
        }
    });
    $('#fundsiddash').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[fundsDash][to]']");
        var b=$("input[name='data[fundsDash][from]']");
        var red = a.val();
        var subval = b.val();
        
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);

        if (subval > red) {
            alert("Funds 'From' date should not be greater than Funds 'To' date");
            $(b).val('');
        }
    });
    $('#transdashidfrom').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[Transaction][to]']");
        var b=$("input[name='data[Transaction][from]']");
        var red = a.val();
        var subval = b.val();
        
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);
        if(red != ''){
        if (subval > red) {
            alert("Transaction 'From' date should not be greater than Transaction 'To' date");
            $(b).val('');
        }
        }
    });
    $('#transdashid').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[Transaction][to]']");
        var b=$("input[name='data[Transaction][from]']");
        var red = a.val();
        var subval = b.val();
        
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);

        if (subval > red) {
            alert("Transaction 'From' date should not be greater than Transaction 'To' date");
            $(b).val('');
        }
    });
    
    $('#trans_from').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[Transaction][created_to]']");
        var b=$("input[name='data[Transaction][created_from]']");
        var red = a.val();
        var subval = b.val();
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;
        subval = Date.parse(subd);
        red = Date.parse(rubd);
        if(red != ''){
        if (subval > red) {
            alert("Transaction 'From' date should not be greater than Transaction 'To' date");
            $(b).val('');
            $(a).val('');
        }
        }
    });
    
    $('#trans_to').on('change.bfhdatepicker', function(e) {
        var a=$("input[name='data[Transaction][created_to]']");
        var b=$("input[name='data[Transaction][created_from]']");
        var red = a.val();
        var subval = b.val();
        sddd = subval.substr(0, 2);
        sMMM = subval.substr(3, 2);
        sYYY = subval.substr(6, 4);
        rddd = red.substr(0, 2);
        rMMM = red.substr(3, 2);
        rYYY = red.substr(6, 4);
        subd = sYYY + "-" + sMMM + "-" + sddd;
        rubd = rYYY + "-" + rMMM + "-" + rddd;

        subval = Date.parse(subd);
        red = Date.parse(rubd);

        if (subval > red) {
            alert("Transaction 'From' date should not be greater than Transaction 'To' date");
            $(b).val('');
            $(a).val('');
        }
    });
   

    $('#disburse-form').bind('submit', function() {
        $('#label_country').prop("disabled", false);
    });
    $(".readonlyClass").attr("readonly", true);
    
   
    var defaultVal = '';
    $('#TransactionDisbursedToSubscriber').change(function() {
        $("#TransactionDisbursedToClient").val(defaultVal);
        $("#TransactionDisbursedToClient").removeClass("error");
        $('label[for=TransactionDisbursedToClient]').css('display', 'none');
        $("#TransactionDisbursedTo").val("Subscriber");
    });
    $('#TransactionDisbursedToClient').change(function() {
        $("#TransactionDisbursedToSubscriber").val(defaultVal);
        $("#TransactionDisbursedToSubscriber").removeClass("error");
        $('label[for=TransactionDisbursedToSubscriber]').css('display', 'none');
        $("#TransactionDisbursedTo").val("Client");
    });
    $("#add-manual").click(function() {
        $("#TransactionDisbursedToSubscriber").val('');
        $("#TransactionDisbursedToClient").val('');
        $('.removeM').find("input[type=text] , textarea ,select").each(function() {
            $(this).val('');
        });
        $('#TransactionDisbursedToClient').rules('remove', 'checkselectBox');
        $('#TransactionDisbursedToSubscriber').rules('remove', 'checkselectBox');
    });
    $('.onlyNumber').keyup(function() {
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.value = this.value.replace(/\-?\d+\.\d{9}$/g, '');
        
    });
    $('.onlyNumberChar').keyup(function() {
        this.value = this.value.replace(/[^0-9\^A-Z\^a-z\ \.]/g, '');
    });
    $('.onlyCharDash').keyup(function() {
        this.value = this.value.replace(/[^0-9\^A-Z\^a-z\-#)(,'\ \.]/g, '');
    });
    $("input.disablespacebar").on({
        keydown: function(e) {
            if (e.which === 32)
                return false;
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
        }
    });
    $("#add-manual").click(function() {
        $(".readonlyClass").attr("readonly", false);
        $('#label_country').prop("disabled", false);
    })
    $('.changeContact').change(function() {
        $(".readonlyClass").attr("readonly", true);
        $('#label_country').prop("disabled", true);
        /* var IdGenerated = $(this).attr('id');
         if(IdGenerated=='TransactionDisbursedToSubscriber'){
         $(".readonlyClass").attr("readonly", true);
         }else{
         $("#label_email").attr("readonly", false);
         }*/

        var clientSubscriber = $(this).attr('name');
        var ID = $(this).val();
        $.ajax({
            type: "POST",
            url: Site_url + "admin/Transactions/dynamicContact",
            data: {clientSubscriber: clientSubscriber, ID: ID},
            success: function(j) {
                var json = $.parseJSON(j);
                entityName = json.entity_name;
                role = json.role;
                fName = json.fname;
                lName = json.lname;
                email = json.email;
                phone = json.phone;
                fax = json.fax;
                mobile = json.mobile;
                street = json.street;
                city = json.city;
                state = json.state;
                postcode = json.postcode;
                country = json.country;
                id = json.id;
                id = json.subcomid;
                $("#label_entity_name").val(entityName);
                if (role != '')
                {
                    $("#label_role").removeAttr('disabled');
                    $("#label_role").val(role);
                } else {
                    $("#label_role").val('');
                    $("#label_role").attr('disabled', 'diabled');
                }
                $("#label_fname").val(fName);
                $("#label_lname").val(lName);
                $("#label_email").val(email);
                $("#label_phone").val(phone);
                $("#label_fax").val(fax);
                $("#label_mobile").val(mobile);
                $("#label_street").val(street);
                $("#label_city").val(city);
                $("#label_state").val(state);
                $("#label_post_code").val(postcode);
                $("#label_country").val(country);
                $("#TransactionDisburseduserid").val(id);
                $("#subcomid").val(id);
//alert(country);
                //$("label#label_entity_name").val('2222222222222');
                //alert(json.Client.entity_name);
                //    $(json).each(function(i,val){
                //	$.each(val,function(k,v){
                //	    alert(val);return false  
                //	});
                //    });
                //   alert( "Data Saved: " + msg );
                return false;
                // some suff there
            }
        });
    });
    /*Start::Manage the payment option while adding a receipt in transactions*/
    //addReceiptDepositType addReceiptPaymentMethod
    $("#addReceiptDepositType").change(function() {
// case: if type is not holding then remove cc option
        if ($(this).val() != 'holding' && $(this).val() != '') {
            if ($("#addReceiptPaymentMethod").val() == 'CreditCard') {
                $("#addReceiptPaymentMethod").find('option').remove().end().append("<option value=''>Please select payment method</option><option value='Poli'>Poli</option><option value='ManualEFT'>Manual EFT</option>");
            } else {
                $("#addReceiptPaymentMethod option[value='CreditCard']").remove();
            }
        } else if ($(this).val() == 'holding' || $(this).val() == '') {
            if ($("#addReceiptPaymentMethod").val() == '') {
                $("#addReceiptPaymentMethod").find('option').remove().end().append("<option value=''>Please select payment method</option><option value='CreditCard'>Credit card</option><option value='Poli'>Poli</option><option value='ManualEFT'>Manual EFT</option>");
            } else {
                var selectedVal = $("#addReceiptPaymentMethod").val();
                $("#addReceiptPaymentMethod").find('option').remove().end().append("<option value=''>Please select payment method</option><option value='CreditCard'>Credit card</option><option value='Poli'>Poli</option><option value='ManualEFT'>Manual EFT</option>").val(selectedVal);
            }

        }
    });
    $("#addReceiptPaymentMethod").change(function() {
        if ($(this).val() != 'holding' && $(this).val() != '') {

        }
    });
    /*END---Manage the payment option while adding a receipt in transactions*/
    $('#introduction').validate();
    $('#add-receipt-form').validate({
        "data[Client][email]": {
            'email': true
        }
    });
    $('#instructions').validate();
    $('#reconcile-form').validate();

    $.validator.addMethod("amountZero", function(value, element) {
        return value != 0;
    }, 'Please add some amount');
    $.validator.addMethod("checkselectBox", function(value, element) {
        var chkvalclient = $('#PaymentDisbursedToClient').val();
        var chkvalsub = $('#PaymentDisbursedToSubscriber').val();
        //alert(chkvalclient);
        //alert(chkvalsub);
        if (chkvalclient == '' && chkvalsub == '')
        {

            return false;
        } else {
            return true;
        }
    }, 'This field is required');
    $('#disburse-form').validate({
        rules: {
            "data[Transaction][amount]": {
                required: false,
                amountZero: true,
                number: true
            },
            "data[Transaction][disbursed_to_client]": {
                checkselectBox: true
            },
            "data[Transaction][disbursed_to_subscriber]": {
                checkselectBox: true
            }
        }



    });
    $('#admin_add_subscriber .fileuploader').validate({ 
        rules: {
            "data[User][website]": {
                required: false,
                url: true
            },
            "data[User][aus_business_no]": {
                required: false,
                number: true,
                maxlength: 11
            },
            "data[User][first_name]": {
                required: true
            },
            "data[User][last_name]": {
                required: true
            },
            "data[User][term]": {
                required: false,
                number: true
            },
            "data[User][email]": {
                required: true,
                email: true
            },
            "data[User][deposit_transaction_fee]": {
                required: false,
                number: true
            },
            "data[User][commission_transaction_fee]": {
                required: false,
                number: true
            },
            "data[User][subscription_fee]": {
                required: false,
                number: true
            }
        }
    });
    // manage banks country specific bank categories
    $('#choosebank').change(function() {
        var countryId = $(this).val();
        $("#choose_category").html("<option>Loading...</option>");
        $.ajax({
            url: Site_url + 'eft_banks/getBankCategories',
            type: 'post',
            data: {countryId: countryId},
            success: function(data) {
                $("#choose_category").html(data);
            }
        });
    });
    // show the agents in add/edit subscriber    
    $('#subscriber_type_change').change(function() {
        $("#agentsDD").attr('disabled', false);
        var subType = parseInt($(this).val());
        if (subType == 6) {
            $("#agentsDD").html("");
            $("#agentsDD").attr('disabled', true);

            return false;
        }
        var ID = parseInt($("#subscriberId").val());
        $("#agentsDD").html("<option>Loading...</option>");
        $.ajax({
            url: Site_url + 'Subscribers/getAgentsDD',
            type: 'post',
            data: {subType: subType, ID: ID},
            success: function(data) {
                $("#agentsDD").html(data);
            }
        });

        




    });
    
    
      $('#subscriber_type_change').change(function() {
    
    /********************set Schedule value*******************************/

        var update = $("#getUpdateStatus").attr("updated");
        var sel_val = $(this).val();
        if (sel_val != '') {
            var data = {f0: "P", f1: "SP", f2: "PSP",
                f3: "CA", f4: "SA", f5: "NA", f6: "RA"};
            $('.dynamic_subscriber_type').html(data['f' + sel_val]);
        } else {
            $('.dynamic_subscriber_type').html('xxxxx type');
        }
        
      
        $.ajax({
            url: Site_url+"admin/Subscribers/fetch_subscriber_type_data",
            data: {sel_val: sel_val},
            type: "POST",
            beforeSend: function() {
                $('#wait-payment-process').show();
            },
            complete: function() {
                $('#wait-payment-process').hide();
            },
            success: function(data) {
            	
                var obj = jQuery.parseJSON(data);
                if (obj.new != 'new') {
                  
                    var buildarray = new Array(
                        "term",
                        "subscription_fee",
                        
                        "number_of_free_transaction",
                        "receipted_and_disbursed_transaction",
                        "holding_receipted_transaction_eft",
                        "deposit_receipted_transaction_eft",
                        "commission_receipted_transaction_eft",
                        "credit_card_receipted_transaction_cc",
                        "holding_receipted_transaction_cc",
                        "disbursements_fees",
                        "interest_on_funds",
                        "interest_on_funds",
                        "fee_per_deal",
                        "special_conditions"
                        );
                    chkval=$("input[name='subscription_type']").val();
                   
                    if(update>0 && sel_val==chkval){
                   
                    for (i = 0; i < (buildarray.length); i++) {
                        var setdata = buildarray[i];
                        $('input[name="data[User][' + setdata + ']"]').val($("input[name='"+setdata+"']").val());
                    }
                    $('input[name="data[User][group_transaction_fees]"]').val($("input[name='group_transaction_fees']").val());
                    $('input[name="data[User][direct_transaction_fees]"]').val($("input[name='direct_transaction_fees']").val());
                    $("input[name='data[User][gst_applicable]']").prop('checked', false);
                    $("input[name='data[User][subscription_fee_mode]']").prop('checked', false);
                    
                    
                    $("#UserGstApplicable" + $("input[name='gst_applicable']").val()).prop('checked', true);
                    $("#UserSubscriptionFeeMode" + $("input[name='subscription_fee_mode']").val()).prop('checked', true);
                    
                    $('textarea[name="data[User][special_conditions]"]').val($("input[name='special_conditions']").val());
                    if ($("input[name='subscriber_agreement']").val()) {
						//var cnfm = confirm('Do you want to delete this attachment ?');
                        var downloadLink = "<a target='_blank' id='subscriberDownload' title='Click to view/download' class='' href='" +Site_url+ "/img/agreements/" +$("input[name='subscriber_agreement']").val()+"'> <span class='glyphicon glyphicon-download-alt table-icon'></span>Download/view the agreement</a><a href='"+Site_url+"admin/subscribers/delete_subscriber_agreement/"+$("input[name='id']").val()+"' class='table-icon' title='Delete' id='subscriberdelete'><span class='glyphicon glyphicon-trash'></span></a>"
                        $('.user-selected-agreement').html(downloadLink);
                    } else {
                        $('.user-selected-agreement').html("");
                    }
                    }else{
                    
                    for (i = 0; i < (buildarray.length); i++) {
                        var setdata = buildarray[i];
                        $('input[name="data[User][' + setdata + ']"]').val(obj.SubscriptionSchedules[setdata]);
                    }
                    $('input[name="data[User][group_transaction_fees]"]').val(obj.SubscriptionSchedules.group_transaction_fees);
                    $('input[name="data[User][direct_transaction_fees]"]').val(obj.SubscriptionSchedules.direct_transaction_fees);
                    $("input[name='data[User][gst_applicable]']").prop('checked', false);
                    $("input[name='data[User][subscription_fee_mode]']").prop('checked', false);
                    
                    $("#UserGstApplicable" + obj.SubscriptionSchedules.gst_applicable).prop('checked', true);
                    $("#UserSubscriptionFeeMode" + obj.SubscriptionSchedules.subscription_fee_mode).prop('checked', true);
                    
                    $('textarea[name="data[User][special_conditions]"]').val(obj.SubscriptionSchedules.special_conditions);
                    if (obj.SubscriptionSchedules.subscriber_agreement) {
						//var cnfm = confirm('Do you want to delete this attachment ?');
                        var downloadLink = "<a target='_blank' id='subscriberDownload' title='Click to view/download' class='' href='" +Site_url+ "/img/agreements/" +obj.SubscriptionSchedules.subscriber_agreement+"'> <span class='glyphicon glyphicon-download-alt table-icon'></span>Download/view the agreement</a><a href='#' class='table-icon' title='Delete' id='subscridelete'><span class='glyphicon glyphicon-trash'></span></a>"
                        $('.user-selected-agreement').html(downloadLink);
                    } else {
                        $('.user-selected-agreement').html("");
                    }
                    
                }
                    
                } else {
                    var buildarray = new Array(
                        "term",
                        "subscription_fee",
                        "number_of_free_transaction",
                        "receipted_and_disbursed_transaction",
                        "holding_receipted_transaction_eft",
                        "deposit_receipted_transaction_eft",
                        "commission_receipted_transaction_eft",
                        "credit_card_receipted_transaction_cc",
                        "holding_receipted_transaction_cc",
                        "disbursements_fees",
                        "interest_on_funds",
                        "interest_on_funds",
                        "fee_per_deal",
                        "special_conditions"
                        );
                    for (i = 0; i < (buildarray.length); i++) {
                        var setdata = buildarray[i];
                        $('input[name="data[User][' + setdata + ']"]').val('');
                    }
                    $('input[name="data[User][group_transaction_fees]"]').val("");
                    $('input[name="data[User][direct_transaction_fees]"]').val("");
                    $("input[name='data[User][gst_applicable]']").prop('checked', false);
                    $("input[name='data[User][subscription_fee_mode]']").prop('checked', false);
                    $('textarea[name="data[User][special_conditions]"]').val('');
                     $(".grouplinks").html('');
                     alert('hello');
                }
                agreement_lenth = (obj.agreements).length;
                    html = '';
                    var data_val = {f0: "P", f1: "SP", f2: "PSP",
                        f3: "CA", f4: "SA", f5: "NA", f6: "RA"};
                    for (j = 0; j < agreement_lenth; j++) {
                        if (obj.agreements[j].SubscriptionAgreements.id != null) {
                            html += '<li><a href="' + Site_url + 'admin/Agreements/preview_agreement/' + obj.agreements[j].SubscriptionAgreements.id+'" target="_blank">Click here to view ' + data_val['f' + obj.agreements[j].SubscriptionAgreements.subscriber_type] + ' agreement online</a></li>';
                        }
                    }
                    $(".grouplinks").html(html);
                    
                    $("#subscridelete").click(function(e){
                    	return hideSubscriberLink();
                     	
                     });
                    
            },
            statusCode: {
                404: function() {
                    alert("page not found");
                }
            }
        });

        /***************************************************/
     });
    
    
    $('#search_bank').change(function() {
        var countryId = $(this).val();
        $("#search_category").html("<option>Loading...</option>");
        $.ajax({
            url: Site_url + 'eft_banks/getBankCategories',
            type: 'post',
            data: {countryId: countryId},
            success: function(data) {
                $("#search_category").html(data);
            }
        });
    });
});
var DATE_FORMAT_CUSTOM_JS = 'dd/mm/yy';
$(document).ready(function() {
    $(".tootltip-info").tooltip();
});
$("#subscription_date").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: DATE_FORMAT_CUSTOM_JS,
    onSelect: function(selected) {
        $("#renewal_date").datepicker("option", "minDate", selected)
    }
});
$("#renewal_date").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: DATE_FORMAT_CUSTOM_JS,
    onSelect: function(selected) {
        $("#subscription_date").datepicker("option", "maxDate", selected)
    }
});
$("#cancelbutton").click(function() {
    window.location.href = Site_url + 'admin/Subscribers';
    return false;
});
$("#backbutton").click(function() {
    window.location.href = Site_url + "admin/admins/login";
    return false;
});
$("#backbuttonChangePswrd").click(function() {

    window.location.href = Site_url + "admin/admins/index";
    return false;
});
/*$("#mail").click(function() {
 alert('Mail functionality in progress.');
 return false;
 });*/
$("#submit-bank-data").click(function() {
//alert(''');
    $('#add-bank').attr('action', Site_url + "admin/eft_banks").submit();
});
$("#submit-app-form-data").click(function() {
//alert(''');
    $('#add-apps-form').attr('action', Site_url + "admin/manage_apis").submit();
});
$(document).ready(function() {

    $("#add_trust_account").validate();

    $('#add-bank').validate({
        rules: {
            'data[EftBank][country]': {
                required: true
            },
            'data[EftBank][bank]': {
                required: true,
            },
            'data[EftBank][institutions]': {
                required: true,
            },
            'data[EftBank][proceed_url]': {
                required: true,
                url: true
            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        }

    });
    $('#add-apps-form').validate({
        rules: {
            'data[ManageApi][user_id]': {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        }

    });
});
$(document).ready(function() {
    $("#UserAgreement").change(function() {

        $("#UserAgreement").css("color", "#000");
        $(".agreement-show").hide();
    });
    $("#UserLogo").change(function() {
//alert($("#UserLogo").html());
        $("#UserLogo").css("color", "#000");
        $(".user-selected-logo").hide();
    });
    /////admin payment setting


    $("input[name='data[PaymentSetting][method]']").click(function() {
        $("input[name='data[PaymentSetting][holding]']").prop('checked', true);
    });
    $("input[name='data[PaymentSetting][holding]']").click(function() {
//alert($("input[name='data[PaymentSetting][holding]']").prop('checked'));
        if (!$(this).is(':checked')) {
            $("input[name='data[PaymentSetting][method]']").prop('checked', false);
        }
    });
//////account validation


    $('#AccountAdminIndexForm').validate();
});
$(document).ready(function() {

    $('.paymentClass').change(function() {
//alert("asd");
    	 var HoldingFixed = $('#PaymentSettingHoldFixed').prop("checked");
         var Holdingcal = $('#PaymentSettingHoldCalAmt').prop("checked");
         var Holdingvar = $('#PaymentSettingHoldVarAmt').prop("checked");
       
        if (HoldingFixed) {
            $('input[name="data[PaymentSetting][hold_fixed]"]').val(1);
        }
        else {
            $('#HoldingFixed0').removeAttr('checked');
            $('input[name="data[PaymentSetting][hold_fixed]"]').val(0);
            //$('.fixed-data').val('');
        }
        if (Holdingcal) {
//alert();
            $('input[name="data[PaymentSetting][hold_cal_amt]"]').val(1);
        }
        else {
            $('#HoldingCalAmt0').removeAttr('checked');
            $('input[name="data[PaymentSetting][hold_cal_amt]"]').val(0);
            //$('.cal-data').val('');
        }
        if (Holdingvar) {
            $('input[name="data[PaymentSetting][hold_var_amt]"]').val(1);
        }
        else {
//$('.var-data').val('');
            $('#HoldingVarAmt0').removeAttr('checked');
            $('input[name="data[PaymentSetting][hold_var_amt]"]').val(0)
        }
    });
});
function fillFields(id, name, email, preference) {
    $("#myModalLabel").html('Edit Recipient');
    $("#recipientId").val(id);
    $("#EmailCopyRecipientName").val(name);
    $("#EmailCopyRecipientEmail").val(email);
    $("#EmailCopyRecipientPreference").val(preference);
    $("#myModal").show();
}
function resetForAddRecipient() {
    $("#myModalLabel").html('Add a Recipient');
    $("#addrecipientForm")[0].reset();
    $("#myModal").show();
}
function formatDate(dateObject)
{ 
 var dtar =((dateObject.split(" "))[0]).split("-");
  var month = new Array();
     month[0] = "Jan";
     month[1] = "Feb";
     month[2] = "March";
     month[3] = "Apr";
     month[4] = "May";
     month[5] = "June";
     month[6] = "July";
     month[7] = "Aug";
     month[8] = "Sep";
     month[9] = "Oct";
     month[10] = "Nov";
     month[11] = "Dec";
     if(!dtar[2]) return "NA";
     var date = dtar[2] + "/" + month[parseInt(dtar[1]-1)] + "/" + dtar[0];
    return date;
}
$(document).ready(function() {
    $("#EmailCopyRecipientEmail").blur(function() {
        var emailAdded = $(this).val();
        var ID = $("#recipientId").val();
        $.ajax({
            type: "POST",
            data: {email: emailAdded, ID: ID},
            url: Site_url + "admin/manage_apis/checkEmail",
            success: function(data) {
                if (data == "invalid")
                {
                    $("#alreadyExists").show();
                    return false;
                } else {
                    $("#alreadyExists").hide();
                }
            }
        });
    });


    $("#SubscriptionAgreementSubscriberType").change(function() {
        var sel_val = $(this).val(); 
        if (sel_val != '') {
        if (sel_val != '') {
            var data = {f0: "P", f1: "SP", f2: "PSP",
                f3: "CA", f4: "SA", f5: "NA", f6: "RA"};
            $('.dynamic_subscriber_type').html(data['f' + sel_val]);
        } else {

            $('.dynamic_subscriber_type').html('xxxxx type');
        }
        $.ajax({
            url: Site_url+"admin/Agreements/fetchagreement",
            data: {sel_val: sel_val},
            type: "POST",
            beforeSend: function() {
                $('#wait-payment-process').show();
            },
            complete: function() {
                $('#wait-payment-process').hide();
            },
            success: function(data) { 
            	 checkSessionForAjax(data);
                if (data != 'new' && data != "Error") { 
                    var obj = jQuery.parseJSON(data);
                    $("#defaultTextInstAdmin").val(obj.SubscriptionAgreement.Agreement_text);
                    var buildarray = new Array(
                        "term",
                        "subscription_fee",
                        "number_of_free_transaction",
                        "receipted_and_disbursed_transaction",
                        "holding_receipted_transaction_eft",
                        "deposit_receipted_transaction_eft",
                        "commission_receipted_transaction_eft",
                        "credit_card_receipted_transaction_cc",
                        "holding_receipted_transaction_cc",
                        "disbursements_fees",
                        "group_transaction_fees",
                        "direct_transaction_fees",
                        "interest_on_funds",
                        "interest_on_funds",
                        "fee_per_deal",
                        "special_conditions"
                        );
                    for (i = 0; i < (buildarray.length); i++) {
                        var setdata = buildarray[i];
                        $('input[name="data[SubscriptionSchedule][' + setdata + ']"]').val(obj.SubscriptionSchedule[setdata]);
                    }
                   var d = obj.SubscriptionAgreement.modified; 
                   
                    $("#lastupdate").text(", Last Updated: " + formatDate(d));
                   
                    
                    
                    if(obj.SubscriptionSchedule.gst_applicable==0){
                        $("#SubscriptionScheduleGstApplicable0").prop("checked",true);
                        $("#SubscriptionScheduleGstApplicable1").prop("checked",false);
                    }else if(obj.SubscriptionSchedule.gst_applicable==1){
                        $("#SubscriptionScheduleGstApplicable1").prop("checked",true);
                        $("#SubscriptionScheduleGstApplicable0").prop("checked",false);
                    }
                    
                    
                    $("#SubscriptionScheduleGstApplicable_").val(obj.SubscriptionSchedule.gst_applicable);
                    $("#SubscriptionScheduleSubscriptionFeeMode_").val(obj.SubscriptionSchedule.subscription_fee_mode);
                    
                    if(obj.SubscriptionSchedule.subscription_fee_mode==0){
                        $("#SubscriptionScheduleSubscriptionFeeMode0").prop("checked",true);
                        $("#SubscriptionScheduleSubscriptionFeeMode1").prop("checked",false);
                    }else if(obj.SubscriptionSchedule.subscription_fee_mode==1){
                        $("#SubscriptionScheduleSubscriptionFeeMode1").prop("checked",true);
                        $("#SubscriptionScheduleSubscriptionFeeMode0").prop("checked",false);
                    }
                    
                    
                    
                    
                    $('textarea[name="data[SubscriptionSchedule][special_conditions]"]').val(obj.SubscriptionSchedule.special_conditions);

                    if (obj.SubscriptionAgreement.Agreement_text) {
                        $('#uploaded_agreement').html("Click here to view a copy of your <a href='" +Site_url+ "admin/Agreements/preview_agreement/" + obj.SubscriptionAgreement.id + "' target='_blank' >online agreement</a>");
                    } else {
                        $('#uploaded_agreement').html("");
                    }
		if (obj.SubscriptionSchedule.subscriber_agreement) {
						//var cnfm = confirm('Do you want to delete this attachment ?');
                        var downloadLink = "<a target='_blank' title='Click to view/download' class='' href='" +Site_url+ "img/agreements/" +obj.SubscriptionSchedule.subscriber_agreement+"'>"+obj.SubscriptionSchedule.subscriber_agreement+"</a>";
                        var delete_link = "<a href='" +Site_url+ "admin/Agreements/delete_subscriber_agreement/"+obj.SubscriptionSchedule.id+"' class='table-icon nomargin' title='Delete'><i class='glyphicon glyphicon-trash delete' data-type='DELETE' data-url='" +Site_url+ "admin/Agreements/delete_subscriber_agreement/"+obj.SubscriptionSchedule.id+"'></i></a>";
                        var uploadTemplate = tmpl('template-download');
                        var filesContainer = $('.fileupload').find('.files');
                        var data = {
                        		 "options": {"autoUpload":true},
                        		 "files" : [{"name": obj.SubscriptionSchedule.subscriber_agreement, "url": Site_url+ "img/agreements/" +obj.SubscriptionSchedule.subscriber_agreement,"size":obj.SubscriptionSchedule.file_size, "deleteUrl": '#',  "path": Site_url+ "img/agreements/" +obj.SubscriptionSchedule.subscriber_agreement, "isurl": 0}],
                        		 "formatFileSize": getFileSize
                        		 
                        }
                        renderTemplate(uploadTemplate, data, filesContainer, true);

                } else {
                	 var filesContainer = $('.fileupload').find('.files');
                	 filesContainer.html("");

                    }

                } else { 
                    $('#admin_aggrement').find("input[type=text],textarea").each(function() {
                        $(this).val('');
                    });
                    $('#admin_aggrement').find("input[type=radio]").each(function() {
                        $(this).prop("checked", false);
                    });
                }
                
            },
            statusCode: {
                404: function() {
                    alert("page not found");
                }
            }
        });
        myurl=$("#weburlid").attr("weburl");
        
        if(sel_val==0){sel_val='P';}
        pageurl=myurl+"/admin/Agreements/index/"+sel_val;
        if(pageurl!=window.location){
			window.history.pushState({path:pageurl},'',pageurl);	
		}
    }
        else
        	{
        	window.location.replace(Site_url + "admin/Agreements/index");
        	}
    });
    
    $("#subscridelete").click(function(){
    	return hideSubscriberLink();
    });


    $(".justclick").click(function() {
        $(this).closest('.bank-ref-individual').toggleClass('collapsed');
        if($(this).hasClass('glyphicon-arrow-down')) {
        	$(this).removeClass('glyphicon-arrow-down').addClass('glyphicon-arrow-up');
        	}
        	else {
        		$(this).removeClass( "glyphicon-arrow-up").addClass( "glyphicon-arrow-down");
        	}
    });

});

function showDetails(id) {
    $(".show-details-" + id).toggle('slow', function() {
        $(this).toggleClass('show-child-div');
    });
}

function hideSubscriberLink(){
	 $("#subscriberDownload").hide();
	 $("#subscridelete").hide();
	document.getElementById('data[user][agreementhidden]').value = 1;
	 return false;
}    


function addDynamicRow(targetElement, templateElement){
	var rowCnt = /[0-9]+/.exec($('#'+targetElement+' tbody>tr:last input:first').attr('name'));
	if(!rowCnt){rowCnt=0;}else{
		rowCnt = parseInt(rowCnt);
		rowCnt = rowCnt+1;
	}
	
	$newRow = $('#'+templateElement+' tbody>tr:last').clone(true);
	$newRow.html($newRow.html().replace(/XXX/g, rowCnt));
	if($('#'+targetElement+' tbody>tr').length>0){
		$newRow.insertAfter('#'+targetElement+' tbody>tr:last');
	}else{
		$('#'+targetElement+' tbody').append($newRow);
	}
	deleteRowTable();
	popupAlertForNewAccount();
	agreementEnter();
}


$(document).ready(function() {
	$("#rof_type_select_1").change(function() {
		bindOnPartyTypeSelect(1, this);
	});	
	$("#rof_type_select_2").change(function() {
		bindOnPartyTypeSelect(2, this);
	});	
});

function bindOnPartyTypeSelect(clientRoleId, el){
	var subscriberID = $('#AgreementDetail'+clientRoleId+'AgUserId').val();
	var select_val = $(el).val(); 
	var agreement_reference = $('#idx_agreement_reference').val();
	var ajaxurl = $('#idx_agreement_party_ajax_url').val();
	if(select_val != '') {
	//var client_role = $('input[name=data\\[AgreementDetail\\]\\[client_role_id\\]]:checked').val()
	//if(client_role != 'undefined') {
	 $.ajax({
		 
         url: ajaxurl +'/'+select_val+'/'+agreement_reference+'/'+subscriberID ,
         //data: {sel_val: sel_val},
         type: "POST",
         beforeSend: function() {
             $('#wait-payment-process').show();
         },
         complete: function() {
             $('#wait-payment-process').hide();
             addPartyAgreement();
             deleteDivDetail();
             initializeUploaders();
         },
         success: function(data) { 
        	 checkSessionForAjax(data);
             if (data != 'new' && data != "Error") {
            	 $('#agreement_party_'+clientRoleId).html(data);
             } 
         },
         statusCode: {
             404: function() {
                 alert("page not found");
             }
         }
     });
	}else {
		$('#agreement_party_'+clientRoleId).html('');
	}
	
}

var RoleRowCounts = new Array();
RoleRowCounts[2]=0;
RoleRowCounts[1]=0;

function setRoleRowCounts(clientRoleId, cnt){
	RoleRowCounts[clientRoleId] = cnt;
	//alert(RoleRowCounts[clientRoleId]);
}
function addPartyAgreement() {
	$('.inner-sub .addparty').unbind( "click" );
	$('.inner-sub .addparty').click(function() {
		var getID = this.id; 
		var CP_id = getID.split('_');
		var Crole_id = CP_id[1];
		var Party_id = CP_id[2];
		//alert(tableID+' '+Crole_id+' '+Party_id);
		//$('#'+getID).click(function() {
		addDynamicRowAgreement('agreement-options-table-'+Crole_id+'_'+Party_id, 'agreement-options-table-template_'+Crole_id,Crole_id,Party_id);
		//});
		//return false;
	});
	deleteRowTable();
	CheckForUser();
	validuser();
}
$(document).ready(function() {
	addPartyAgreement();
	
});

function addDynamicRowAgreement(targetElement, templateElement,clientRoleId,partyTypeId){
	var rowCnt = $('#AgreementDetail'+clientRoleId+'Maxrowcount').val();//RoleRowCounts[clientRoleId];
	//alert(rowCnt);
	rowCnt++;
	$('#AgreementDetail'+clientRoleId+'Maxrowcount').val(rowCnt);
	$('#'+templateElement+' tbody').children().each(function () {
		$newRow = $(this).clone(true, true);
	
		//$newRow = $('#'+templateElement+' tbody>tr:last').clone(true);
		$newRow.html($newRow.html().replace(/XXX/g, rowCnt));
		$newRow.html($newRow.html().replace(/YYY/g, partyTypeId));
		if($('#'+targetElement+' tbody>tr').length>0){
			$newRow.insertAfter('#'+targetElement+' tbody>tr:last');
		}else{
			//alert($newRow.html);
			$('#'+targetElement+' tbody').append($newRow);
		}
	});
	deleteRowTable();
	CheckForUser();
	validuser();
	agreementEnter();
}



function CheckForUser(){
$('.checkuser').unbind( "focusout" );
$('.checkuser').focusout(function() { 
	var getId = this.id; //alert(getId);
	common_user_exist(getId);
});
}

function onlyForRoleType(subscribertextID){
	var subscriberID = $('#'+subscribertextID).val();
	var allid =  subscribertextID.match(/(\d+)/g);
	var client_id = allid[0];
	var roleID = 'rof_type_select_'+client_id;
	var select_val = $('#'+roleID).val();
	var agreement_reference = $('#idx_agreement_reference').val();
	var ajaxurl = $('#idx_agreement_party_ajax_url').val();
	if(select_val != '') { 
	 $.ajax({
         url: ajaxurl+'/'+select_val+'/'+agreement_reference+'/'+subscriberID,
         type: "POST",
         beforeSend: function() {
             $('#wait-payment-process').show();
         },
         complete: function() {
             $('#wait-payment-process').hide();
             addPartyAgreement();
             initializeUploaders();
         },
         success: function(data) { 
        	 checkSessionForAjax(data);
             if (data != 'new' && data != "Error") {
            	 $('#agreement_party_'+client_id).html(data);
             } else {
            	 
             }
         },
         statusCode: {
             404: function() {
                 alert("page not found");
             }
         }
     });
}else {
	$('#agreement_party_'+client_id).html('');
}
}

function deleteDocument(){
	$('.deleteDoc').click(function(){
		var whichtr = $(this).closest("tr");
	    //alert('worked'); // Alert does not work
	    whichtr.remove();    
	});
}
$(document).ready(function() {
	deleteDocument();
	validuser();
	deleteDivDetail();
//	var abc  = $( "#AgreementDetail1AgUserId" ).val();
//	$( "#AgreementDetail1AgUserId" ).autocomplete({
//		  source: "/agreements/autoComplete"+abc,
//		  minLength: 2,
//		  delay: 2
//		});
});

function validuser(){
	$('.validuser').unbind( "click" );	
	$('.validuser').click(function(){
		var getId = $(this).closest('.input-group').find('input[type=text]').attr('id'); 
		common_user_exist(getId);
		 
	});
}

function common_user_exist(getId){
	var allid =  getId.match(/(\d+)/g);
	var client_id = allid[0];
	var count_id = allid[1]; 
	var subscriberValue = $('#'+getId).val();
	subscriberArray = subscriberValue.split('/');
	subscriberID = subscriberArray[0]; 
	if(subscriberID != ''){
	$.ajax({
         url: Site_url+"Agreements/checkUserExist/"+subscriberID,
         //data: {sel_val: sel_val},
         type: "POST",
         beforeSend: function() {
             $('#wait-payment-process').show();
         },
         complete: function() {
             $('#wait-payment-process').hide();
         },
         success: function(data) { 
            if(data == ''){
            	var reqval = $('#'+getId).val();
            	$('#requested_val').val(reqval);
            	$('#requested_field').val(getId);
            	$('input[type=text]').each(function(){
	            	  $(this).attr('placeholder','');
	            });
            	$('.userid_error').each(function(){
            		$(this).css('display','none');
            	});
            	$('.newAccount').each(function(){
            		$(this).css('display','none');
            	});
            	$('#email-error').each(function(){
            		$(this).css('display','none');
            	});
            	$( "#"+getId ).closest( ".label-wrap" ).find('#email-error').css('display','block');
            	$( "#"+getId ).closest( ".label-wrap" ).find('.newAccount').css('display','block');
            	$( "#"+getId ).closest( "tr" ).next('.userid_error').css('display','table-row');
            	$( "#"+getId ).closest( "tr" ).next('.userid_error').find('.newAccount').css('display','table-row');
            	$( "#"+getId ).closest( "tr" ).next('.userid_error').find('#email-error').css('display','table-row');
            	
            	//$('#myModal1').modal('show');
            	$('#'+getId).val('');
            	$('#'+getId).attr('placeholder','Request for new user pending');
            	$('#AgreementDetail'+client_id+'AgreementParty'+count_id+'CompanyContact').val('');
            	if(count_id === undefined){ 
					$('#AgreementDetail'+client_id+'AgreementParty0CompanyContact').val('');
					$('#AgreementDetail'+client_id+'AgreementParty0AccEmail').val(''); 
					}
            }else {
            	var CP_id = data.split('|');
            	var email_id = CP_id[0];
        		var user_id = CP_id[1];
        		var contactDetail = CP_id[2];
        		$('#'+getId).val(user_id+' / '+email_id);
            	$('#AgreementDetail'+client_id+'AgreementParty'+count_id+'CompanyContact').val(contactDetail);
            	if(getId == 'AgreementDetail1AgUserId' || getId == 'AgreementDetail2AgUserId'){
            		onlyForRoleType(getId);
            	}
            	$( "#"+getId ).closest( ".label-wrap" ).find('#email-error').css('display','none');
            	$( "#"+getId ).closest( ".label-wrap" ).find('.newAccount').css('display','none');
            	$( "#"+getId ).closest( "tr" ).next('.userid_error').css('display','none');
            	$( "#"+getId ).closest( "tr" ).next('.userid_error').find('.newAccount').css('display','none');
            	$( "#"+getId ).closest( "tr" ).next('.userid_error').find('#email-error').css('display','none');
            	$('#'+getId).attr('placeholder','');
            }
            popupAlertForNewAccount();
         },
         error: function(e) {
        	 //alert(e.message);
        		//called when there is an error
        		//console.log(e.message);
        	  },
         statusCode: {
             404: function() {
                 alert("page not found");
             }
         }
     });
		}else {
			$('#AgreementDetail'+client_id+'AgreementParty'+count_id+'CompanyContact').val(''); 
			if(count_id === undefined){ 
			$('#AgreementDetail'+client_id+'AgreementParty0CompanyContact').val('');
			$('#AgreementDetail'+client_id+'AgreementParty0AccEmail').val(''); 
			}
		}
}

function deleteDivDetail() { 
	$('.deleteDiv').unbind( "click" );
	$('.deleteDiv').click(function(){
		var spanId = this.id;
		var clientRole =  spanId.match(/(\d+)/g);
		$('#toggal_div'+clientRole[0]).remove();
		
	});
	
}

$(document).ready(function(){
	 $('.search_remove_param').click(function() {
 		var getID = this.id;
 		var fieldToRemove = getID.substring(7);
 		$('#AgreementRemoveCriteria,#DealRemoveCriteria,#ProjectRemoveCriteria').val(fieldToRemove);
 		$('#form_agreement_search,#form_deal_search,#form_project_search').submit();
 		
 		return false;
 	});
	
});

function checkSessionForAjax(data){
	//alert('here');
	
	if (data !== undefined){
		var CP_id = data.split('|');
		var session_msg = CP_id[0];
		if(session_msg == 'SESSION_EXPIRED'){
		var session_url = CP_id[1];
		 window.location.assign(session_url)
		}
	}
}
//function ErrorCheckSessionPostAjax(XMLHttpRequest, textStatus, errorThrown){
//	alert(XMLHttpRequest + ' textStatus:' + textStatus + ' errorThrown: ' + errorThrown);
//}
/*script for document upload using drag and drop */
$(function () {
	initializeUploaders();
	bindDragDropArea();
	bindAgreementPartySubmit();
});
function initializeUploaders(){
	initializeFileUploader();
	initializeUrlFileUpload();
	initializeAddLink();
}
function initializeFileUploader(){
	'use strict';
    //destroy any added upload plugin
    
    $('.custom_upload_file_widget').each(function(){
    	//alert($(this).parent().attr('class'));
    	if($(this).parent().hasClass('fileupload')){
    		$(this).unwrap();
    	}
    });
    $('.custom_upload_file_widget').wrap('<form class="fileupload" action="file-uploader/" method="POST" enctype="multipart/form-data"></form>');

    //add upload plugin
    $('.fileupload').each(function () {
    	var script_url = $('#script_url').val();
    	var autoUploadType = $('#auto_upload').val();
    	var upload_type = true;
    	if(autoUploadType == 'no'){
    		upload_type = false;
    	}else{
    		upload_type = true;
    	}
    	var tmpl_ids = $(this).find('script[type="text/x-tmpl"]');
    	//alert(tmpl_ids);
    	var template_upload = 'template-upload';
    	var template_download = 'template-download';
    	tmpl_ids.each(function(){
    		var tid = $(this).attr('id');
    		if(tid.indexOf('template-upload')==0){
    			template_upload = tid;
    		}else{
    			template_download = tid;
    		}
    		
    	});
    	//alert('template_upload = ' + template_upload + '  template_download = ' + template_download);
    	
        $(this).fileupload({
        	url: script_url,
        	dropZone: $(this),
        	autoUpload: upload_type,
        	uploadTemplateId: template_upload,
        	downloadTemplateId: template_download
        	
        });
        if(autoUploadType == 'no'){
        	 $(this).bind('fileuploadsubmit', function (e, data) { 
                 data.formData = data.context.find(':input').serializeArray(); //alert(data.form.serializeArray());
                // data.formData=$('.fileupload_custom').find(':input').serializeArray();
             });
        }
        $(this).bind('fileuploadalways', function (e, data) { 
        	checkSessionForAjax(data.jqXHR.responseText);
        });
        
        if($('#isMultiple').val() == 'no'){
        $(this).bind('fileuploadadd', function (e, data) { 
        	 var $this = $(this),
             that = $this.data('blueimp-fileupload') ||
                 $this.data('fileupload'),
             options = that.options;
         	if(options.filesContainer.children().length == 0){
        		//$('.fileinput-button').hide();
        		//$("#dropzone").removeClass("dropzone fade well");
        		//$("tr#extraRow").hide();
        		//$('#drop-heading').hide();
        		//$('.fileupload-buttonbar').hide();
        	}
        	 
        	if(options.filesContainer.children().length > 0){
        		options.filesContainer.children().remove();
        	}
        });
        
        $(this).bind('fileuploaddestroyed', function (e, data) {
        	//$('.fileinput-button').show();
        	//$("#dropzone").addClass("dropzone fade well");
        	//$("tr#extraRow").show();
    		//$('#drop-heading').show();
    		//$('.fileupload-buttonbar').show();
        });
        }
        
        
//        //disable submit button on each send fileuploadprogressall
//        $(this).bind('fileuploadsubmit', function (e, data) {
//        	//disable submit button here
//        	$('.submitwithupload').each(function () {
//    	    		if(!$(this).hasClass('disabled')){
//    	    			$(this).addClass('disabled');
//    	    		}
//        		});
//        	});
//        //enable submit button on each always
//        $(this).bind('fileuploadalways', function (e, data) {
//        	//disable submit button here
//        	
//        	var activeUploads =false;
//        	$('.fileupload').each(function () {
//        		if($(this).fileupload('active')>1){
//        			activeUploads = true;
//        		}
//        	});
//        	if(activeUploads){
//        		$('.submitwithupload').each(function () {
//    	    		if(!$(this).hasClass('disabled')){
//    	    			$(this).addClass('disabled');
//    	    		}
//        		});
//        	}else{
//        		$('.submitwithupload').each(function () {
//    	    		if($(this).hasClass('disabled')){
//    	    			$(this).removeClass('disabled');
//    	    		}
//        		});
//        	}
//        	
//        	});
        
        // Enable iframe cross-domain access via redirect option:
        $(this).fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                /\/[^\/]*$/,
                '/cors/result.html?%s'
            )
        );
    });
    
  
  
}
function bindAgreementPartySubmit(){
	/** unwrap then file uploader form before submit*/
	$('#propertyAppend').bind('submit', function() {
		var $form = $(this);
	    var id = $form.attr('id');
	    
		var activeUploads =false; 
    	$('.fileupload').each(function () {
    		if($(this).fileupload('active')>0){
    			activeUploads = true;
    		}
    	});
    	if(url_upload_list.length>0){activeUploads=true;}
		if(activeUploads){
			var descision = confirm('File upload is still in progress. Documents which are not uploaded will not be saved. Do you want to continue?');
			if(descision==false){
				return false;
			}
		}
		$('.custom_upload_file_widget').each(function(){
	    	if($(this).parent().hasClass('fileupload')){
	    		$(this).unwrap();
	    	}
	    });
	});
    
    $('.customeUploadForm').bind('submit', function() {
		var $form = $(this);
	    var id = $form.attr('id');
	    
		var activeUploads =false; 
    	$('.fileupload').each(function () {
    		if($(this).fileupload('active')>0){
    			activeUploads = true;
    		}
    	});
    	if(url_upload_list.length>0){activeUploads=true;}
		if(activeUploads){
			var descision = confirm('File upload is still in progress. Documents which are not uploaded will not be saved. Do you want to continue?');
			if(descision==false){
				return false;
			}
		}
		$('.custom_upload_file_widget').each(function(){
	    	if($(this).parent().hasClass('fileupload')){
	    		$(this).unwrap();
	    	}
	    });
	});
    
    
    
}

function bindDragDropArea(){
	$(document).bind('dragover', function (e)
			{
				
				var dropZone = $('.dropzone'),
			    foundDropzone,
			    timeout = window.dropZoneTimeout;
			    if (!timeout)
			    {
			        dropZone.addClass('in');
			    }
			    else
			    {
			        clearTimeout(timeout);
			    }
			    var found = false,
			    node = e.target;

			    do{

			        if ($(node).hasClass('dropzone'))
			        {
			            found = true;
			            foundDropzone = $(node);
			            break;
			        }

			        node = node.parentNode;

			    }while (node != null);

			    dropZone.removeClass('in hover');

			    if (found)
			    {
			        foundDropzone.addClass('hover');
			    }

			    window.dropZoneTimeout = setTimeout(function ()
			    {
			        window.dropZoneTimeout = null;
			        dropZone.removeClass('in hover');
			    }, 100);
			});

			$(document).bind('drop dragover', function (e) {
			    e.preventDefault();
			});
}
/*this variable is used to keep the count of upload by url requests*/
var url_upload_sql_no = 1;
var url_upload_list = [];
/**
 * Add seq number to active upload list
 * @param url_upload_sql_no
 */
function add_to_url_upload_list(url_upload_sql_no){
	url_upload_list[url_upload_list.length]=url_upload_sql_no;
}
/**
 * remove from active upload list
 * @param url_upload_sql_no
 * @param removeAll
 */
function remove_from_url_upload_list(url_upload_sql_no, removeAll){
	if(removeAll){
		url_upload_list = [];
		return;
	}
	var indexToRemove='none';
	for	(index = 0; index < url_upload_list.length; index++) {
		if(url_upload_list[index] == url_upload_sql_no){
			indexToRemove = index;
			break;
		}
	}
	if(indexToRemove!='none'){
		url_upload_list.splice(indexToRemove,1); 
	}
}

/**
 * initialize upload file using url component 
 */
function initializeUrlFileUpload(){
	$('.urlUpload').each(function () {
		$(this).unbind();
		$(this).bind( "click", function() {
			var file_url = $(this).closest('form').find(':input[name=\'remote_url\']').val();
			if(isEmptyStr(file_url)){return false;}
			var script_url = $('#upload_from_url_script_url').val();
			var client_role_id = $(this).closest('form').find(':hidden[name=\'tmpClientRoleID\']').val();
			var sub_folder_path = $(this).closest('form').find(':hidden[name=\'sub_folder_path\']').val();
			var document_type = $(this).closest('form').find(':hidden[name=\'document_type\']').val();
			var download_template = $(this).closest('form').find(':hidden[name=\'template-download-field\']').val();
			var upload_template = $(this).closest('form').find(':hidden[name=\'template-upload-field\']').val();
			var filesContainer = $(this).closest('form').find('.files');
			
			if(upload_template==undefined){
       		 upload_template = 'template-upload';
       	 	}
			if(download_template==undefined){
				download_template = 'template-download';
	       	}
			
			 $(this).closest('form').find(':input[name=\'remote_url\']').val('');
			//alert(encodeURIComponent(file_url) + " ------------ " + file_url + " ---- " + script_url + " c_id = " + client_id + ' sub_folder_path = ' + sub_folder_path + " document_type = " + document_type);
			$.ajax({
		         url: script_url+'?url='+encodeURIComponent(decodeURIComponent(file_url)) + '&client_role_id='+client_role_id+'&sub_folder_path='+sub_folder_path+'&document_type='+document_type+'&url_upload_sql_no='+url_upload_sql_no,
		         //data: {sel_val: sel_val},
		         type: "POST",
		         beforeSend: function() {
		        	 //add file progress to dropzone
		             //$('#wait-payment-process').show();
		        	 
		        	 
		             var uploadTemplate = tmpl(upload_template);
		             var small_url = file_url.trimToLength(20);
		            // alert(filesContainer.attr('class'));
		             var data = {
		            		 "options": {"autoUpload":true},
		            		 "files" : [{"name": file_url, "url_upload_sql_no": url_upload_sql_no}],
		            		 
		             }
		             add_to_url_upload_list(url_upload_sql_no);
		             url_upload_sql_no++;
		             renderTemplate(uploadTemplate, data, filesContainer, true);
		            
		         },
		         complete: function(jqXHR, textStatus) {
		            
		        	// $('#wait-payment-process').hide();
		         },
		         success: function(data) { 
		            //render download template
		        	// checkSessionForAjax(data);
                   // alert("in susce");
		        	 var uploadTemplate = tmpl(download_template);
		            // alert("in susce2");
			             
			             var datax = {
			            		 "options": {"autoUpload":true},
			            		 "files" : eval(data),
			            		 "formatFileSize": getFileSize
			             }
			             renderTemplate(uploadTemplate, datax, filesContainer,false );
                        // alert("in susce3");
			             remove_from_url_upload_list(datax.files[0].url_upload_sql_no, false);
                        // alert("in susce4");
		         },
		         error: function(e) {
		        	 remove_from_url_upload_list(0, true);
		        	  },
		         statusCode: {
		             404: function() {
		                 alert("page not found");
		             }
		         }
		     });
			
		});
	});
}
/**
 * This function is used to render the template of file upload using url
 * @param func
 * @param data
 * @param filesContainer
 * @param isupload
 */
function renderTemplate(func, data, filesContainer, isupload) {
    
    var result = func(
    	data
    );
    if(isupload){
    	if($('#isMultiple').val() == 'no'){
    		//if no multiple allowed then remove existing images 
    		 if(filesContainer.children().length > 0){
    			 filesContainer.children().remove();
            }
    	 }
	    filesContainer.append(result).children().each(function () {
	    	if(!$(this).hasClass('in')){$(this).addClass('in');}
	    });
	    bindCancelUrlUpload();
	    
	    //start fake progress bar
	    var progress = setInterval(function() {
	    	var row = filesContainer.find('tr[id=\'url_'+ data.files[0].url_upload_sql_no+'\']');
	        var $bar = row.find('.progress-bar');
	       // console.log('length ' + $bar.length);
	        if($bar.length==0){clearInterval(progress);}
			if(parseInt($bar.width())==0){
				$bar.data('actualwidth', 0);
			}
	        if (parseInt($bar.width())>=100) {
	            clearInterval(progress);
	        } else {
	        	$bar.data('actualwidth', $bar.data('actualwidth')+5);
	            $bar.width($bar.data('actualwidth') + '%');
	        }
	        //$bar.text($bar.width() + "%");
	    }, 800);
    }else{
    	var row = filesContainer.find('tr[id=\'url_'+ data.files[0].url_upload_sql_no+'\']');
    	row.replaceWith(result);
    	row = filesContainer.find('tr[id=\'url_'+ data.files[0].url_upload_sql_no+'\']');
    	row.addClass('in');
    }
    
};
function bindCancelUrlUpload(){
	$('.cancel-url-upload').unbind();
	$('.cancel-url-upload').bind( "click", function() {
		var url_upload_sql_no = $(this).closest('tr').attr('id').split('_')[1];
		remove_from_url_upload_list(url_upload_sql_no, false);
	});
}


function getFileSize(size){
	return size;
}
String.prototype.trimToLength = function(m) {
	  return (this.length > m) 
	    ? jQuery.trim(this).substring(0, m) + "..."
	    : this;
	};

function initializeAddLink(){
	$('.urlLink').each(function () {
		$(this).unbind();
		$(this).bind( "click", function() {
			var file_url = $(this).closest('form').find(':input[name=\'remote_link\']').val();	
			if(isEmptyStr(file_url)){return false;}
			var filesContainer = $(this).closest('form').find('.files');
			var client_role_id = $(this).closest('form').find(':hidden[name=\'tmpClientRoleID\']').val();
			var uploadTemplate = tmpl('template-download');
            var small_url = file_url.trimToLength(20);
            // alert(filesContainer.attr('class'));
            var data = {
            		 "options": {"autoUpload":true},
            		 "files" : [{"name": file_url, "url": file_url, "deleteUrl": '#', "client_role_id": client_role_id, "path": file_url, "isurl": 1}],
            		 "formatFileSize": getLinkSize
            		 
            }
            renderTemplate(uploadTemplate, data, filesContainer, true);
            $(this).closest('form').find(':input[name=\'remote_link\']').val('');
		});
	});
	
} 
function getLinkSize(){return '';}

function isEmptyStr(str){
	return (!str || /^\s*$/.test(str));
}
$(document).ready(function() {
	 $('#dealdetail').validate();
	 $('#dealdetailedit').validate();
	 $('#masterdetail').validate();
	 $('#masterdetailedit').validate();
	 $('#projectdetail').validate();
	 $('#projectdetailedit').validate();
	 $('.linkdetail').each(function () {
		    $(this).validate();
		});
	 
	 var bindclassdeal = 'dealsearch';
		var pathdeal = "Deals/admindealsearch/";
		var autoselect = true;
		common_autoComplete(bindclassdeal,pathdeal,autoselect);
	 
	 
	 $('.dealsearch').bind('focusout',function() { 
	    	var disb = $('#AgreementDealReference').val(); 
	    	if(disb != ''){
	    	existCheck(disb,'Deals/checkAdminDealExist/','AgreementDealReference','');
	    	}else {
	    		 $('#deal_project').text('');
	    		 $('#master_project').text('');
	    	}
		});

	 
	 $('.divtoggle').click(function() {
			$('.divsearch').toggle();
			if($(".divsearch").css("display") == "block") {
				$(".divtoggle").html("<span class='glyphicon glyphicon-minus-sign'></span> Hide search");
		  	}
			else {
				$(".divtoggle").html("<span class='glyphicon glyphicon-plus-sign'></span> Show search");
			}
			return false;
		});
	 
	 	deallinkservice();
	    checkforLinkSubscriber();
	    SubscriberClickCheck();
	    dealedit();
	    project_search();
	    projectedit();
	    master_search();
	    masterprojectedit();
	    serviceproviderlink();
	    dealeditClick();
	    projecteditClick();
	    mastereditClick();
	    
	    popupAlertForNewAccount();
	    AgreementPlaceholderMsgLink();
	    //OnlyDealLinkService();
	    
	    $('#myModalnew').on('hide.bs.modal', function (e) {
//	    	$('.dealsubscriber').val('');
//	    	$('#myModallinkservice').css('opacity','1');
	    	})
	    	
	    	$('#PaymentSettingHolding').click(function(){
	            if($(this).prop("checked") == true){
	            	$('#PaymentSettingHoldFixed').prop("checked",true) ;
	            	$('#PaymentSettingHoldCalAmt').prop("checked",true) ;
	            	$('#PaymentSettingHoldVarAmt').prop("checked",true) ;
	                
	            }
	            else if($(this).prop("checked") == false){
	            	$('#PaymentSettingHoldFixed').prop("checked",false) ;
	            	$('#PaymentSettingHoldCalAmt').prop("checked",false) ;
	            	$('#PaymentSettingHoldVarAmt').prop("checked",false) ;
	                
	            }
	            var HoldingFixed = $('#PaymentSettingHoldFixed').prop("checked");
	            var Holdingcal = $('#PaymentSettingHoldCalAmt').prop("checked");
	            var Holdingvar = $('#PaymentSettingHoldVarAmt').prop("checked");

	            if (HoldingFixed) {
	                $('input[name="data[PaymentSetting][hold_fixed]"]').val(1);
	            }
	            else {
	                $('input[name="data[PaymentSetting][hold_fixed]"]').val(0);
	                //$('.fixed-data').val('');
	            }
	            if (Holdingcal) {
	                $('input[name="data[PaymentSetting][hold_cal_amt]"]').val(1);
	            }
	            else {
	                $('input[name="data[PaymentSetting][hold_cal_amt]"]').val(0);
	                //$('.cal-data').val('');
	            }
	            if (Holdingvar) {
	                $('input[name="data[PaymentSetting][hold_var_amt]"]').val(1);

	            }
	            else {
	                //$('.var-data').val('');
	                $('input[name="data[PaymentSetting][hold_var_amt]"]').val(0)
	            }
	        });
		    
		    $('#PaymentSettingHoldFixed').click(function(){
		    	paysettingHolding();
		    });
		    $('#PaymentSettingHoldCalAmt').click(function(){
		    	paysettingHolding();
		    });
		    $('#PaymentSettingHoldVarAmt').click(function(){
		    	paysettingHolding();
		    });
	    	
    $("#payment_settings_front").submit(function() { 
    	if($('#PaymentSettingHolding').prop("checked") == false || $('#PaymentSettingPartorfull').prop("checked") == false || $('#PaymentSettingCommission').prop("checked") == false){
        	var holding='';
        	var result='';
        	var comm='';
        	if($('#PaymentSettingHolding').prop("checked") == false){
        		holding = 'Holding deposits';
        		result = 'holding deposits'
        	}
        	if($('#PaymentSettingPartorfull').prop("checked") == false){
        		if(holding==''){
        			holding = 'Deposit';
        			result = 'deposit';
        		}else{
        			holding = holding +',Deposit';
        			result = result +',deposit';
        		}
        	}
        	if($('#PaymentSettingCommission').prop("checked") == false){
        		if(holding==''){
        			holding = 'Commission';
        			result = 'commission';
        		}else{
        			holding = holding +',Commission';
        			result = result +',commission';
        		}
        	}
        	var descision = confirm('Unchecking '+holding+' will make add funds service unavailable for '+result+'. Do you want to continue?');
        	if(descision==false){
				return false;
			}
        }
    });
    
    var txt = document.getElementById('DefaultTextDefaultValue');
    if(txt != null){
    	txt.addEventListener('keyup', myFunc);
    }
    

});
function paysettingHolding(){
	 if($('#PaymentSettingHoldFixed').prop("checked")==false && $('#PaymentSettingHoldCalAmt').prop("checked")==false && $('#PaymentSettingHoldVarAmt').prop("checked")==false)
	    {
	    	 $('#PaymentSettingHolding').prop("checked",false);
	    }else if($('#PaymentSettingHoldFixed').prop("checked")==true || $('#PaymentSettingHoldCalAmt').prop("checked")==true || $('#PaymentSettingHoldVarAmt').prop("checked")==true){
	    	$('#PaymentSettingHolding').prop("checked",true);
	    }
}
function myFunc(e) {
    var val = this.value;
    var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
    var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
    if (re.test(val)) {
        //do something here

    } else {
        val = re1.exec(val);
        if (val) {
            this.value = val[0];
        } else {
            this.value = "";
        }
    }
}
function existCheck(passvalue,path,fieldId,fieldclass){
	$.ajax({
        url: Site_url + path +'/'+ passvalue,
        type: "POST",
        beforeSend: function() {
            $('#wait-payment-process').show();
            $('.unloading_link').css('visibility', 'hidden');
            $('.loading_link').css('display', 'block');
        },
        complete: function() {
            $('#wait-payment-process').hide();
            $('.unloading_link').css('visibility', 'visible');
            $('.loading_link').css('display', 'none');
        },
        success: function(data) {
        	 if(fieldId == 'AgreementDealReference'){
        	checkSessionForAjax(data);
        	 }
        if(fieldclass!=''){
        	if(data == '""'|| data == ''){
        		var reqval = $(fieldclass).val();
        		$('#requested_val').val(reqval);
	           	$(fieldclass).val('');
	           	$(fieldclass).attr('placeholder','Request for new user pending');
//	           	$('#myModalnew').modal('show'); 
	           	$('.userid_error').css('display', 'block');
        		$(".user_error").css('display', 'block');
        		$("#email-error").css('display', 'block');
//	           	$('#myModallinkservice').css('opacity','0.89');
	           }else {
	        		   $(fieldclass).val(data);
	        		   $('#DealServiceProviderUserHidden').val(data);
	        		   $('.userid_error').css('display', 'none');
	        		   $(".user_error").css('display', 'none');
	        		   $("#email-error").css('display', 'none');
	        		   $(fieldclass).attr('placeholder','<Enter subscriber number or registered email address>');
	           }
        }else{
           if(data == '""'|| data == ''){
        	
           	$('#'+fieldId).val('');
	            if(fieldId == 'AgreementDealReference'){
	           	$('#deal_project').text('');
	           	$('#master_project').text('');
	            }
           }else {
        	   if(fieldId == 'AgreementDealReference'){
	        	   var datavalue = data.split('//');
	        	   var proRef = datavalue[0].split('_');
	        	   $('#master_project').text(proRef[0]);
	        	   $('#deal_project').text(proRef[1]); 
	        	   $('#'+fieldId).val(datavalue[1]); 
	        	   }else{
        		   $('#'+fieldId).val(data);
        	   }
           }
        }
        popupAlertForNewAccount();
        },
        error: function(e) {
       	 //alert(e.message);
       		//called when there is an error
       		//console.log(e.message);
       	  },
        statusCode: {
            404: function() {
                alert("page not found");
            }
        }
    });
}

function popupAlertForNewAccount(){
	$('.newAccount').bind( "click", function() {
    	$('#savetype').val('OnSession');
    	if($('#screenToken').val()=='agreement'){
    	var fieldId = $('#requested_field').val();
    	$('#agreementvalidation').val(fieldId);
    	$('#'+fieldId).val('RequestForUser');
    	$('#'+fieldId).css('color', '#FFFFFF');
    		$('#agreement_party_form').submit();
    		AgreementPlaceholderMsgLink();
    	}
    	if($('#screenToken').val()=='linkservice'){
    		var fieldId = 'DealServiceProviderUserId';
    		$('#Dealvalidation').val(fieldId);
    		var clientroleVal = $('input[name="data[DealServiceProvider][client_role_id]"]:checked').val();
    		var ServiceroleVal = $('input[name="data[DealServiceProvider][service_provider_id]"]:checked').val();
    		if(clientroleVal===undefined || ServiceroleVal === undefined){
    			$('#DealServiceProviderUserId').val('RequestForUser');
    			var path = 'deals/getlinkservice/" "/'+'1';
    			var fname = '.linkdetail';
    			var modalbody = '#linkservice-body';
    			var modalfield = "#myModallinkservice";
    			checkmanadatory_LinkService(path,fname,modalbody,modalfield);
    			$('#myModalnew').modal('hide');
    		}else if(ServiceroleVal == 0 && ($('#DealServiceProviderType').val()=='' || $('#DealServiceProviderType').val()===undefined)){
    			$('#DealServiceProviderUserId').val('RequestForUser');
    			var path = 'deals/getlinkservice/" "/'+'1';
    			var fname = '.linkdetail';
    			var modalbody = '#linkservice-body';
    			var modalfield = "#myModallinkservice";
    			checkmanadatory_LinkService(path,fname,modalbody,modalfield);
    			$('#myModalnew').modal('hide');
    		}
    		else{
    			
	    		$('.linkdetail').submit();
    		}
    	}
    });
}


function deallinkservice(){
	var bindclass = 'deallink';
	var path = 'Deals/getlinkservice';
	var titlediv = '.deal-modal';
	var titletext = 'deal';
	var bodymodal = '#linkservice-body';
	common_editModule(bindclass,path,titlediv,titletext,bodymodal);


	
	link_autochecked();

}
function checkforLinkSubscriber(){
	var bindclass = 'dealsubscriber';
	var path = "Transactions/usersearch/";
	var autoselect = false;
	common_autoComplete(bindclass,path,autoselect);
	
	
	 $('.dealsubscriber').on('focusout keydown',function(e) { 
		 var disb = $(this).val();
		 if (e.keyCode != 27 && e.type == 'focusout') {
	    	if(disb != ''){
	    	existCheck(disb,'Transactions/checkUserExist/','DealServiceProviderUserId',this);
	    	}
		 }else if (e.keyCode == 27){
			 $('#DealServiceProviderUserId').val('');
		 }
		});
}
function SubscriberClickCheck(){
	$('.search-subscriber').bind( "click", function() {
		 existCheck('','Transactions/checkUserExist/','DealServiceProviderUserId',this);
	});
}

function dealedit(){
	var bindclass = 'dealedit';
	var path = 'Deals/getdealedit';
	var titlediv = '.deal-modal';
	var titletext = 'deal';
	var bodymodal = '#deal-edit-body';
	common_editModule(bindclass,path,titlediv,titletext,bodymodal);
	

	
	 $('#dealdetailedit').validate();
	 $('#masterdetailedit').validate();
	 $('#projectdetailedit').validate();
}


function common_editModule(bindclass,path,titlediv,titletext,bodymodal){
	
	$('.'+bindclass).bind( "click", function() {
    	var passvalue = $(this).next('input').val();
    	if(passvalue === undefined){
    		passvalue = 'add';
    		$(titlediv).text('Add '+titletext);
    	}else{
    		$(titlediv).text('Edit '+titletext);
    	}
    	var userval = $('#isAdmin').val();
    	$.ajax({
	        url: Site_url + path +'/'+ passvalue+'/'+userval,
	        type: "POST",
	        beforeSend: function() {
	        	$('.unloading_link').css('display', 'none');
	        	$('.loading_link').css('display', 'block');
	        },
	        complete: function() {
	            $('.unloading_link').css('display', 'block');
	        	$('.loading_link').css('display', 'none');
	        },
	        success: function(data) { 
	        	checkSessionForAjax(data);
	    			$(bodymodal).html(data);
	    			checkforLinkSubscriber();
	    			SubscriberClickCheck();
	    			link_autochecked();
	    			project_search();
	    			master_search();
	        },
	        error: function(e) {
	       	
	       	  },
	        statusCode: {
	            404: function() {
	                alert("page not found");
	            }
	        }
	    });
	
    });
}

function common_autoComplete(bindclass,path,autoselect){
	 $( "."+bindclass ).autocomplete({ 
	        source: function( request, response ) { 
	            $.ajax({
	                url: Site_url+path,
	                dataType: "json",
	                data: {
	                	q: request.term
	                  },
	                  success: function( data ) { 
	                	 
	                    response( data );
	                  }
	            });
	            },
	            minLength: 3,
	            autoFocus: autoselect,
	            select: function( event, ui ) {
	            	if(ui.item.id == '0'){ 
	            		
	            	}
	              }
	      });
}



function projectedit(){
	var bindclass = 'projectedit';
	var path = 'Projects/getprojectedit';
	var titlediv = '.project-modal';
	var titletext = 'project';
	var bodymodal = '#project-edit-body';
	common_editModule(bindclass,path,titlediv,titletext,bodymodal);

}
function masterprojectedit(){
	var bindclass = 'masteredit';
	var path = 'Projects/getmasteredit';
	var titlediv = '.master-modal';
	var titletext = 'master project';
	var bodymodal = '#master-edit-body';
	common_editModule(bindclass,path,titlediv,titletext,bodymodal);

}
function project_search(){
	var bindclass = 'projectSearch,.dealprojectSearch';
	var path = "Projects/adminprojectSearch/";
	var autoselect = true;
	common_autoComplete(bindclass,path,autoselect);
	 
	 
	 $('.projectSearch').bind('focusout',function() { 
	    	var disb = $('#DealProjectReference').val();
	    	if(disb != ''){
	    	existCheck(disb,'Projects/checkAdminProjectExist/','DealProjectReference','');
	    	}
		});
	 
	 $('.dealprojectSearch').bind('focusout',function() { 
	    	var disb = $('#DealProjectReference').val();
	    	if(disb != ''){
	    	existCheck(disb,'Projects/checkAdminProjectExist/','DealProjectReference','');
	    	}
		});
}

function master_search(){
	var bindclass = 'masterSearch,.projectmasterSearch';
	var path = "Projects/adminmastersearch/";
	var autoselect = true;
	common_autoComplete(bindclass,path,autoselect);
	
	 
	 $('.masterSearch').bind('focusout',function() { 
	    	var disb = $('#ProjectMasterReference').val(); 
	    	if(disb != ''){
	    	existCheck(disb,'Projects/checkAdminMasterExist/','ProjectMasterReference','');
	    	}
		});
	 $('.projectmasterSearch').bind('focusout',function() { 
	    	var disb = $('#ProjectMasterReference').val(); 
	    	if(disb != ''){
	    	existCheck(disb,'Projects/checkAdminMasterExist','ProjectMasterReference','');
	    	}
		});
}
function link_autochecked(){
	$( "#DealServiceProviderType" ).focus(function() {
		$('#DealServiceProviderServiceProviderId5').prop( "checked", true );
	});
}
function serviceproviderlink(){
	var btnclass = 'btn-linkservice';
	var path = 'deals/getlinkservice';
	var fname = '.linkdetail';
	var modalbody = '#linkservice-body';
	var modalfield = "#myModallinkservice";
	commanClickForDealProject(btnclass,path,fname,modalbody,modalfield);

	
	

}

function dealeditClick(){
	var btnclass = 'btn-dealedit';
	var path = 'deals/getdealedit';
	var fname = '#dealdetailedit';
	var modalbody = '#deal-edit-body';
	var modalfield = "#myModal2";
	commanClickForDealProject(btnclass,path,fname,modalbody,modalfield);

}
	

function projecteditClick(){
	var btnclass = 'btn-projectedit';
	var path = 'projects/getprojectedit';
	var fname = '#projectdetailedit';
	var modalbody = '#project-edit-body';
	var modalfield = "#myModal3";
	commanClickForDealProject(btnclass,path,fname,modalbody,modalfield);


}

function mastereditClick(){
	var btnclass = 'btn-masteredit';
	var path = 'projects/getmasteredit';
	var fname = '#masterdetailedit';
	var modalbody = '#master-edit-body';
	var modalfield = "#myModal1";
	commanClickForDealProject(btnclass,path,fname,modalbody,modalfield);


}


function commanClickForDealProject(btnclass,path,fname,modalbody,modalfield){
	$('.'+btnclass).bind('click', function() { 
		if(btnclass == 'btn-linkservice' && $('#DealServiceProviderUserId').attr('placeholder')=='Request for new user pending'){
			$( "#DealServiceProviderUserId").focus();
			return false;
		}
		 $.ajax({
		        type: "POST",
		        url: Site_url + path,
		        beforeSend: function() {
		        	$('.unloading_link').css('display', 'none');
		        	$('.loading_link').css('display', 'block');
		        },
		        complete: function() {
		            $('.unloading_link').css('display', 'block');
		        	$('.loading_link').css('display', 'none');
		        },
		        data: $(fname).serialize(),
		        success: function(msg){
		        	checkSessionForAjax(msg);
		        	if(msg!=''){
		        	$(modalbody).html(msg);
		        	if(modalfield == "#myModallinkservice"){
		        		var reqval = $('#DealServiceProviderUserId').val();
			        	$('#requested_val').val(reqval);
			        	
		        	}
		        	
		        	//serviceproviderlink();
		        	}else{
		        		//alert('hi');
		        		$(fname).submit();
		        		$(modalfield).modal('hide');
		        		
		        	}
		        	checkforLinkSubscriber();
		        	SubscriberClickCheck();
		        	link_autochecked();
		        	master_search();
		        	project_search();
		        	popupAlertForNewAccount();
		           //$("#thanks").html(msg)
		           //$("#myModal1").modal('hide');
		        },
		        error: function(){
		        		//alert("failure");
		        }
		    });
});
}


function existLinkServiceProviderCheck(passvalue,path,fieldId,fieldclass){ 
	var disb = $('#'+fieldId).val(); 
    	if(disb != ''){
    		if(passvalue == ''){
    			passvalue = disb;
    		}
		$.ajax({
	        url: Site_url + path +'/'+ passvalue,
	        type: "POST",
	        beforeSend: function() {
	            $('#wait-payment-process').show();
	        },
	        complete: function() {
	            $('#wait-payment-process').hide();
	        },
	        success: function(data) {
	        	checkSessionForAjax(data);
	        if(fieldclass!=''){
	        	if(data == '""'|| data == ''){
		           	$(fieldclass).val('');
		           	$('#DealServiceError').css('display', 'block');
		           }else {
		        	   $('#DealServiceError').css('display', 'none');
		        		   $(fieldclass).val(data);
		        		   $('#DealServiceProviderUserHidden').val(data);
		        		   $('.linkdetail').submit();
		           }
	        }
	        },
	        error: function(e) {
	       	 //alert(e.message);
	       		//called when there is an error
	       		//console.log(e.message);
	       	  },
	        statusCode: {
	            404: function() {
	                alert("page not found");
	            }
	        }
	    });
	}
}



function checkmanadatory_LinkService(path,fname,modalbody,modalfield){
	 $.ajax({
	        type: "POST",
	        url: Site_url + path,
	        beforeSend: function() {
	        	$('.unloading_link').css('display', 'none');
	        	$('.loading_link').css('display', 'block');
	        },
	        complete: function() {
	            $('.unloading_link').css('display', 'block');
	        	$('.loading_link').css('display', 'none');
	        },
	        data: $(fname).serialize(),
	        success: function(msg){
	        	checkSessionForAjax(msg);
	        	if(msg!=''){
	        	$(modalbody).html(msg);
	        	if(modalfield == "#myModallinkservice"){
	        		if($('#Dealvalidation').val() !== undefined && $('#Dealvalidation').val() != ''){
	        	    	var getId = $('#Dealvalidation').val();
	        	    	$('.userid_error').css('display', 'block');
	            		$(".user_error").css('display', 'block');
	            		$("#email-error").css('display', 'block');
	            		$('#'+getId).attr('placeholder','Request for new user pending');
	        	    }
//	        		var reqval = $('#DealServiceProviderUserId').val();
//		        	$('#requested_val').val(reqval);
//		        	$('#DealServiceProviderUserId').val('');
	        	}
	        	var clientroleVal = $('input[name="data[DealServiceProvider][client_role_id]"]:checked').val();
       		var ServiceroleVal = $('input[name="data[DealServiceProvider][service_provider_id]"]:checked').val();
	    		if(clientroleVal!==undefined && ServiceroleVal !== undefined){
	    			if(ServiceroleVal == 0 && ($('#DealServiceProviderType').val()!='' && $('#DealServiceProviderType').val()!==undefined)){
	    				$('.userid_error').css('display', 'block');
		        		$(".user_error").css('display', 'block');
		        		$("#email-error").css('display', 'block');
	    			}else if(ServiceroleVal != 0){
	    				$('.userid_error').css('display', 'block');
		        		$(".user_error").css('display', 'block');
		        		$("#email-error").css('display', 'block');
	    			}
	    		}
	        	
	        	
	        	//serviceproviderlink();
	        	}else{
	        		$('.userid_error').css('display', 'none');
	        		$(".user_error").css('display', 'none');
	        		$("#email-error").css('display', 'none');
	        	}
	        	checkforLinkSubscriber();
	        	SubscriberClickCheck();
	        	link_autochecked();
	        	master_search();
	        	project_search();
	        	popupAlertForNewAccount();
	           //$("#thanks").html(msg)
	           //$("#myModal1").modal('hide');
	        },
	        error: function(){
	        		//alert("failure");
	        }
	    });
}
function AgreementPlaceholderMsgLink(){
	if($('#agreementvalidation').val() !== undefined && $('#agreementvalidation').val() != ''){
    	var getId = $('#agreementvalidation').val();
    	$( "#"+getId ).closest( ".label-wrap" ).find('#email-error').css('display','block');
    	$( "#"+getId ).closest( ".label-wrap" ).find('.newAccount').css('display','block');
    	
    	
    	
    	$( "#"+getId ).closest( "tr" ).next('.userid_error').css('display','table-row');
    	$( "#"+getId ).closest( "tr" ).next('.userid_error').find('.newAccount').css('display','table-row');
    	$( "#"+getId ).closest( "tr" ).next('.userid_error').find('#email-error').css('display','table-row');
    	
    	
    		$('#'+getId).val('');
    		$('#'+getId).attr('placeholder','Request for new user pending');
    }
}

var busy = false;
var limit = 10;
var offset = 0;
var scrollOffset = 12;
 






function agreementEnter(){
	$('.checkuser').keypress(function(event) {
	    if (event.keyCode == 13) {
	        event.preventDefault();
	    }
	});
}
function numeric_currency_value(){
	$('#DefaultTextPspAccountFee').currency();
	$('#DefaultTextPspAccountFee').val($('#DefaultTextPspAccountFee').val().replace(/[^0-9\.]+/g,""));
	$('#DefaultTextPspRatePerDeal').currency();
	$('#DefaultTextPspRatePerDeal').val($('#DefaultTextPspRatePerDeal').val().replace(/[^0-9\.]+/g,""));
	$('#DefaultTextPspCostPerTransaction').currency();
	$('#DefaultTextPspCostPerTransaction').val($('#DefaultTextPspCostPerTransaction').val().replace(/[^0-9\.]+/g,""));
	$('#DefaultTextCurrentTrustAcCost').currency();
	$('#DefaultTextCurrentTrustAcCost').val($('#DefaultTextCurrentTrustAcCost').val().replace(/[^0-9\.]+/g,""));
	
	$('#DefaultTextCaAccountFee').currency();
	$('#DefaultTextCaAccountFee').val($('#DefaultTextCaAccountFee').val().replace(/[^0-9\.]+/g,""));
	
	$('#DefaultTextSaAccountFee').currency();
	$('#DefaultTextSaAccountFee').val($('#DefaultTextSaAccountFee').val().replace(/[^0-9\.]+/g,""));
	$('#DefaultTextSaCostPerTransaction').currency();
	$('#DefaultTextSaCostPerTransaction').val($('#DefaultTextSaCostPerTransaction').val().replace(/[^0-9\.]+/g,""));
	
	$('#DefaultTextSaRatePerDeal').currency();
	$('#DefaultTextSaRatePerDeal').val($('#DefaultTextSaRatePerDeal').val().replace(/[^0-9\.]+/g,""));
	$('#DefaultTextSaCostPerTransactionSa').currency();
	$('#DefaultTextSaCostPerTransactionSa').val($('#DefaultTextSaCostPerTransactionSa').val().replace(/[^0-9\.]+/g,""));
	$('#DefaultTextSaAvgDepositAmt').currency();
	$('#DefaultTextSaAvgDepositAmt').val($('#DefaultTextSaAvgDepositAmt').val().replace(/[^0-9\.]+/g,""));
	
	
}
// for ipad
$(document).ready(function(){
	$('form').click(function(event){
		   event.stopPropagation();
	});
	$('.annex_attch_link').click(function() {
		if($(this).html() == "Attach to agreement") {
			var annexid = $(this).next("input[name='data[Agreement][annex_id]']").val();
			$('#AgreementAnnexureId').val(annexid);
			$('.annex_attch_link').html("Attach to agreement");
			$(this).html("Unattach from agreement");
			$('.annex_attch_link').parents('tr').css('background','#fff');
			$(this).parents('tr').css('background','#B0C4DE');
	  	}
		else {
			$('.annex_attch_link').html("Attach to agreement");
			$('.annex_attch_link').parents('tr').css('background','#fff');
			$('#AgreementAnnexureId').val('');
		}
		return false;
	});
	
	$('.annextable .trustdetail').css('display','none');
	$('.linktrust_ac').closest(".annextable").children('thead').children('tr').css('border-bottom','0px');
	$('.linktrust_ac').click(function(){
		/*$('#annextable tbody').css('display','none');
		$(this).closest("#annextable tbody").css('display','block');*/
		$(this).closest(".annextable").children('tbody').toggle();
		if($(this).closest(".annextable").children('tbody').css('display')=='none'){
			$(this).closest(".annextable").children('thead').children('tr').css('border-bottom','0px');
		}else{
			$(this).closest(".annextable").children('thead').children('tr').css('border-bottom','1px solid #eee');
		}
		
	});
});

(function($) {
    $.fn.hasScrollBar = function() {
        return this.get(0).scrollHeight > this.height()+24; //for padding top and bottom
    }
})(jQuery);



