$(document).ready(function(){
    if($("#successid").val()==200){
        loginSuccess();
    }else if($("#successid").val()==401){
        actionFailed();
    }else{

    }

    dailySaleChart();

});
//success function
loginSuccess = () => {
$.toastr.success('Success.', {
    time: 6000,
    position:'top-right',
    size:'',
    callback:function () {}
});
}
//error function
actionFailed = () => {
$.toastr.error('Credentials Mismatch !', {
    time: 6000,
    position:'top-right',
    size:'',
    callback:function () {}
});
}
//validation error function
actionError = (key) => {
    $.toastr.error(key+' Required !', {
        time: 4000,
        position:'top-right',
        size:'',
        callback:function () {}
    });
}
//search current stock
searchCurrentStock = () => {
    var datetime = $("input[name='datetime']").val();
    var todatetime = $("input[name='todatetime']").val();
    var outletName = $("select[name='outletName']").val();
    var itemName = $("select[name='itemName']").val();
    //validation
    if(datetime == null){
        actionError('From Date');
        return;
    }
    if(todatetime < datetime){
        actionError('Valid Date');
        return;
    }
    if(outletName == null){
        actionError('Outlet');
        return;
    }
    //call ajax
    $.ajax({
        type:'GET',
        url:'/search-stock',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            'datetime':datetime,
            'todatetime':todatetime,
            'outlet':outletName,
            'item':itemName,
        },
        datatype:'JSON',
        beforeSend:function(){
            $(".display-current-stock").html('<div class="p-5 mt-5 mb-5 " ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
        },
        success:function(data){
            //console.log(data);
            var html = '';
            if(data.datas.length < 1){
                html += 'No Data Found !';
                $(".display-current-stock").html(html);
            }else{
                html+='<table class="table table-striped text-center">';
                html+='<thead>';
                html+='<tr class="table-primary">';
                html+='<th width="15%"><label for=""> Date </label></th>';
                html+=' <th width="25%"><label for=""> Outlet Name </label></th>';
                html+='<th width="30%"><label for=""> Item Name </label></th>';
                html+='<th width="10%"><label for=""> Stock </label></th>';
                html+=' <th width="10%"><label for=""> Sale </label></th>';
                html+='<th width="20%"><label for=""> Last Stock </label></th>';
                html+='</tr></thead>';
                html+='<tbody>';
                for(var i = 0;i<data.datas.length;i++){
                    var arrayData = data.datas[i];
                    var lastStock = parseInt(arrayData.stock-arrayData.sale);
                    html+='<tr>';
                    html+='<td>'+arrayData.date+'</td>';
                    html+='<td>'+arrayData.outlet+'</td>';
                    html+='<td>'+arrayData.item+'</td>';
                    html+='<td>'+arrayData.stock+'</td>';
                    html+='<td>'+arrayData.sale+'</td>';
                    if(lastStock > 0){
                        html+='<td>'+lastStock+'</td>';
                    }else{
                        html+='<td><p class="bg-danger">'+lastStock+'</p></td>';
                    }
                    html+='</tr>';
                }
                html+='</tbody></table>';
                $(".display-current-stock").html(html);
            }
        }

    });
}
//alert message search
searchAlertMessage = () => {
    var datetime = $("input[name='datetime']").val();
    var outletName = $("select[name='outletName']").val();
    var itemName = $("select[name='itemName']").val();
    //validation
    if(datetime == null){
        actionError('Date');
        return;
    }
    // call ajax
    $.ajax({
        type:'GET',
        url:'/search-message',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            'datetime':datetime,
            'outlet':outletName,
            'item':itemName,
        },
        datatype:'JSON',
        beforeSend:function(){
            $(".display-alert-message").html('<div class="p-5 mt-5 mb-5 " ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
        },
        success:function(data){
            console.log(data);
            var html = '';
            if(data.datas.length < 1){
                html += 'No Message Found !';
                $(".display-alert-message").html(html);
            }else{
                var html = '';
                for(var i=0;i<data.datas.length;i++){
                    let arrayData = data.datas[i];
                    html += '<div class="alert alert-success">'+arrayData.message+' at '+arrayData.time+'</div>'
                }
                $(".display-alert-message").html(html);
            }
        }

    });
}
//add alert receiver
$("#addAlertReceiver").on('submit',function(e){
    e.preventDefault();
    var form = $("#addAlertReceiver");
    $.ajax({
        type:'POST',
        url:'/store/alert-receiver',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:form.serialize(),
        datatype:'JSON',
        beforeSend:function(){
            $(".addreceiver-submit-btn").css({'display':'none'})
            $(".display-add-receiver").css({'display':'block'})
        },
        success:function(data){
            console.log(data);
            if(data.status=='success'){
                $(".close-modal").click();
                window.location.reload();
            }else{
                actionError('Error');
            }
        }
    });
});
//open modal
openReceiverEditModal = (id) => {
    $.ajax({
        type:'POST',
        url:'/edit/alert-receiver',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{id:id},
        datatype:'JSON',
        success:function(data){
            var outletHttml = '';
            outletHttml+='<option selected disabled value="">Select Outlet</option>';
            for(var i=0;i<data.outlets.length;i++){
                if(data.outlets[i].outlet_name == data.data.outlet){
                    outletHttml+= '<option selected value='+data.outlets[i].outlet_name+'>'+data.outlets[i].outlet_name+'</option>'
                }else{
                    outletHttml+= '<option value='+data.outlets[i].outlet_name+'>'+data.outlets[i].outlet_name+'</option>'
                }
            }
            var statusHtml = '';
            statusHtml+='<option selected disabled value="">Select</option>'
            if(data.data.status == 1){
                statusHtml+='<option selected value="1">Enable</option>';
                statusHtml+='<option value="0">Disable</option>';
            }else{
                statusHtml+='<option value="1">Enable</option>';
                statusHtml+='<option selected value="0">Disable</option>';
            }
            $("#rec-outlet").html(outletHttml);
            $("#rec-name").val(data.data.name);
            $("#rec-number").val(data.data.number);
            $("#rec-status").html(statusHtml);
            $("#rec-id-hidden").val(data.data.id)
            $("#exampleModalCenter").modal('show');
        }
    });

}
// close modal
recModalClose = () => {
    $("#exampleModalCenter").modal('hide');
}

