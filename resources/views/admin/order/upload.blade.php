<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">订单上传</h4>
            </div>
            <form action="{{ route('admin.order.import') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" value="123">
                        <label class="font-noraml">文件选择</label>
                        <input type="file" class="form-control" name="file" onchange="selectFile(this)">
                        <span class="help-block m-b-none" id="upload_alert" style="display: none;">
                            <i class="fa fa-info-circle"></i> 文件类型有误，文件类型只支持 xls, xlsx
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" id="upload_button">上传</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function selectFile(input) {
        var fileName = input.value;
        if(fileName.length > 1 && fileName ) {
            var ldot = fileName.lastIndexOf(".");
            var type = fileName.substring(ldot + 1);
            if((type != "xls") && (type != "xlsx")) {
                $("#upload_alert").css('display', 'block');
                $("#upload_button").attr('disabled', 'disabled');
            } else {
                $("#upload_alert").css('display', 'none');
                $("#upload_button").removeAttr('disabled');
            }
        }
    }
</script>