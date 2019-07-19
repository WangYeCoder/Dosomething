<?php
/**
 * Author: Tierney
 * Date: 12/10/15 - 11:09
 */

namespace Home\Model;

use Think\Model;

class AppModel extends Model
{
    protected $limit = 100;
    protected $Model = null;

    public function __construct()
    {
        parent::__construct();
        if (!empty($this->trueTableName)) {
            $this->Model = M($this->trueTableName);
        }
    }

    public function getAreaByID($id)
    {
        return $this->getFindByCondition(array("id" => $id));
    }

    public function getFindByCondition(array $condition = array(), $fields = '')
    {
        return $this->Model->field($fields)->where($condition)->find();
    }

    public function getCountByCondition(array $condition = array())
    {
        return $this->Model->where($condition)->count();
    }

    public function getListByCondition(array $condition = array(), $order = '')
    {
        return $this->Model->where($condition)->order($order)->select();
    }

    public function getListByConditionLimit(array $condition, $limit)
    {
        return $this->Model->where($condition)->limit($limit)->select();
    }

    public function getListFieldByCondition($fields, array $condition)
    {
        return $this->Model->field($fields)->where($condition)->select();
    }

    public function getGroupAndFieldsByCondition($fields, $condition, $group)
    {
        return $this->Model->field($fields)->where($condition)->group($group)->select();
    }

    public function doAdd($data)
    {
        return $this->Model->add($data);
    }

    public function doDelete(array $condition = array())
    {
        return $this->Model->where($condition)->delete();
    }

    public function doDeleteById($id)
    {
        return $this->Model->delete($id);
    }

    public function updateById($id, $data)
    {
        $where = array('id' => $id);

        return $this->doUpdate($where, $data);
    }

    public function doUpdate($where, $data)
    {
        return $this->Model->where($where)->save($data);
    }

    public function sqlqurey($sql)
    {
        return $this->Model->query($sql);
    }

    public function addAction($data)
    {
        $data['createon'] = timenow();

        return $this->Model->data($data)->add();
    }

    public function getGroupByCondition($condition, $group = "")
    {
        return $this->Model->where($condition)->group($group)->select();
    }

    public function truncateTable()
    {
        $sql = "TRUNCATE TABLE `{$this->trueTableName}`";

        return $this->Model->execute($sql);
    }

    public function getFieldsListByConditionLimit($fields, $condition, $limit, $order = "")
    {
        return $this->Model->field($fields)->where($condition)->order($order)->limit($limit)->select();
    }

    public function insertNotNull($data)
    {
        return $this->Model->add(dbInsertClearNull($data));
    }

    public function getFieldsAndGroupByCondition($fields, $condition, $group = "")
    {
        return $this->Model->field($fields)->where($condition)->group($group)->select();
    }

}