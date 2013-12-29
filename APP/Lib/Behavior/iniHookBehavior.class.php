<?php 
    class iniHookBehavior extends Behavior {
        // 行为扩展的执行入口必须是run
        public function run(&$contents){
        	import('Class.Hook', APP_PATH);
			if(isset($_GET['m']) && $_GET['m'] === 'Install') return;
	        $data = S('hooks');
	        if(!$data){
	            $hooks = M('Hooks')->getField('name,plugins');
	            foreach ($hooks as $key => $value) {
	                if($value){
	                    $map['status']  =   1;
	                    $names          =   explode(',',$value);
	                    $map['name']    =   array('IN',$names);
	                    $data = M('Plugin')->where($map)->getField('id,name');
	                    if($data){
	                        $plugins = array_intersect($names, $data);
	                        Hook::add($key,$plugins);
	                    }
	                }
	            }
	            S('hooks',Hook::get());
	        }else{
	            Hook::import($data,false);
	        }
        }

    }

?>