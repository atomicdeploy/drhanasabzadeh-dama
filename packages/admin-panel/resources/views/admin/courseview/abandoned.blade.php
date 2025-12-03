@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">گزارش ترک دوره</h3>
                    <span class="text-muted">کاربرانی که دوره را ناتمام رها کرده‌اند</span>
                </div>
                
                <div class="card-body">
                    {{-- Filter Form --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>دوره:</label>
                                    <select name="course_id" class="form-control">
                                        <option value="">انتخاب دوره</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control">نمایش</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    @if(request('course_id') && $abandonedData->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>نام کاربر</th>
                                    <th>موبایل</th>
                                    <th>درصد پیشرفت</th>
                                    <th>آخرین مشاهده</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($abandonedData as $data)
                                    <tr>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->mobile }}</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" 
                                                     style="width: {{ $data->progress_percent }}%">
                                                    {{ $data->progress_percent }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $data->last_viewed_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $abandonedData->links() }}
                    @elseif(request('course_id'))
                        <div class="alert alert-success text-center">
                            <i class="fa fa-check-circle fa-3x mb-3"></i>
                            <h4>عالی!</h4>
                            <p>هیچ کاربری این دوره را ترک نکرده است</p>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <h4>لطفاً یک دوره انتخاب کنید</h4>
                            <p>برای مشاهده گزارش ترک دوره، ابتدا یک دوره از لیست بالا انتخاب کنید.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
