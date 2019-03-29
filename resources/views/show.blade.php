<div class="bs-example col-md-12" data-example-id="striped-table">
    <table class="table table-striped">
        <tbody>
        <tr>
            <td colspan="6">基本信息</td>
        </tr>
        <tr>
            <td><b>届数</b></td>
            <td>{{ $model->seq }}</td>
            <td><b>举办日期</b></td>
            <td>{{$model->date}}</td>
            <td><b>背景图片</b></td>
            <td><img src="{{ \Illuminate\Support\Facades\Storage::disk("admin")->url($model->list_bg) }}" style="max-width:100px;max-height:100px" class="img img-thumbnail"/></td>
        </tr>
        <tr>
            <td><b>主题</b></td>
            <td>{{ $model->theme }}</td>
            <td><b>地点</b></td>
            <td colspan="3">{{$model->address}}</td>
        </tr>

        <tr>
            <td colspan="6">组织结构</td>
        </tr>

        <tr>
            <td><b>名誉主席</b></td>
            <td>{{ $model->organizing->get("honorary_chairman") }}</td>
            <td><b>主席</b></td>
            <td>{{$model->organizing->get("chairman")}}</td>
            <td><b>副主席</b></td>
            <td>{{ $model->organizing->get("vice_chairman") }}</td>
        </tr>
        <tr>
            <td><b>执行主席</b></td>
            <td>{{ $model->organizing->get("exec_ehairman") }}</td>
            <td><b>大会秘书长</b></td>
            <td colspan="3">{{$model->organizing->get("secretary_general")}}</td>
        </tr>

        <tr>
            <td colspan="6">主办单位</td>
        </tr>
        @foreach($model->sponsor_unit->all() as  $item)
            <tr>
                @foreach($item as $k => $v)
                    <td><b>{{\Encore\Milestone\Milestone::getUnitName($k)}}</b></td>
                    @if($k === "logo" && $v)
                        <td><img src="{{ \Illuminate\Support\Facades\Storage::disk("admin")->url($v) }}" style="max-width:100px;max-height:100px" class="img img-thumbnail"/></td>
                    @else
                        <td>{{ $v }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        <tr>
            <td colspan="6">学术支持单位</td>
        </tr>
        @foreach($model->support_unit->all() as  $item)
            <tr>
                @foreach($item as $k => $v)
                    <td><b>{{\Encore\Milestone\Milestone::getUnitName($k)}}</b></td>
                    @if($k === "logo" && $v)
                        <td><img src="{{ \Illuminate\Support\Facades\Storage::disk("admin")->url($v) }}" style="max-width:100px;max-height:100px" class="img img-thumbnail"/></td>
                    @else
                        <td>{{ $v }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
