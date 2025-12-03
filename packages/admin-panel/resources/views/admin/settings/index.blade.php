@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تنظیمات عمومی</h3>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نام سایت</label>
                                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ایمیل تماس</label>
                                    <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تلفن تماس</label>
                                    <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>آدرس</label>
                                    <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>توضیحات سایت</label>
                            <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                        </div>
                        
                        <hr>
                        <h5>شبکه‌های اجتماعی</h5>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>اینستاگرام</label>
                                    <input type="url" name="social_instagram" class="form-control" placeholder="https://instagram.com/..." value="{{ $settings['social_instagram'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>تلگرام</label>
                                    <input type="url" name="social_telegram" class="form-control" placeholder="https://t.me/..." value="{{ $settings['social_telegram'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>واتساپ</label>
                                    <input type="text" name="social_whatsapp" class="form-control" placeholder="+98..." value="{{ $settings['social_whatsapp'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">ذخیره تنظیمات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
