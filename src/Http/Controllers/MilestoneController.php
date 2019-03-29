<?php

namespace Encore\Milestone\Http\Controllers;

use App\Models\Milestone;
use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Milestone\Service\ModelStatic;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MilestoneController extends Controller
{
    /**
     * 大事记管理列表
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('大事记管理')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * 大事记详情
     *
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function show(int $id, Content $content)
    {
        $model = Milestone::findOrFail($id);
        return $content
            ->header('大事记管理')
            ->description('详细')
            ->body(view("milestone::show", ['model' => $model, 'id' => $id]));
    }

    /**
     * 大事记创建表单
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('大事记管理')
            ->description('创建')
            ->body($this->form());
    }

    /**
     * 大事记保存操作
     *
     * @param Request $request
     * @return mixed $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // 获取数据
        $data = $request->all();
        // 表单验证
        $val = \Illuminate\Support\Facades\Validator::make($data, array_merge(ModelStatic::$rules, ModelStatic::$imageRules),
            array_merge(ModelStatic::$errorMessage, ModelStatic::$imageErrorMessage));
        if ($val->fails()) {
            return back()->withErrors($val)->withInput();
        }

        // 图片上传
        $fileCharater = $request->file('list_bg');
        if ($fileCharater->isValid() && is_string($path = \Encore\Milestone\Milestone::uploadImage($fileCharater))) {
            //model赋值
            $data['list_bg'] = $path;
            $data['year'] = empty($data['date']) ? "" : current(explode("-", $data['date']));
            $milestone = \Encore\Milestone\Milestone::load(new Milestone(), $data);
            if ($milestone->save()) {
                admin_success('success', '添加成功!');
                return redirect(route('milestone.index'));
            }
        }
        admin_warning('warning', '添加失败');
        return back()->withInput();
    }

    /**
     * 编辑页面
     *
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function edit(int $id, Content $content)
    {
        return $content
            ->header('大事记管理')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * 编辑大事件
     *
     * @param int $id
     * @param Request $request
     * @return mixed $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(int $id, Request $request)
    {
        //更新逻辑
        $model = Milestone::findOrFail($id);

        // 获取数据
        $data = $request->all();

        // 表单验证
        $val = \Illuminate\Support\Facades\Validator::make($data, ModelStatic::$rules, ModelStatic::$errorMessage);
        if ($val->fails()) {
            return back()
                ->withErrors($val)
                ->withInput();
        }

        $fileCharater = $request->file('list_bg');
        if ($fileCharater && $fileCharater->isValid() && is_string($path = \Encore\Milestone\Milestone::uploadImage($fileCharater))) {
            $data['list_bg'] = $path;
        }
        $data['year'] = empty($data['date']) ? "" : current(explode("-", $data['date']));

        $model = \Encore\Milestone\Milestone::load($model, $data);

        if ($model->save()) {
            admin_success('success', '编辑成功!');
            return redirect(route('milestone.index'));
        }

        admin_warning('warning', '编辑失败');
        return back()
            ->withInput();
    }

    /**
     * 删除大记事
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $data = [
            'status' => true,
            'message' => '删除成功'
        ];
        if (!Milestone::destroy($id)) {
            $data['status'] = false;
            $data['message'] = '删除失败!';
        }

        return response()->json($data);
    }

    /**
     * 展示编辑组织机构页面
     *
     * @param int $id
     * @return Content
     */
    public function editOrg(int $id)
    {
        $milestone = Milestone::findOrFail($id);
        return view("milestone::editOrg", ['model' => $milestone, 'id' => $id]);
    }

    /**
     * 编辑组织机构信息
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrg(int $id, Request $request)
    {
        $milestone = Milestone::findOrFail($id);
        $milestone->organizing = $request->get("organizing");
        $return = ['status' => 1, "msg" => "成功"];
        if ($milestone->save()) {
            admin_success("success", "组织结构修改成功!");
            return response()->json($return);
        }
        $return['status'] = 0;
        $return['msg'] = "失败";
        admin_warning("warning", "组织结构修改失败!");
        return response()->json($return);
    }

    /**
     * 展示编辑页面
     *
     * @param int $id
     * @return Content
     */
    public function editSponsor(int $id)
    {
        $milestone = Milestone::findOrFail($id);
        return view("milestone::editSponsor", ['model' => $milestone, 'id' => $id]);
    }

    /**
     * 编辑信息
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSponsor(int $id, Request $request)
    {
        $milestone = Milestone::findOrFail($id);
        $return = ['status' => 1, "msg" => "成功"];

        // 图片上传
        $logo = [];
        $logoFile = $request->file('logo', []);
        $oldLogo = $request->get('oldlogo', []);
        foreach ($logoFile as $key => $item) {
            if ($item && $item->isValid()) {

                if (!is_string($path = \Encore\Milestone\Milestone::uploadImage($item))) {
                    $return['status'] = 0;
                    $return['msg'] = "第" . ($key + 1) . "张图片上传失败";
                    return response()->json($return);
                }
                $logo[$key] = $path;
            }
        }

        $names = $request->get("name", []);
        $enNames = $request->get("en_name", []);

        $milestone->sponsor_unit = $this->formatUnitData($names, $enNames, $logo, $oldLogo);

        if ($milestone->save()) {
            admin_success("success", "主办单位修改成功!");
            return response()->json($return);
        }
        $return['status'] = 0;
        $return['msg'] = "失败";
        admin_warning("warning", "主办单位修改失败!");
        return response()->json($return);
    }

    /**
     * 格式化存储数据
     *
     * @param array $names
     * @param array $enNames
     * @param array $logo
     * @param array $oldLogo
     * @return array
     */
    protected function formatUnitData(array $names, array $enNames, array $logo, array $oldLogo): array
    {
        $formatData = collect($names)->map(function ($name, $key) use ($enNames, $logo, $oldLogo) {
            //都为空不存数据库
            if (empty($name) && empty($enNames[$key]) && empty($logo[$key])) {
                return [];
            }
            return [
                'name' => $name,
                'en_name' => $enNames[$key] ?? '',
                'logo' => $logo[$key] ?? ($oldLogo[$key] ?? ""),
            ];
        })->toArray();
        return array_filter($formatData);
    }

    /**
     * 展示编辑页面
     *
     * @param int $id
     * @return Content
     */
    public function editSupport(int $id)
    {
        $milestone = Milestone::findOrFail($id);
        return view("milestone::editSupport", ['model' => $milestone, 'id' => $id]);
    }

    /**
     * 编辑信息
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSupport(int $id, Request $request)
    {
        $milestone = Milestone::findOrFail($id);
        $return = ['status' => 1, "msg" => "成功"];

        // 图片上传
        $logo = [];
        $logoFile = $request->file('logo', []);
        $oldLogo = $request->get('oldlogo', []);
        foreach ($logoFile as $key => $item) {
            if ($item && $item->isValid()) {

                if (!is_string($path = \Encore\Milestone\Milestone::uploadImage($item))) {
                    $return['status'] = 0;
                    $return['msg'] = "第" . ($key + 1) . "张图片上传失败";
                    return response()->json($return);
                }
                $logo[$key] = $path;
            }
        }

        $names = $request->get("name", []);
        $enNames = $request->get("en_name", []);

        $milestone->support_unit = $this->formatUnitData($names, $enNames, $logo, $oldLogo);

        if ($milestone->save()) {
            admin_success("success", "学术支持单位修改成功!");
            return response()->json($return);
        }
        $return['status'] = 0;
        $return['msg'] = "失败";
        admin_warning("warning", "学术支持单位修改失败!");
        return response()->json($return);
    }

    /**
     * Make a form builder for create.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Milestone());

        $form->text('seq', '届数')->placeholder('请输入届数');
        $form->text('theme', '主题')->placeholder('请输入主题');
        $form->text('address', '地点')->placeholder('请输入地点');
        $form->date('date', '举办日期')->placeholder('请选择举办日期');
        $form->text('number', '第几届')->placeholder('请输入第几届');
        $form->image('list_bg', '背景图片');

        //表单底部定义
        $form->footer(function ($footer) {

            // 去掉`重置`按钮
            $footer->disableReset();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();
        });

        return $form;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Milestone());

        $grid->id('ID')->sortable();
        $grid->list_bg('背景图')->image("", 100, 100);
        $grid->theme('主题');
        $grid->date('举办日期');
        $grid->address('地点');

        $grid->disableExport();
        $grid->disableRowSelector();

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 自定义过滤字段
            $filter->like('theme', '主题');
            $filter->where(function ($query) {
                $query->where('date', '=', $this->input);
            }, '举办时间')->date();
        });

        $grid->actions(function ($tool) {
            $tool->append('<a href="javascript:void(0);" data-url="' . route("milestone.editOrg", ['id' => $tool->getKey()]) . '" title="编辑组织机构" class="milestone-org"><i class="fa fa-edit"></i></a>&nbsp;');
            $tool->append('<a href="javascript:void(0);" data-url="' . route("milestone.editSponsor", ['id' => $tool->getKey()]) . '" title="编辑主办单位" class="milestone-sponsor"><i class="fa fa-edit"></i></a>&nbsp;');
            $tool->append('<a href="javascript:void(0);" data-url="' . route("milestone.editSupport", ['id' => $tool->getKey()]) . '" title="编辑学术支持单位" class="milestone-support"><i class="fa fa-edit"></i></a>');
        });
        return $grid;
    }

    /**
     * 详情展示页面
     *
     * @param int $id
     * @return Show
     */
    protected function detail(int $id)
    {
        $show = new Show(Milestone::findOrFail($id));

        $show->seq('届数');
        $show->theme('主题');
        $show->start_date('开始时间');
        $show->end_date('结束时间');
        $show->address('地点');
        $show->organizing('组织结构')->as(function ($organize) {
            return $organize;
        });
        $show->sponsor_unit('主办单位')->as(function ($sponsor) {
            return $sponsor;
        });
        $show->support_unit('学术支持单位')->as(function ($support) {
            return $support;
        });
        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableDelete();
            });
        return $show;
    }

}
