<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
      $m_conn = M('List');
      $result = $m_conn->select();
      
      $this->assign('user_result', $result);

      //$result_1 = $m_conn->where("`id` > 3 AND (`name` NOT LIKE '%abc%' AND sex LIKE '%an%')")->select();

      $result_1 = $m_conn->avg('id');
      var_dump($result_1);
      $this->display();
    }

    public function modify(){
      //$this->display('Single:index');
      // $Single = A('Single');
      // $Single->index();
      //throw_exception('这里是一个错误');
      //return;

      $id = isset($_GET['id']) ? $_GET['id'] : '';
      $m_conn = M('List');
      if( isset($_POST['name']) && isset($_POST['sex']) && isset($_POST['age']) && isset($_POST['local'])) {
        $updata_arr = array(
            'id'    =>  $id,
            'name'  =>  $_POST['name'],
            'sex'   =>  ($_POST['sex']==1) ? 'nan' : 'nv',
            'age'   =>  $_POST['age'],
            'local' =>  $_POST['local'],
          );
        if($m_conn->save($updata_arr)) {
          $this->success('保存成功', '/thinkphp/index.php/Index/index');
          return;
        } else {
          $this->error('保存失败！');
        }
      }  
      $result = $m_conn->WHERE("id={$id}")->find();
      $this->assign('result', $result);
      $this->display();
    }
    
    function jump_to( ){
    	$this->display('Index:index');
    }
   	// function good(){
   	// 	//$m_conn = new Model('list');
   	// 	$m_conn = M('list');
   	// 	//
   	// 	//var_dump($m_conn->where('id=2')->getField('name'));

   	// 	// $m_conn->name = '谌超逸';
   	// 	// $m_conn->add();
   	// 	// $result = $m_conn->select();
   	// 	// var_dump($result);
   	// 	//$name = '谌超逸';
   	// 	//$this->assign('name',$result);
   	// 	//$m_conn->WHERE('name="谌超逸"')->delete();
   	// 	// $data = array('id'=>10,'name'=>'谌超逸','sex'=>'hah','local'=>'guiling','age'=>'159');
   	// 	// $m_conn->save($data);

   	// 	$m_conn->name = 'raojianbo';
   	// 	$m_conn->add(10);
   	// 	$result = $m_conn->select();
   	// 	var_dump($result);
   	// 	$this->display();
   	// }
}