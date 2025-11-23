@extends('layouts.admin')

@section('title', 'مدیریت سفارشات')

@section('page-title', 'مدیریت سفارشات')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست سفارشات</h3>
                </div>
            </div>
            
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    این صفحه در حال توسعه است. محتوای کامل بزودی اضافه خواهد شد.
                </div>
                
                <!-- Placeholder table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>شماره سفارش</th>
                                <th>کاربر</th>
                                <th>مبلغ</th>
                                <th>وضعیت پرداخت</th>
                                <th>تاریخ</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    در حال بارگذاری اطلاعات...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
