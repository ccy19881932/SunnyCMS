
//应该设计为 ： 1.处理控制器方法url  2. 传入的参数，json格式  3.在那个html的id中展示 ID
function ajax_show_content ( url ) {
        $.ajax({
                //data : {'type' : type},
                url : url,
                type : 'post',
                timeout : 0,
                success : function(response){
                	if(response.status == 1) {
                		titlehtml = response.info;
                		innerhtml = '<p>'+ response.data +'</p>';
                		$('#right-title').html(titlehtml);
                		$('#right-contents').html(innerhtml);
                	}         
                },
                error: function(request) {
                        alert('出错啦...');
                }
	});
}

function ajax_form_submit ( url , id ) {
        $.ajax({
                cache: true,
                type: "POST",
                url:url,
                data:$('#'+id).serialize(),// 你的formid
                async: false,
                error: function(request) {
                        alert('出错啦...');
                },
                success: function(data) {
                    $("#preshow").html(data);
                }
        });

}

function ajax_handle_avg( url, avg) {
        $.ajax({
                data : {'avg' : avg},
                url : url,
                type : 'post',
                timeout : 0,
                success : function(response){
                    if(response.status == 1) {
                        titlehtml = response.info;
                        innerhtml = '<p>'+ response.data +'</p>';
                        $('#right-title').html(titlehtml);
                        $('#right-contents').html(innerhtml);
                    }         
                },
                error: function(request) {
                        alert('出错啦...');
                }
    });
}

function ajax_show_content_2 ( url, avg) {
        $.ajax({
                data : {'avg' : avg},
                url : url,
                type : 'post',
                timeout : 0,
                success : function(response){
                    if(response.status == 1) {
                        titlehtml = response.info;
                        innerhtml = '<p>'+ response.data +'</p>';
                        $('#right-sub-contents').html(innerhtml);
                    }         
                },
                error: function(request) {
                        alert('出错啦...');
                }
    });
}