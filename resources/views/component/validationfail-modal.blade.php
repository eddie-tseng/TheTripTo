@if($errors AND count($errors))
<div class="modal fade" id="validationfail-modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="sub-title mx-auto">輸入錯誤</p>
                <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">
                    <img src={{url("/img/site/close.svg")}} alt="" width="30px" height="30px">
                </button>
            </div>
            <div class="modal-body">
                @foreach($errors->all() as $err)
                <p class="sub-title mx-auto"><i class="fa fa-exclamation-circle"></i> {{ $err }} </p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