//add alert receiver
$("#editAlertReceiver").on('submit',function(e){
    e.preventDefault();
    var form = $("#editAlertReceiver");
    $.ajax({
        type:'POST',
        url:'/edit-store/alert-receiver',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:form.serialize(),
        datatype:'JSON',
        beforeSend:function(){
            $(".editreceiver-submit-btn").css({'display':'none'})
            $(".display-edit-receiver").css({'display':'block'})
        },
        success:function(data){
            console.log(data);
            if(data.status=='success'){
                $("#exampleModalCenter").modal('hide');
                window.location.reload();
            }else{
                actionError('Error');
            }
        },
        error:function(data){
            console.log(data);
        }
    });
});
//for alert configurations
manageAlertMessage = (id) => {

    //data check box value control
    if($('#checkBoxInput'+id).prop("checked") == true){
        $('#checkBoxInput'+id).val(1);
    }
    else if($('#checkBoxInput'+id).prop("checked") == false){
        $('#checkBoxInput'+id).val(0);
    }
    //call to variable
    var checkBoxInput=$('#checkBoxInput'+id).val();
    var time = $("#cutoff_time"+id).val();
    var qty = $("#cutoff_qty"+id).val();


    //ajax function
    $.ajax({
        url:"/update/message-option",
        type:"get",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            id:id,
            time:time,
            qty:qty,
            checkBoxInput:checkBoxInput
        },
        datatype:"JSON",
        beforeSend:function(){
            //call to loader
            $("#loaders2").html('<div id="loader" data-wordLoad="Updating..."></div>');
        },
        success:function(data){
            console.log(data);
            if(data.status=='success'){
                //data loading timeout
                setTimeout(function() {
                    updateLoader();
                },1300);
                function updateLoader() {
                    $("#loader").fadeOut("slow");
                }
                //switch control
                // if(data.switch==1){
                //     $(".switch-control"+id).html(' <span class="badge badge-sm bg-gradient-success">ON</span>');
                // }else{
                //     $(".switch-control"+id).html(' <span class="badge badge-sm bg-gradient-secondary">OFF</span>');
                // }
            }
        }

    });
}
alertRecieverDisable = (id) => {
    //ajax function
    $.ajax({
        url:"/alert/receiver-disable",
        type:"get",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            id:id,
        },
        datatype:"JSON",
        beforeSend:function(){
            //call to loader
            $("#loaders2").html('<div id="loader" data-wordLoad="Updating..."></div>');
        },
        success:function(data){
            if(data.status=='success'){
                //data loading timeout
                setTimeout(function() {
                    updateLoader();
                },1300);
                function updateLoader() {
                    $("#loader").fadeOut("slow");
                }
                window.location.reload();
            }
        }

    });
}
alertRecieverEnable = (id) => {
    //ajax function
    $.ajax({
        url:"/alert/receiver-enable",
        type:"get",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            id:id,
        },
        datatype:"JSON",
        beforeSend:function(){
            //call to loader
            $("#loaders2").html('<div id="loader" data-wordLoad="Updating..."></div>');
        },
        success:function(data){
            if(data.status=='success'){
                //data loading timeout
                setTimeout(function() {
                    updateLoader();
                },1300);
                function updateLoader() {
                    $("#loader").fadeOut("slow");
                }
                window.location.reload();
            }
        }

    });
}
function ajaxCallForSMS() {
    $.ajax({
    url:"/api/store-alert",
    type:"get",
    //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data:{
    },
    datatype:"JSON",
    success:function(data){
        console.log(data);
    },
    }).always(function() {
        setTimeout(ajaxCallForSMS, 60000); // 6 sec
    });
}
ajaxCallForSMS();
function ajaxCallForSMSStore() {
    $.ajax({
    url:"/api/store-alert2",
    type:"get",
    //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data:{
    },
    datatype:"JSON",
    success:function(data){
        console.log(data);
    },
    }).always(function() {
        setTimeout(ajaxCallForSMSStore, 60000); // 6 sec
    });
}
ajaxCallForSMSStore();
//send message function call//
// function itemQuantityFromApi(){
//     $.ajax({
//         url:"/item-stock",
//         type:"get",
//         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//         data:{
//         },
//         datatype:"JSON",
//         success:function(data){
//             console.log(data);
//         },
//     }).always(function() {
//         setTimeout(itemQuantityFromApi, 86400000);
//     })
// }
// itemQuantityFromApi();
