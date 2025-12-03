@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">نمودار پیشرفت دوره ها</h3>
                    <span class="text-muted">توزیع درصد پیشرفت کاربران در دوره ها</span>
                </div>
                
                <div class="card-body">
                    {{-- Filter Form --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>دوره:</label>
                                    <select name="course_id" class="form-control">
                                        <option value="">همه دوره ها</option>
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
                                    <button type="submit" class="btn btn-primary form-control">مشاهده نمودار</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    @if($selectedCourse && $stats)
                        {{-- Statistics --}}
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <strong>تعداد کل کاربران:</strong> {{ $stats['total_users'] }}
                            </div>
                            <div class="col-md-4">
                                <strong>دوره انتخابی:</strong> {{ $selectedCourse->title }}
                            </div>
                            <div class="col-md-4">
                                <strong>میانگین پیشرفت:</strong> {{ number_format($stats['average_progress'], 1) }}%
                            </div>
                        </div>
                        
                        {{-- Chart Container --}}
                        <div class="chart-wrapper" style="background-color: #fff; padding: 20px; border-radius: 10px;">
                            <canvas id="progressChart"></canvas>
                        </div>
                        
                        @push('scripts')
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            var ctx = document.getElementById('progressChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: @json($chartData['labels']),
                                    datasets: [{
                                        label: 'تعداد کاربران',
                                        data: @json($chartData['data']),
                                        backgroundColor: 'rgba(54, 153, 255, 0.8)',
                                        borderColor: 'rgba(54, 153, 255, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                        @endpush
                    @else
                        <div class="alert alert-warning text-center">
                            <h4>لطفاً یک دوره انتخاب کنید</h4>
                            <p>برای مشاهده نمودار پیشرفت، ابتدا یک دوره از لیست بالا انتخاب کنید.</p>
                            <i class="fa fa-chart-bar fa-3x text-warning mt-3"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
