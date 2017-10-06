<?php

namespace Common\Tags;


use Phalcon\Tag;

class CommonTags extends Tag
{
    public static function datePicker($name = '', $value = '',$id='')
    {
        if (empty($name)) {
            return '';
        }
        if(empty($id)){
            $id=$name;
        }
        if(empty($value)){
            $value=self::getValue($id);
        }
        if (empty($value)) {
            $value = date('Y-m-d');
        }
        return "<div class=\"input-group\">
                   <input type=\"text\" id=\"$id\" name=\"$name\" class=\"form-control\" value=\"$value\"/>
                   <span class=\"input-group-addon\">
                   <i class=\"ace-icon fa fa-calendar\"></i>
                   </span>
               </div>
               <script type=\"text/javascript\">
                  $(function () {              
                    $('#$id').datepicker({
                        language: 'zh-CN',
                        autoclose: true,
                        todayHighlight: true,
                        showButtonPanel: true,
                        changeMonth: true,
                        changeYear: true,
                        dateFormat:'yy-mm-dd',
                        beforeShow:function(input){                      
                            var divs = document.getElementsByTagName(\"div\");
                            for(var i=0, max=0; i<divs.length; i++){
                                max = Math.max( max,divs[i].style.zIndex || 0 );
                            }
                            max++;
                            $(input).css({zIndex:max});
                        }
                    });    
                   });
               </script>
               ";

    }

    public static function submitReset($submitId = 'submitForm', $submitValue = '提交')
    {
        return
            "<div class=\"form-group\">
                <div class=\"col-md-offset-2 col-md-9\">
                    <button class=\"btn btn-info\" type=\"submit\" id='$submitId' name='$submitId'>
                        <i class=\"ace-icon fa fa-check bigger-110\"></i>
                            $submitValue
                    </button>
                    <button class=\"btn\" type=\"reset\">
                    <i class=\"ace-icon fa fa-undo bigger-110\"></i>
                        重置
                    </button>
                </div>
            </div>";

    }

}