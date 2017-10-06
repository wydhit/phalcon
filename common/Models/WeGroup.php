<?php

namespace Common\Models;

class WeGroup extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;
    public $title;
    public $cls;
    public $issys;/*系统组禁止删除*/
    public $upset;/*暂时没用*/
    public $countuser;/*这个组的用户数*/
    public $isuse;
    public $typeid;/*0=用户组; 1=管理组*/
    public $typename;
    public $mytype;/*类型，用户组还是用户角色*/
    public $countson;/*下级的角色数量*/
    public $pid;
    public $access_id;/*操作权限id*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_group';
    }

    /**
     * @param mixed $parameters
     * @return WeGroup[]|WeGroup|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeGroup|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * 通过用户组或者角色ic获取对应的名称
     * @param string $ic ic
     * @param string $u_gic  获取角色名的时候可以指定用户组ic
     * @return string
     */
    public static function getTitleByIc($ic='',$u_gic='')
    {
        if(empty($ic)){
            return '';
        }
        if($ic==='sys') {
            return '系统';
        }
        $where="ic='$ic'";
        if(!empty($u_gic)){
            $gicInfo=WeGroup::findFirst(["ic='$u_gic'"]);
            if(empty($gicInfo)){
                return '';
            }
            $where.=" and pid = ".$gicInfo->id;
        }
        $groupInfo = WeGroup::findFirst([$where, 'columns' => 'title']);
        if($groupInfo){
            return $groupInfo['title'];
        }else{
            return '';
        }
    }


}