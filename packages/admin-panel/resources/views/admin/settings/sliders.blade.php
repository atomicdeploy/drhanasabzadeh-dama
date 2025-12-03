@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مدیریت اسلایدرها</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary" onclick="addSlider()">
                            <i class="fa fa-plus"></i> اسلایدر جدید
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.settings.sliders.update') }}">
                        @csrf
                        
                        <div id="sliders-container">
                            @forelse($sliders as $index => $slider)
                                <div class="slider-item card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>آدرس تصویر</label>
                                                    <input type="text" name="sliders[{{ $index }}][image]" class="form-control" value="{{ $slider['image'] ?? '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>لینک</label>
                                                    <input type="text" name="sliders[{{ $index }}][link]" class="form-control" value="{{ $slider['link'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>عنوان</label>
                                                    <input type="text" name="sliders[{{ $index }}][title]" class="form-control" value="{{ $slider['title'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="btn btn-danger form-control" onclick="removeSlider(this)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">هنوز اسلایدری اضافه نشده است</div>
                            @endforelse
                        </div>
                        
                        <button type="submit" class="btn btn-primary">ذخیره اسلایدرها</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var sliderIndex = {{ count($sliders) }};

function addSlider() {
    var html = `
        <div class="slider-item card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>آدرس تصویر</label>
                            <input type="text" name="sliders[${sliderIndex}][image]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>لینک</label>
                            <input type="text" name="sliders[${sliderIndex}][link]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>عنوان</label>
                            <input type="text" name="sliders[${sliderIndex}][title]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger form-control" onclick="removeSlider(this)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.getElementById('sliders-container').insertAdjacentHTML('beforeend', html);
    sliderIndex++;
}

function removeSlider(btn) {
    btn.closest('.slider-item').remove();
}
</script>
@endsection
