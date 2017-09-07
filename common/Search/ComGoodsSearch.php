<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-06-27
 * Time: 10:57
 */

namespace Common\Search;


use Common\Exception\SearchFailException;
use Phalcon\Http\Request;
use Phalcon\Paginator\Adapter\QueryBuilder;

class ComGoodsSearch extends BaseSearch
{


    public function comGoodsListForGrid(Request $request)
    {
        $this->searchParamInit($request);
        /*搜索处理区*/
        $builder = $this->modelsManager->createBuilder()
            ->from(['comgoods' => 'Common\Models\WeComgoods'])
            ->columns([
                'id' => 'comgoods.id',
                'title' => 'goods.title',
                'goodsid' => 'goods.id',
                'preimg' => 'goods.preimg'
            ])
            ->leftJoin('Common\Models\WeGoods', 'goods.id=comgoods.goodsid', 'goods');
        if (!empty($this->searchData['title'])) {
            $title = $this->searchData['title'];
            if (strlen($title) > 200) {
                throw new SearchFailException('标题过长');
            }
            $builder->andWhere('goods.title like :title:', ['title' => "%{$title}%"]);
        }
        if ($this->searchData['isgroup'] !== null) {
            $builder->andWhere('goods.isgroup=:isgroup:', ['isgroup' => $this->searchData['isgroup']]);
        }
        /*搜索处理区结束*/

        /*通用处理方式*/
        $builder->orderBy("$this->sidx $this->sord");

        $paginator = (new QueryBuilder([
            "builder" => $builder,
            "limit" => $this->rows,
            "page" => $this->page
        ]))->getPaginate();
        $paginator->items = $paginator->items->filter(function ($data) {
            $data->preimg = "<img  data-rel=\"tooltip\" data-placement=\"left\" src='http://image.ejshendeng.com/{$data->preimg}' width='50' />";
            return $data;
        });
        return $this->returnGridData($paginator);
    }


}