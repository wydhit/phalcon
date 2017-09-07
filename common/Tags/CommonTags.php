<?php

namespace Common\Tags;


use Phalcon\Tag;

class CommonTags extends Tag
{
    public static function datePicker($name = '', $value = '')
    {
        if (empty($name)) {
            return '';
        }
        if (empty($value)) {
            $value = date('Y-m-d');
        }
        return "<div class=\"input-group\">
                   <input type=\"text\" id=\"$name\" name=\"$name\" class=\"form-control\" value=\"$value\"/>
                   <span class=\"input-group-addon\">
                   <i class=\"ace-icon fa fa-calendar\"></i>
                   </span>
               </div>
               <script type=\"text/javascript\">
                  $(function () {              
                    $('#$name').datepicker({
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

}