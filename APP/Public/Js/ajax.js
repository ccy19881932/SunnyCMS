
//应该设计为 ： 1.处理控制器方法url  2. 传入的参数，json格式  3.在那个html的id中展示 ID 4.需要刷新页面的等待时间
function ajax_handle ( url, data, showID, refresh = 1000 ) {
    $.ajax({
            data : {'data' : data},
            url : url,
            type : 'post',
            timeout : 0,
            success : function(response){
                titlehtml = response.info;
                if(showID == 'alert'){
                    switchAlert( response.status, titlehtml, refresh );      
                } else {
                    $('#' + showID).html(titlehtml); 
                }   
            },
            error: function(request) {
                    alert('出错啦...');
            }
    });
}
function refresh() 
{ 
    window.location.reload(); 
} 

function switchAlert ( status, msg, refresh ) {
    $('#AlertMsg').html(msg); 
    $('#alert').removeClass();
    if( status ) {
        $('#alert').addClass('success alert-success');
        $('#alert').css('display','block');
    } else {
        $('#alert').addClass('error alert-error');
        $('#alert').css('display','block');
    } 
    if( refresh >= 0 ){
        setTimeout("refresh()",refresh);
    } else if( refresh == -1 ) {
        setTimeout("closeAlert()",1500);
    }
}

function closeAlert () {
    $('#alert').css('display','none');
}

function ajaxFormHandle ( form_id, showID, other = '' ) {
    var options = { 
        success:function(response){
            titlehtml = response.info;
            otherhtml = response.other;
            if(showID == 'alert'){
                switchAlert( response.status, titlehtml, -1 );      
            } else {
                $('#' + showID).html(titlehtml); 
            }  
            if(other != '' && response.status == 1){
                $('#pluginID').val(otherhtml);
                $('#'+other).click();
            }
        },
        //target:        '#output1',   // target element(s) to be updated with server response 
        //beforeSubmit:  showRequest,  // pre-submit callback 
        //success:       showResponse,  // post-submit callback 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true,        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
    $( '#'+form_id ).ajaxForm(options); 
}