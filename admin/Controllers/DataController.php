<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-27
 * Time: 13:06
 */

namespace Admin\Controllers;


use Common\Helpers\StringHelper;
use Common\Models\WeUser;

class DataController extends AdminController
{
    public function indexAction()
    {
        return $this->render();
    }

    public function createModelAction()
    {
        $allTables = $this->db->fetchAll("show tables");
        $dbname=$this->config->get('database')->get('dbname');
        foreach ($allTables as $allTable) {
            $this->createTable($allTable['Tables_in_'.$dbname]);
        }
    }

    /*更新字段*/
    public function updateFieldAction()
    {

        $allTables = $this->db->fetchAll("show tables");
        $dbname=$this->config->get('database')->get('dbname');
        foreach ($allTables as $allTable) {
            $this->updateField($allTable['Tables_in_'.$dbname]);
        }
        
    }
    private function updateField($tableName=''){
        $modelDir = COMMON_PATH . '/Models';

        $className = $this->convertUnderline($tableName);
        $columns = $this->db->describeColumns($tableName);
        $comments = $this->getComments($tableName);
        $classFile=$modelDir.'/'.$className.'.php';
        if(!file_exists($classFile)){
            echo $tableName.'没找到该模型文件';
            return '';
        }
        $oldModeContent=file_get_contents($classFile);
        /*字段*/
        $fields = [];
        foreach ($columns as $column) {
            $fieldName = $column->getName();
            if (!empty($comments[$fieldName])) {
                $commentStr = "/*{$comments[$fieldName]}*/";
            } else {
                $commentStr = '';
            }

            $fields[] = "    public $" . $column->getName() . ";".$commentStr;
        }
        $start='/*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/';
        $end='/*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/';

        $newModelContent=StringHelper::changeStrBetween($oldModeContent,$start,$end,"\r\n".join("\r\n", $fields)."\r\n    ");

        if($newModelContent!==$oldModeContent){

            file_put_contents($classFile, $newModelContent);
            echo '生成完毕';
        }else{
            echo '没有改变无需生成';
        }

        echo '<br/>';
    }

    private function createTable($tableName = '')
    {
        $modelDir = COMMON_PATH . '/Models';
        $template = $modelDir . '/template.php';
        $tmpStr = file_get_contents($template);

        $className = $this->convertUnderline($tableName);
        $columns = $this->db->describeColumns($tableName);

        $comments = $this->getComments($tableName);
        /*类名 表名*/
        $tmpStr = str_replace('className', $className, $tmpStr);
        $tmpStr = str_replace('tableName', $tableName, $tmpStr);
        /*字段*/
        $fields = [];
        foreach ($columns as $column) {
            $fieldName = $column->getName();
            if (!empty($comments[$fieldName])) {
                $commentStr = "/*{$comments[$fieldName]}*/";
            } else {
                $commentStr = '';
            }

            $fields[] = "    public $" . $column->getName() . ";".$commentStr;
        }
        $tmpStr = str_replace('/*$fields*/', join("\r\n", $fields), $tmpStr);
        /*扩展*/
        $tmpStr = str_replace('/*$extends*/', 'extends BaseModel', $tmpStr);
        $outFile = $modelDir . '/' . $className . '.php';

        if (file_exists($outFile)) {
            if ($this->request->get($className)) {
                file_put_contents($outFile, $tmpStr);
                echo '生成完毕';
            } else {
                echo $className . '已存在';
                echo "<button type=\"button\"
                        title=\"更新全部模型\"
                        data-href=\"".\Common\Helpers\HttpHelper::url('data/createModel',[],[$className=>'1'])."\"
                        class=\"btn btn-purple btn-sm \"
                        onclick=\"helper.dialogOpen(this)\">
                    <i class=\"ace-icon fa fa-trash-o bigger-120 \"></i>
                    确认覆盖
                </button>";
            }

        } else {
            file_put_contents($outFile, $tmpStr);
            echo '生成完毕';
        }
        echo '<br/>';

    }


    public function getComments($tableName)
    {
        $r = [];
        $zs = $this->db->fetchAll("show full columns from $tableName");
        foreach ($zs as $z) {
            $r[$z['Field']] = $z['Comment'];
        }
        return $r;
    }

    public function testAction()
    {

    }

    private function convertUnderline($str)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $str);
        return ucfirst($str);
    }



}