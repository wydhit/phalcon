<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-14
 * Time: 9:08
 */

namespace Common\Search;


use Common\Helpers\TimeHelper;
use Common\Models\WeCom;
use Common\Models\WeOrdergoods;

class BaseOrderSearch extends BaseSearch
{
    protected function sysBizerOrder($sysBizerId = 0)
    {
        $belongComids = WeCom::getComidsBySysBizerId($sysBizerId);
        if ($sysBizerId) {
            $this->builder->andWhere('orders.comid in (' . join(',', $belongComids) . ')');
        }
    }

    protected function orderNoDel()
    {
        $this->builder->andWhere('orders.isdel=0');
    }

    protected function orderIsPayed()
    {
        $this->builder->andWhere('orders.ispayed=1');
    }

    protected function isSdOrder()
    {
        $this->builder->andWhere('orders.order_type=0');
    }

    protected function isDnOrder()
    {
        $this->builder->andWhere('orders.order_type=1');
    }

    protected function BelongCom($comid = 0)
    {
        $this->builder->andWhere('orders.comid=:comid:', ['comid' => $comid]);
    }

    /**开始时间
     * @param string $timeStr 2017-05-03
     */
    protected function startTime($timeStr = '')
    {
        if (empty($timeStr)) {
            $timeStr = $this->getSearchData('startTime', 0);
        }
        $time = TimeHelper::getStartTime($timeStr, -7);
        $this->builder->andWhere("orders.stimeint > $time");
    }

    protected function endTime($timeStr = '')
    {
        if (empty($timeStr)) {
            $timeStr = $this->getSearchData('endTime', 0);
        }
        $time = TimeHelper::getEndTime($timeStr);
        $this->builder->andWhere("orders.stimeint <  $time");
    }

    protected function orderStatus($order_status = '')
    {
        $order_status = empty($order_status) ? $this->getSearchData('order_status') : $order_status;
        if (!in_array($order_status, ['ok', 'ispayed'])) {//ok 交易完成  ispayed 已支付
            $order_status = 'all';
        }
        $this->searchData['order_status'] = $order_status;
        if ($order_status == 'ok') {
            $this->builder->andWhere('orders.mystatus="taken"');
        } elseif ($order_status == 'ispayed') {
            $this->builder->andWhere('orders.mystatus="payed"');
        }
        return $this;
    }

    protected function doorStatus($door_status = '')
    {
        $door_status = empty($door_status) ? $this->getSearchData('door_status') : $door_status;
        if (!in_array($door_status, ['yes', 'no', 'outline'])) {
            $door_status = 'all';
        }//yes 正常开门  no 未正常开门 outline 网络异常
        $this->searchData['door_status'] = $door_status;
        if ($door_status == 'yes') {
            $this->builder->andWhere(
                'orders.goodlocker IS NOT NULL and (orders.goodlocker!=""  and orders.badlocker = ""  or orders.badlocker IS NULL)'
            );
        } elseif ($door_status == 'no') {
            $this->builder->andWhere("orders.badlocker IS NOT NULL  and orders.badlocker!=''");
        } elseif ($door_status == 'outline') {
            $this->builder->andWhere(
                "(orders.goodlocker IS NULL  or orders.goodlocker = '') and (orders.badlocker IS NULL or orders.badlocker = '')"
            );
        }
    }

    /**
     * @param string $title
     * @param int $comid 匹配指定店铺的
     * @param int $sysBizerId 匹配指定商家用户的
     */
    protected function goodTitle($title = '', $comid = 0, $sysBizerId = 0)
    {
        $title = empty($title) ? $this->getSearchData('title') : $title;
        if (empty($title)) {
            return;
        }
        $whereStr = " title like :title: ";
        $bind['title'] = "%$title%";
        $comids = [];
        if ($comid) {
            $comids[] = $comid;
        }
        if ($sysBizerId) {
            $comids = array_merge($comids, WeCom::getComidsBySysBizerId($sysBizerId));
        }
        $comids = array_unique($comids);
        if (!empty($comids)) {
            $whereStr .= " and comid in (" . join(',', $comids) . ")";
        }
        $comgoods = WeOrdergoods::find([
            $whereStr,
            'columns' => "orderid",
            'group' => 'orderid',
            'bind' => $bind
        ]);
        foreach ($comgoods as $v) {
            $orderid[] = $v['orderid'];
        }
        if (!empty($orderid)) {
            $orderidStr = implode(',', $orderid);
            $this->builder->andWhere(" orders.id in ($orderidStr) ");
        } else {
            $this->builder->andWhere(" orders.id in ('') ");
        }
    }

    protected function place($placeId = 0)
    {
        $placeId = empty($placeId) ? $this->getSearchData('placeId', 0) : $placeId;
        if ($placeId) {
            $this->builder->andWhere('orders.palceid=:palceid:', ['placeid' => $placeId]);
        }
    }

    protected function orderType($orderType = null)
    {
        if ($orderType === null) {
            return;
        }
        $orderType = (int)$orderType;
        if ($orderType === 0) {
            $this->isSdOrder();
        } elseif ($orderType === 1) {
            $this->isDnOrder();
        }
    }


}