<html>
<head>
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css">
</head>
<body>
<section class="content">
    <form class="form-horizontal" id="sponsor-form-edit" style="overflow-y: scroll; overflow-x:hidden; height:500px;"
          enctype="multipart/form-data">
        <div class="parent-box">
            <?php $organizing = $model->sponsor_unit->all(); ?>
            @if($organizing)
                @foreach ($organizing as $key => $item)
                    <div class="add-box-div">
                        @foreach($item as $k => $v)
                            @if($k === 'logo')
                                <input type="hidden" name="oldlogo[]" class="form-control" value="{{ $v ?? ""}}"/>
                            @else

                                <div class="form-group">
                                    <label for="input"
                                           class="col-sm-2 control-label">{{ \Encore\Milestone\Milestone::getUnitName($k) }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="{{$k}}[]" class="form-control" value="{{ $v ?? ""}}"
                                               placeholder="请输入{{\Encore\Milestone\Milestone::getUnitName($k)}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                            <div class="form-group">
                                <label for="input"
                                       class="col-sm-2 control-label">{{\Encore\Milestone\Milestone::getUnitName("logo") }}</label>
                                <div class="col-sm-6">
                                    <input type="file" name="logo[{{$key}}]" class="form-control" value=""
                                           placeholder="请输入{{\Encore\Milestone\Milestone::getUnitName("logo")}}">
                                </div>
                            </div>
                    </div>
                @endforeach
            @else
                <div class="add-box-div">
                    @foreach(\Encore\Milestone\Service\ModelStatic::$UNIT_LIST as $k => $v)
                        <div class="form-group">
                            <label for="input" class="col-sm-2 control-label">{{ $v }}</label>
                            <div class="col-sm-6">
                                <input type="{{$k === 'logo' ? 'file' : 'text'}}" name="{{$k}}[0]" class="form-control"
                                       placeholder="请输入{{$v}}">
                            </div>
                        </div>

                    @endforeach
                </div>
            @endif

        </div>
        <button type="button" class="btn btn-success add-box">+</button>
        <button type="button" class="btn btn-danger del-box">-</button>
        @csrf
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default submit-sponsor"
                        data-url="{{ route("milestone.editSponsor",['id'=>$id]) }}">保存
                </button>
            </div>
        </div>
    </form>

</section>
<script src="/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="/vendor/milestone/milestone/js/milestone.js"></script>
<script>
    $(function () {
        milestone._edit_sponsor();
        milestone._common();
    });
</script>
</body>
</html>