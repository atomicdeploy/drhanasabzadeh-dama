@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ماتریکس فعالیت کاربران</h3>
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
                    
                    @if(request('course_id') && $viewingData->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>کاربر</th>
                                    <th>درصد پیشرفت</th>
                                    <th>آخرین مشاهده</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($viewingData as $data)
                                    <tr>
                                        <td>{{ $data->user_id }}</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $data->progress }}%"
                                                     aria-valuenow="{{ $data->progress }}" 
                                                     aria-valuemin="0" aria-valuemax="100">
                                                    {{ $data->progress }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $data->last_viewed }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $viewingData->links() }}
                    @elseif(request('course_id'))
                        <div class="alert alert-info text-center">
                            داده‌ای برای این دوره یافت نشد
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <h4>لطفاً یک دوره انتخاب کنید</h4>
                            <p>برای مشاهده ماتریکس فعالیت، ابتدا یک دوره از لیست بالا انتخاب کنید.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
