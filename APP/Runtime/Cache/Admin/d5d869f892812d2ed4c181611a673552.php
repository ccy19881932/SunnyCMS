<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE HTML>
<html>
 <head>
  <title>后台管理系统</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="__PUBLIC__/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="__PUBLIC__/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="__PUBLIC__/assets/css/main-min.css" rel="stylesheet" type="text/css" />
 </head>
 <body>

  <div class="header">
    
      <div class="dl-title">
       <!--<img src="/chinapost/Public/__PUBLIC__/assets/img/top.png">-->
      </div>

    <div class="dl-log">欢迎您，<span class="dl-log-user">root</span><a href="<?php echo U(GROUP_NAME.'/Login/logout');?>" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
        		<li class="nav-item dl-selected"><div class="nav-item-inner nav-home">系统管理</div></li><li class="nav-item dl-selected"><div class="nav-item-inner nav-order">业务管理</div></li><li class="nav-item dl-selected"><div class="nav-item-inner nav-order">文章管理</div></li><li class="nav-item dl-selected"><div class="nav-item-inner nav-order">插件管理</div></li> 

      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>
  <script type="text/javascript" src="__PUBLIC__/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/assets/js/bui-min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/assets/js/common/main-min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/assets/js/config-min.js"></script>
  <script>
    var jigouguanli_url     = '<?php echo U(GROUP_NAME."/Node/index");?>';
    var role_manage_url     = '<?php echo U(GROUP_NAME."/Role/index");?>';
    var user_manage_url     = '<?php echo U(GROUP_NAME."/User/index");?>';
    var menu_manage_url     = '<?php echo U(GROUP_NAME."/Menu/index");?>';
    var term_manage_url     = '<?php echo U(GROUP_NAME."/Term/index");?>';
    var post_manage_url     = '<?php echo U(GROUP_NAME."/Post/index");?>';
    var newPost_manage_url  = '<?php echo U(GROUP_NAME."/Post/newPost");?>';
    var plugin_manage_url   = '<?php echo U(GROUP_NAME."/Plugin/index");?>';
    var create_plugin_url   = '<?php echo U(GROUP_NAME."/Plugin/create");?>';
    var tags_manage_url     = '<?php echo U(GROUP_NAME."/Post/Tags");?>';
    
    BUI.use('common/main',function(){
      var config = [
        {
          id:'1',
          menu:[{
            text:'系统管理',
            items:[
                    {id:'2',text:'机构管理',href:jigouguanli_url},
                    {id:'3',text:'分类管理',href:term_manage_url},
                    {id:'4',text:'角色管理',href:role_manage_url},
                    {id:'5',text:'用户管理',href:user_manage_url},
                    {id:'6',text:'菜单管理',href:menu_manage_url}
                  ]
          }]
        },{
          id:'11',
          homePage : '12',
          menu:[{
                   text:'业务管理',
                   items:[{id:'12',text:'查询业务',href:'Node/index.html'}]
               }]
        },{
          id:'21',
          homePage : '22',
          menu:[{
                   text:'文章管理',
                   items:[
                      {id:'22',text:'所有文章',href:post_manage_url},
                      {id:'23',text:'撰写文章',href:newPost_manage_url},
                      {id:'24',text:'分类目录',href:term_manage_url},
                      {id:'25',text:'标签管理',href:tags_manage_url},
                    ]
               }]
        },{
          id:'31',
          homePage : '32',
          menu:[{
                   text:'插件管理',
                   items:[
                      {id:'32',text:'所有插件',href:plugin_manage_url},
                      {id:'33',text:'创建插件',href:create_plugin_url},
                    ]
               }]
        }
      ];
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
 </body>
</html>