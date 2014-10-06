<?php
/**
 * @name SampleModel
 * @desc sample数据获取类, 可以访问数据库，文件，其它系统等
 * @author {&$AUTHOR&}
 */
class SampleModel extends Orm_Base
{
    public $tablename = 'Sample';
	public $pk = 'itemid';
	public $field = array(
		'itemid' => array('type' => 'int', 'comment' => '自增主键')
	);
}
