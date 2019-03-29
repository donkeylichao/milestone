var milestone = {

    _edit_org: function () {
        //弹出添加用户窗口
        $(document).on('click','.milestone-org',function(){
            var url = $(this).attr('data-url');
            dialog({
                title: "编辑组织机构",
                url: url,
                width: 700,
                onclose: function () {
                    //关闭弹窗后需要的事件
                    // $("#action_id").attr('value', '');
                    // $("#action").attr('value', '');
                    // $('.user-action-span-wrap').parent().remove();
                }
            }).showModal();
        });

        //编辑主办单位
        $(document).on('click','.milestone-sponsor',function(){
            var url = $(this).attr('data-url');
            dialog({
                fixed: true,
                title: "编辑主办单位",
                url: url,
                width: 700,
                height: 500,
                onclose: function () {
                    //关闭弹窗后需要的事件
                    // $("#action_id").attr('value', '');
                    // $("#action").attr('value', '');
                    // $('.user-action-span-wrap').parent().remove();
                }
            }).showModal();
        });

        //编辑学术支持单位
        $(document).on('click','.milestone-support',function(){
            var url = $(this).attr('data-url');
            dialog({
                fixed: true,
                title: "编辑学术支持单位",
                url: url,
                width: 700,
                height: 500,
                onclose: function () {
                    //关闭弹窗后需要的事件
                    // $("#action_id").attr('value', '');
                    // $("#action").attr('value', '');
                    // $('.user-action-span-wrap').parent().remove();
                }
            }).showModal();
        });
    },

    //保存组织架构修改方法
    _submit_org: function () {
        $(".submit-org").click(function () {
            //获取form对象
            var url = $(this).attr("data-url");
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#org-form-edit').serialize(),
                success: function (data) {
                    if (data.status) {
                        window.parent.location.reload();

                    } else {
                    }
                }
            })
        })
    },

    //编辑主办单位
    _edit_sponsor: function () {

        //提交操作
        $(".submit-sponsor").click(function () {
            //获取form对象
            var url = $(this).attr("data-url");
            var form = new FormData(document.getElementById("sponsor-form-edit"));
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType:false,
                async:false,
                data: form,
                success: function (data) {
                    if (data.status) {
                        window.parent.location.reload();

                    } else {
                    }
                }
            })
        })
    },

    //编辑学术支持
    _edit_support:function () {
        //提交操作
        $(".submit-support").click(function () {
            //获取form对象
            var url = $(this).attr("data-url");
            var form = new FormData(document.getElementById("support-form-edit"));
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType:false,
                async:false,
                data: form,
                success: function (data) {
                    if (data.status) {

                        window.parent.location.reload();

                    } else {
                    }
                }
            })
        })
    },

    //添加删除按钮js
    _common :function () {
        //添加编辑框按钮
        $(".add-box").click(function () {
            $(".parent-box").append(`<div class="add-box-div">
            <div class="form-group">
                <label for="input" class="col-sm-2 control-label">单位名称</label>
                <div class="col-sm-6">
                <input type="text" name="name[]" class="form-control" placeholder="请输入单位名称">
                </div>
                </div>
                <div class="form-group">
                <label for="input" class="col-sm-2 control-label">单位英文名称</label>
                <div class="col-sm-6">
                <input type="text" name="en_name[]" class="form-control" placeholder="请输入单位英文名称">
                </div>
                </div>
                <div class="form-group">
                <label for="input" class="col-sm-2 control-label">单位logo</label>
                <div class="col-sm-6">
                <input type="file" name="logo[]" class="form-control" placeholder="请输入单位名称">
                </div>
                </div>
                </div>`);
            updateIndex();
        });

        //删除元素
        $(".del-box").click(function () {
            var len = $(".parent-box").find(".add-box-div").length;
            if (len === 1) {
                return;
            }
            $(".parent-box").find(".add-box-div")[len-1].remove();
            updateIndex();
        });


        /**
         *  更新图片index用来后台区分哪个上传的图片
         */
        function updateIndex() {
            $("input[type=file]").each(function (k,v) {
                $(v).attr("name","logo[" + k + "]");
            })
        }
    }
};

$(function () {
    milestone._edit_org();
});