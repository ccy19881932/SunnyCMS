<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/style.css" />
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<!--    <script type="text/javascript" src="__PUBLIC__/Js/jquery.sorted.js"></script>-->
    <script type="text/javascript" src="__PUBLIC__/Js/bootstrap.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/ckform.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>

 

    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<body>

<form class="form-inline definewidth m20" action="index.html" method="get">    
    用户名称：
    <input type="text" name="username" id="search_username"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" data-target="#add" data-toggle="modal">新增分类</button>
    <!-- <a href="#myModal" role="button" class="btn" data-toggle="modal">查看演示案例</a> -->
</form>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th>分类id</th>
        <th>分类名称</th>
        <th>分类别名</th>
        <th>操作</th>
    </tr>
    </thead>
        <?php if(is_array($terms)): foreach($terms as $key=>$term): ?><tr>
                <td><?php echo ($term["term_id"]); ?></td>
                <td><label for="term-<?php echo ($term["term_id"]); ?>"><?php echo ($term["html"]); ?><input type="checkbox" id="term-<?php echo ($term["term_id"]); ?>" name="<?php echo ($term["slug"]); ?>"><?php echo ($term["name"]); ?></label></td>
                <td><?php echo ($term["slug"]); ?></td>
                <td>
                    <a href="<?php echo U(GROUP_NAME.'/Term/edit',array('pid'=>$term['term_id'],'parent'=>$term['parent'],'name'=>$term['name'],'slug'=>$term['slug']));?>" class="btn btn-success btn-small">编辑</a>
                    <a href="<?php echo U(GROUP_NAME.'/Term/delTerm',array('pid'=>$term['term_id']));?>" class="btn btn-warning btn-small" onclick="return confirm('确定删除此分类?')">删除</a>
                </td>
            </tr><?php endforeach; endif; ?>

    <tr>
        <td colspan="4">
                <div class="pagination pagination-centered">
                    <ul><?php echo ($page); ?></ul>
                </div>
        </td>
    </tr>
</table>

<!-- Modal -->
<div id="add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">新增分类</h3>
    </div>
    <form method="post" class="definewidth m20" id="form_add_term">
        <div class="modal-body">
            <table class="table table-bordered table-hover definewidth m10">
                <tr>
                    <td width="20%" class="tableleft">选择父类</td>
                    <td>
                        <select name="term_parent" id="term_parent">
                            <option value="0" selected>无</option>
                        <?php if(is_array($terms)): foreach($terms as $key=>$term): ?><option value="<?php echo ($term["term_id"]); ?>"><?php echo ($term['html']); echo ($term["name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="tableleft">分类名称</td>
                    <td><input type="text" name="term_name"/></td>
                </tr>
                <tr>
                    <td class="tableleft">分类别名</td>
                    <td>
                        <input type="text" name="term_slug" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" type="button" id="form_submit">保存</button>&nbsp;&nbsp;<button type="button" class="btn" data-dismiss="modal" aria-hidden="true" id="close_model">关闭</button>
        </div>
    </form>
</div>

</body>
</html>
<script>
    $(function () {
        // 显示模态窗口
        $('#add').on('show', function () {
            // 动态加载js文件
            $.getScript("http://malsup.github.com/jquery.form.js",function(){
                $.getScript("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js",function(){
                        // 表单验证
                       $("#form_add_term").validate({
                            event: 'blur',
                            rules: {
                                term_name: {
                                    required: true,
                                },
                                term_slug: {
                                    required: true,
                                }
                                
                            },
                            messages: {
                                term_name: {
                                    required: '分类名称不可为空',
                                },
                                term_slug: {
                                    required: '分类别名不可为空',
                                },     
                            },
                            submitHandler: function(form) { 
                                $(form).ajaxSubmit({
                                    type:"post",
                                    url:"<?php echo U(GROUP_NAME.'/Term/addTerm');?>",
                                    success: function(data){
                                        if(data){
                                            $("#form_submit").removeAttr('disabled').text('添加');
                                            $('#close_model').click();
                                           window.location.reload();
                                        }else{
                                            alert('添加失败');
                                            $("#form_submit").removeAttr('disabled').text('添加');
                                        }
                                    },
                                    error: function(){
                                        alert('服务器繁忙，请稍后');
                                        $("#form_submit").removeAttr('disabled').text('添加');
                                    },
                                    beforeSubmit: function(){
                                        $("#form_submit").attr('disabled','disabled').text('添加中...');
                                    }
                                });
                                return false;
                            },
                            debug: true, 
                        });//验证结束
                });
            });
        });
        
    });
	function del(id)
	{	
		if(confirm("确定要删除吗？"))
		{
		
			var url = "index.html";
			
			window.location.href=url;		
		
		}
	}
</script>