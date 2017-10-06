<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-02
 * Time: 14:17
 */

namespace Common\Services;


use Bizer\Search\ComSearch;
use Common\Exception\LogicException;
use Common\Exception\ModelNotFindException;
use Common\Models\WeCom;
use Common\Models\WeOrder;
use Common\Services\BaseService;

/**
 * Class ComService
 * @package Common\Services
 * @property
 */
class ComService extends BaseService
{
    protected $modelCLass = WeCom::class;

    public function add($data)
    {
        /**
         * @var $model WeCom
         */
        $model = $this->findModel();
        $model->title = $data['title'];

    }

    public function edit($data, $id)
    {
        /**
         * @var $model WeCom
         */
        $model = $this->findModel($id);
        $model->title = "asdfaf";

    }

    public function editByAgent($data, $id, $agentId)
    {
        /**
         * @var
         */
        $model = $this->findModel($id);

    }

    public function addByAgent($data = [], $agentId = 0)
    {

    }

    public function addByCom($data = [], $comid = 0)
    {

    }

    /**
     * 检查店铺是否属于某个商家用户
     * @param $comid
     * @param $bizerId
     * @return bool
     * @throws LogicException
     */
    public function checkComidBelongToBizer($comid, $bizerId)
    {
        return WeCom::count(['id=:comid: and uid=:uid:', 'bind' => ['comid' => $comid, 'uid' => $bizerId]]);
    }

    /**
     * 检查店铺是否属于某个商家用户
     * @param $comid
     * @param $bizerId
     * @return bool
     * @throws LogicException
     */
    public function checkComidBelongToAgent($comid, $agentId)
    {
        return WeCom::count(['id=:comid: and uid=:uid:', 'bind' => ['comid' => $comid, 'uid' => $agentId]]);
    }


}