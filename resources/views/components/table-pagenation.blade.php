<div class="table-responsive">
    {{-- <table class="table table-bordered mb-0 datatable datatable-{{ $table }}" data-action="/api/v1/operator/getUser"> --}}
    <table class="table table-bordered mb-0 datatable datatable-{{ $table }}" data-action="{{ $url }}">
        <thead>
            @if ($headers)
                <tr>
                    @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                    @endforeach
                </tr>
            @endif
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@if ($pagination)
    <nav aria-label="Page navigation" class="pagination-setting-{{ $table }}">
        <div class="d-flex justify-content-end mt-3">
            <span class="pagination-info">dari ke</span>
        </div>
        <ul class="pagination pagination-primary justify-content-end">
            <li class="page-item">
                <a class="btn btn-primary btn-first" href="#">
                    <span aria-hidden="true"><i class="bi bi-chevron-double-left"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="btn btn-primary btn-prev" href="#">
                    <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                </a>
            </li>
            <li class="page-item">
                <form class="navbar-form pull-right goto">
                    <input style="width:60px; padding: 5px; margin-left: 5px; margin-right: 5px" type="text" name="page" class="form-control no">
                </form>
            </li>
            <li class="page-item">
                <a class="btn btn-primary btn-next" href="#">
                    <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="btn btn-primary btn-last" href="#">
                    <span aria-hidden="true"><i class="bi bi-chevron-double-right"></i></span>
                </a>
            </li>
        </ul>
    </nav>
@endif
