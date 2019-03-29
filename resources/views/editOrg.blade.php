<html>
<head>
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css">
</head>
<body>
<section class="content">
    <form class="form-horizontal" id="org-form-edit" enctype="multipart/form-data">
        <?php $organizing = $model->organizing->all(); ?>
        @foreach (\Encore\Milestone\Service\ModelStatic::$ORGINAZING_LIST as $key => $item)
            <div class="form-group">
                <label for="input" class="col-sm-2 control-label">{{ $item }}</label>
                <div class="col-sm-6">
                    <input type="text" name="organizing[{{$key}}]" class="form-control" value="{{ $organizing[$key] ?? ""}}"
                           placeholder="请输入{{$item}}">
                </div>
            </div>
        @endforeach
            @csrf

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default submit-org" data-url="{{ route("milestone.editOrg",['id'=>$id]) }}">保存</button>
            </div>
        </div>
    </form>

</section>
<script src="/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="/vendor/milestone/milestone/js/milestone.js"></script>
<script>
    $(function () {
        milestone._submit_org();
    });
</script>
</body>
</html>