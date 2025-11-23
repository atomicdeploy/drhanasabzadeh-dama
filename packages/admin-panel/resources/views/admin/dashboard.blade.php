@extends('layouts.admin')

@section('title', 'داشبورد - پنل مدیریت')

@section('page-title', 'داشبورد')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <!-- Welcome Card -->
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="mr-3">
                                <h3 class="text-dark font-weight-bold mb-6">
                                    به پنل مدیریت خوش آمدید
                                </h3>
                                <p class="text-muted font-weight-bold">
                                    این پنل با موفقیت از سرور قدیمی وارد شده و آماده توسعه است.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3">
        <div class="card card-custom bg-primary gutter-b">
            <div class="card-body">
                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                    <i class="fas fa-users text-white"></i>
                </span>
                <div class="text-white font-weight-bold font-size-h2 mt-3">کاربران</div>
                <a href="#" class="text-white font-weight-bold font-size-lg mt-1">مشاهده لیست</a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3">
        <div class="card card-custom bg-success gutter-b">
            <div class="card-body">
                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                    <i class="fas fa-book text-white"></i>
                </span>
                <div class="text-white font-weight-bold font-size-h2 mt-3">دوره‌ها</div>
                <a href="#" class="text-white font-weight-bold font-size-lg mt-1">مدیریت دوره‌ها</a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3">
        <div class="card card-custom bg-info gutter-b">
            <div class="card-body">
                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                    <i class="fas fa-shopping-cart text-white"></i>
                </span>
                <div class="text-white font-weight-bold font-size-h2 mt-3">سفارشات</div>
                <a href="#" class="text-white font-weight-bold font-size-lg mt-1">مشاهده سفارشات</a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3">
        <div class="card card-custom bg-warning gutter-b">
            <div class="card-body">
                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                    <i class="fas fa-cog text-white"></i>
                </span>
                <div class="text-white font-weight-bold font-size-h2 mt-3">تنظیمات</div>
                <a href="#" class="text-white font-weight-bold font-size-lg mt-1">پیکربندی</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <!-- Information Card -->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">اطلاعات وارد شده</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-light-success fade show mb-5" role="alert">
                    <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="alert-text">
                        <strong>وارد سازی موفق:</strong> تمام داده‌های استاتیک و صفحات HTML با موفقیت وارد شده‌اند.
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>فایل‌های استاتیک</h5>
                        <ul>
                            <li>9 فایل CSS با پشتیبانی RTL</li>
                            <li>14 فایل JavaScript</li>
                            <li>FontAwesome Pro 6.1.1</li>
                            <li>KamaDatePicker (تقویم فارسی)</li>
                            <li>پلاگین‌ها: FullCalendar، PrismJS، ApexCharts</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>صفحات HTML خزیده شده</h5>
                        <ul>
                            <li>40 صفحه مدیریتی</li>
                            <li>داشبورد و آنالیتیکس</li>
                            <li>مدیریت محتوا</li>
                            <li>مدیریت دوره‌ها</li>
                            <li>مدیریت کاربران</li>
                            <li>تنظیمات و سفارشیسازی</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-5">
                    <h5>مراحل بعدی توسعه:</h5>
                    <ol>
                        <li>تبدیل صفحات HTML به قالب‌های Blade</li>
                        <li>تعریف مسیرها در routes/web.php</li>
                        <li>ایجاد کنترلرها</li>
                        <li>ایجاد migrations برای دیتابیس</li>
                        <li>پیاده‌سازی احراز هویت</li>
                    </ol>
                </div>
                
                <div class="mt-5">
                    <p class="text-muted">
                        برای شروع توسعه، لطفاً فایل <code>GETTING_STARTED.md</code> را مطالعه کنید.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    console.log('Dashboard loaded successfully!');
</script>
@endpush
