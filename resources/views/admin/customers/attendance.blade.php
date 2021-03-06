@extends("templates.admin")
@section('title',"Atendimento")
@section('breadcrumb')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/admin"
                       class="link">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/admin/customers"
                       class="link">Clientes</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/admin/customers/attendance"
                       class="link">Atendimento</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row mb-3 mt-2">
    <div class="col-12 d-flex flex-row align-items-center">
        <h4 class="mb-1">
            <span class="el-icon-s-finance mr-2"></span> Atendimento de Cliente <b>{{ $customer->name }}</b>
        </h4>
    </div>
</div>
<customer-attendance :customer="{{ json_encode($customer) }}"
                     :data="{{ json_encode($data) }}"
                     :canaddsale="{{ json_encode($canAddSale ? true : false) }}"
                     customer_area_url="{{ route('customer_area.index', ['code' => Auth::user()->tenant->code]) }}"></customer-attendance>
@endsection