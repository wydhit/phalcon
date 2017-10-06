<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-21
 * Time: 14:15
 */

namespace Common\Forms;


use Common\Forms\Elements\DatePicker;
use Common\Helpers\StringHelper;
use Common\Helpers\TimeHelper;
use Common\Search\BaseSearch;
use Common\Tags\CommonTags;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Text;
use Phalcon\Tag;

class SearchForm extends BaseForm
{
    public function initialize($entity = null, $userOptions)
    {
        parent::initialize($entity, $userOptions);
        $this->_data = $this->request->get('searchData');
    }

    public function setData($data = [])
    {
        $this->_data = $data;
    }

    public function addStartTime($defaultValue = '')
    {
        $element = new DatePicker('startTime');
        $element->setDefault($defaultValue);
        $this->add($element);
    }

    public function addEndTime($defaultValue='')
    {
        $element = new DatePicker('endTime');
        $element->setDefault($defaultValue);
        $this->add($element);
    }
}