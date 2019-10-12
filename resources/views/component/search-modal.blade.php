<div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-bady">
                <button type="button" class="close float-right mr-2 mt-2" data-dismiss="modal" aria-label="Close">
                    <img src={{url("/img/site/close.svg")}} alt="" width="30px" height="30px">
                </button>
                <p class="sub-title text-center mt-3">搜尋</p>
                <hr>
                <div class="row mb-4">
                    <div class="input-group col-10 mx-auto p-0">
                        <input type="text" class="search-text form-control" name="search" data-toggle="dropdown"
                            data-target="#search-result-sm" aria-haspopup="false" aria-expanded="false"
                            autocomplete="off" value="" placeholder="輸入關鍵字...">
                        <span class="input-group-btn">
                            <button class="btn-search btn btn-block" type="button">
                                <img src={{url("/img/site/search.svg")}} alt="search">
                            </button>
                        </span>
                        <ul class="search-result dropdown-menu col-12 pl-2" id="search-result-sm"></ul>
                    </div>
                    <input type="text" class="form-control" name="sort" value="default" hidden>
                </div>
            </div>
        </div>
    </div>
</div>
