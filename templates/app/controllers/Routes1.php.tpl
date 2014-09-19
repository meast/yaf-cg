<?php
/**
 * @name Routes1Controller
 * @author {&$AUTHOR&}
 * @desc Routes1控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 * charset:utf-8
 */
class Routes1Controller extends Ctrl_Base {
	public function init()
	{
		Yaf_Dispatcher::getInstance() -> autoRender(false);
	}
	
	public function indexAction()
	{
		$id = $this -> getRequest() -> getParam('id1','id1 is not set yet');
		echo $id;
	}
	
	public function index1Action()
	{
		$id = $this -> getRequest() -> getParam('id2','id2 is not set yet');
		echo $id;
	}
}
