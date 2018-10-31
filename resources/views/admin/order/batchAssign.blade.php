<div class="modal inmodal" id="temp_window" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                </button>
                <h4 class="modal-title">批量分配订单</h4>
            </div>
            <form role="form" action="{{ route('admin.order.pending.batchAssign') }}" method="post">
                <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="order_id" id="order_id" value="">
                            <label class="col-sm-6 control-label" for="selector-assign">请选择订单处理人员</label>
                            <select class="form-control m-b" name="person_id" id="selector-assign" required oninvalid="setCustomValidity('请选择人员后提交');" oninput="setCustomValidity('');">
                                @foreach($person as $single)
                                    <option value="{{$single['id']}}">{{$single['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"> 提交 </button>
                </div>
            </form>

        </div>
    </div>
</div>