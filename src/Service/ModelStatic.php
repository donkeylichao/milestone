<?php
namespace Encore\Milestone\Service;

/**
 * 大事记常量静态变量设置
 * 1.图片上传剪裁宽度设置
 * 2.验证规则设置
 */
class ModelStatic {

    //背景图片压缩默认宽度
    const PICTURE_WIDTH = 600;

    //背景图片显示默认欢度
    const SHOW_PICTURE_WIDTH = 100;

    //组织机构对应的title
    public static $ORGINAZING_LIST = [
        'honorary_chairman' => '名誉主席',
        'chairman' => '主席',
        'vice_chairman' => '副主席',
        'exec_ehairman' => '执行主席',
        'secretary_general' => '大会秘书长',
    ];

    //单位对应的title
    public static $UNIT_LIST = [
        'name' => '单位名称',
        'en_name' => '单位英文名称',
        'logo' => '单位logo'
    ];

    //验证规则
    public static $rules = [
        'seq' => 'required|string|max:100',
        'theme' => 'required|string|max:100',
        'address' => 'required|string|max:100',
        'number' => 'integer|max:5',
    ];

    //图片验证规则
    public static $imageRules = [
        'list_bg' => 'required'
    ];

    //验证错误信息
    public static $errorMessage = [
        'seq.required' => '届数不能为空',
        'seq.string' => '届数必须为字符串',
        'seq.max' => '届数长度不能超过100',
        'theme.required' => '主题不能为空',
        'theme.string' => '主题必须为字符串',
        'theme.max' => '主题长度不能超过100',
        'address.required' => '地点不能为空',
        'address.string' => '地点必须为字符串',
        'address.max' => '地点长度不能超过100',
        'number.integer' => '届数格式不正确',
        'number.max' => '届数不能超过99999'
    ];

    //图片验证错误信息
    public static $imageErrorMessage = [
        'list_bg.required' => '没有选择背景图片'
    ];
}
