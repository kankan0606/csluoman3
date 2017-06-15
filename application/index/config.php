<?php
// +---------------------------------------------------------------------------------
// | Author: zkk 
// | this config  in index app
// +----------------------------------------------------------------------

return [
    'KEYWORD'=>'长沙婚庆,长沙婚庆罗蔓,长沙婚庆公司',
    'ADDKEYWORD'=>true,
    'TITLE'=>'长沙婚庆|长沙婚庆公司|长沙庆典策划公司|湖南婚庆 - 罗蔓婚庆',
    // 视图输出字符串内容替换
    'view_replace_str'       => [
   
    ],
    
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'html',
    
    //分页配置
    'paginate'               => [
    'var_page'  => 'p',
    'list_rows' => 9,
    'step'      => '5',//设置分页导航条显示页码的数量
    'type'      => '\zkk\paginate\HomePage',
    ],
    
    
    'template'               => [ //	预先加载的标签库
        'taglib_pre_load' => '\zkk\taglib\ZkkTag',
    ],
    
    'PRICETYPE' =>[  '1'=>['套系报价','PRICE'],
                     '2'=>['婚车报价','CAR'],
                  ],
];