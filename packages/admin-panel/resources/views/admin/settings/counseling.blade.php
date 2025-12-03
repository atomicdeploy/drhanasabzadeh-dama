@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تنظیمات مشاوره</h3>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.settings.counseling.update') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label class="d-flex align-items-center">
                                <input type="checkbox" name="counseling_enabled" value="1" {{ ($settings['counseling_enabled'] ?? false) ? 'checked' : '' }}>
                                <span class="mr-2">فعال بودن سرویس مشاوره</span>
                            </label>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>قیمت هر جلسه (تومان)</label>
                                    <input type="number" name="counseling_price" class="form-control" value="{{ $settings['counseling_price'] ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>مدت هر جلسه (دقیقه)</label>
                                    <input type="number" name="counseling_duration" class="form-control" value="{{ $settings['counseling_duration'] ?? 60 }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>توضیحات مشاوره</label>
                            <textarea name="counseling_description" class="form-control" rows="4">{{ $settings['counseling_description'] ?? '' }}</textarea>
                        </div>
                        
                        <hr>
                        <h5>روزهای در دسترس</h5>
                        
                        <div class="row">
                            @php
                                $days = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'];
                                $availableDays = $settings['available_days'] ?? [];
                            @endphp
                            @foreach($days as $index => $day)
                                <div class="col-md-3">
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="available_days[]" value="{{ $index }}" {{ in_array($index, $availableDays) ? 'checked' : '' }}>
                                        <span class="mr-2">{{ $day }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ساعت شروع</label>
                                    <input type="time" name="available_hours_start" class="form-control" value="{{ $settings['available_hours_start'] ?? '09:00' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ساعت پایان</label>
                                    <input type="time" name="available_hours_end" class="form-control" value="{{ $settings['available_hours_end'] ?? '18:00' }}">
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
