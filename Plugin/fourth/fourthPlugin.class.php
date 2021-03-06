<?php

import('Class.Plugin', APP_PATH);

/**
 * 第四个插件插件
 * @author 44
 */

    class fourthPlugin extends Plugin{

        public $info = array(
            'name'=>'fourth',
            'title'=>'第四个插件',
            'description'=>' 撒地方',
            'status'=>1,
            'author'=>'44',
            'version'=>'33'
        );
		
        public $admin_list = array(
            'model'=>'Example',			//要查的表
			'fields'=>'*',				//要查的字段
			'map'=>'',					//查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
			'order'=>'id desc',			//排序,
			'listKey'=>array( 			//这里定义的是除了id序号外的表格里字段显示的表头名
					'字段名'=>'表头显示名'
				),
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的pageHeader钩子方法
        public function pageHeader($param){

        }

    }