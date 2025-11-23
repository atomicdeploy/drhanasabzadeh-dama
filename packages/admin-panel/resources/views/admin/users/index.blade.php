@extends('layouts.admin')

@section('title', 'مدیریت کاربران')

@section('page-title', 'مدیریت کاربران')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست کاربران</h3>
                </div>
                <div class="card-toolbar">
                    <a href="#" class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-plus"></i>
                        کاربر جدید
                    </a>
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
                                <th>نام</th>
                                <th>ایمیل</th>
                                <th>موبایل</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت‌نام</th>
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
