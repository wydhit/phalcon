<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-08
 * Time: 16:15
 */

namespace Agent\Search;


use Common\Helpers\StringHelper;
use Common\Models\WeUser;
use Common\Search\BaseSearch;

class ComUserSearch extends BaseSearch
{
    public function getComUserByAgent($agentId = 0)
    {
        $this->builder->from(['user' => WeUser::class])
            ->columns([
                'user.id',
                'user.u_name',
                'user.u_fullname',
                'user.u_nick',
                'user.ischeck',
                'user.islock',
            ]);
        $this->searchNoDel();
        $this->searchBelongAgent($agentId);
        $this->order("user.$this->sidx $this->sord");   /*处理排序*/
        return $this->returnPaginatorResponse(function ($data){
            $data->ischeckTips=WeUser::getIscheckTips($data->ischeck);
            $data->islockTips=WeUser::getIslockTips($data->islock);
            return $data;
        });
    }

    protected function searchBelongAgent($agentId = 0)
    {
        if ($agentId) {
            $this->builder->andWhere('user.agentid=:agentid:', ['agentid' => $agentId]);
        }
    }

    protected function searchNoDel()
    {
        $this->builder->andWhere('user.isdel=0');
    }


}