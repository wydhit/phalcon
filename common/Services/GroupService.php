<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-31
 * Time: 8:39
 */

namespace Common\Services;


use Common\Models\WeGroup;
use Common\Services\BaseService;

class GroupService extends BaseService
{
    /**
     * 获取所有用户组
     * @return mixed
     */
    public function getGicList()
    {
        return $this->builder->from('Common\Models\WeGroup')
            ->columns('id,ic,title')
            ->where('mytype=group')->getQuery()->execute();
    }

    /**
     * 以数组的形式返回所有可用的gic
     * @return array
     */
    public function getAllGic()
    {
        $allGic = $this->getGicList();
        $gicArray = [];
        foreach ($allGic as $gic) {
            $gicArray[] = $gic['ic'];
        }
        return $gicArray;
    }

    /**
     * 根据ic找到对应的id
     * @param string $ic
     * @return int
     */
    public function getIdByIc($ic = '')
    {
        $res = WeGroup::findFirst(['ic=:ic:', 'columns' => 'id', 'bind' => ['ic' => $ic]]);
        if ($res) {
            return $res->id;
        } else {
            return 0;
        }
    }

    /**
     * 检查用户组名是否存在
     * @param string $u_gic
     * @return bool 存在返回 存在返回true 不存在返回false
     */
    public function GicIsExist($u_gic)
    {
        if (empty($u_gic)) return false;

        $count = WeGroup::count([
            'conditions' => 'ic=:u_gic: and mytype="group" ',
            'bind' => ['u_gic' => $u_gic]
        ]);

        return empty($count) ? false : true;
    }

    public function roleicIsExist($u_roleic = '', $u_gic = '')
    {
        if (empty($u_roleic)) return false;
        $conditions = 'ic=:u_roleic:';
        $bind = ['u_roleic' => $u_roleic];
        if ($u_gic) {
            $gicId = $this->getIdByIc($u_gic);
            $conditions .= ' and pid=' . $gicId;
        }
        $count = WeGroup::count([
            'conditions' => $conditions,
            'bind' => $bind
        ]);
        return empty($count) ? false : true;
    }

    /**
     * 返回某用户组下的所有角色
     * @param string $groupIc
     * @return array
     */
    public function getRoleicByGroupIc($groupIc = '', $isuse = true)
    {
        $groupId = $this->getIdByIc($groupIc);
        $where = 'pid=' . $groupId;
        if ($isuse) {
            $where .= ' and isuse=1';
        }
        $list = WeGroup::find($where);
        if ($list) {
            return $list->toArray();
        } else {
            return [];
        }
    }
    /**
     * 返回某用户组下的所有角色 ['sale','agent'] 只是单纯的角色名组成的数组
     * @param string $groupIc
     * @return array
     */
    public function getRoleicListByGroupIc($groupIc = '', $isuse = true)
    {
        $res=[];
        foreach ($this->getRoleicByGroupIc($groupIc,$isuse) as $item) {
            $res[]=$item['ic'];
        }
        return $res;
        
    }


}