<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-13
 * Time: 17:22
 */

namespace Bizer\Controllers;


use Bizer\Search\OrderSearch;
use Common\Helpers\StringHelper;
use Common\Tags\CommonTags;

class OrderController extends BizerController
{
    public function listAction()
    {
    }

    public function sdOrderAction()
    {
        $orderSearch = OrderSearch::instance();
        $orderSearch->sdOrderList($this->userId);
        if ($this->request->get('action') === 'export') {/*导出*/
            $data = $orderSearch->returnAllData();
            return $this->exportXls($data);
        } else {
            $data = $orderSearch->returnPaginatorData(function ($data) {
                $data->mygoods = json_decode($data->mygoods);
                $data->badlocker = StringHelper::idsToArray($data->badlocker);
                $data->goodlocker = StringHelper::idsToArray($data->goodlocker);
                $data->alllocker = StringHelper::idsToArray($data->alllocker);
                return $data;
            });
            /*统计总额*/
            $total=$orderSearch->sumTotal();
            $this->addData('allprice',$total->allprice);
            $this->addData('commission',$total->commission);
            CommonTags::setDefaults($orderSearch->getSearchAllData());
            return $this->render($data);
        }
    }

    public function dnOrderAction()
    {
        $orderSearch = OrderSearch::instance();
        $orderSearch->dnOrderList($this->userId);
        if ($this->request->get('action') === 'export') {/*导出*/
            $data = $orderSearch->returnAllData();
            return $this->exportXls($data);
        } else {
            $data = $orderSearch->returnPaginatorData(function ($data) {
                $data->mygoods = json_decode($data->mygoods);
                $data->badlocker = StringHelper::idsToArray($data->badlocker);
                $data->goodlocker = StringHelper::idsToArray($data->goodlocker);
                $data->alllocker = StringHelper::idsToArray($data->alllocker);
                return $data;
            });
            $total=$orderSearch->sumTotal();
            $this->addData('allprice',$total->allprice);
            $this->addData('commission',$total->commission);
            CommonTags::setDefaults($orderSearch->getSearchAllData());
            return $this->render($data);
        }
    }
}