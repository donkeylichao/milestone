<?php

namespace Encore\Milestone\Service;

use App\Models\Milestone;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * 大事记操作特性
 */
trait MilestoneManageTrait
{
    /**
     * 模型赋值操作
     *
     * @param Milestone $model
     * @param array $data
     * @return Milestone
     */
    public static function load(Milestone $model, array $data)
    {
        $tableFields = Schema::getColumnListing($model->getTable());//获取表字段
        $data = array_filter($data);//过滤null数据
        $diff = array_diff(array_keys($data), $tableFields);//获取不属于表数据字段

        //循环赋值
        foreach ($data as $field => $value) {
            if (in_array($field, $diff)) {//排除非数据库字段的赋值
                continue;
            }
            $model->$field = $value;
        }

        //特殊赋值处理
        $model->user_id = Auth::guard('admin')->user()->id ?? 0;
        $model = self::specialLoad($model, $data);
        return $model;
    }

    /**
     * 处理json字段的值
     *
     * @param Milestone $model
     * @param array $data
     * @return Milestone
     */
    protected static function specialLoad(Milestone $model, array $data)
    {
        $model->organizing = $data['organizing'] ?? [];
        $model->sponsor_unit = $data['sponsor_unit'] ?? [];
        $model->support_unit = $data['support_unit'] ?? [];
        return $model;
    }

    /**
     * 图片上传操作
     *
     * @param UploadedFile $fileCharater
     * @return bool|string
     */
    public static function uploadImage(UploadedFile $fileCharater)
    {

        //获取文件的扩展名
        $ext = $fileCharater->getClientOriginalExtension();

        //获取文件的绝对路径
        $path = $fileCharater->getRealPath();

        //定义文件名
        $filename = date('Y-m-d-H-i-s') . rand(1000, 9999) . '.' . $ext;

        Image::make(file_get_contents($path))->fit(ModelStatic::PICTURE_WIDTH)->save('storage/' . $filename);

        return $filename;
    }

    /**
     * 图片删除操作
     *
     * @param string $path
     * @return bool
     */
    public static function deleteImage(string $path): bool
    {
        return Storage::disk(config('admin.upload.disk'))->delete($path);
    }

    /**
     * 获取lab标题
     *
     * @param string $index
     * @return string
     */
    public static function getUnitName(string $index): string
    {
        return isset(ModelStatic::$UNIT_LIST[$index]) ? ModelStatic::$UNIT_LIST[$index] : "";
    }
}