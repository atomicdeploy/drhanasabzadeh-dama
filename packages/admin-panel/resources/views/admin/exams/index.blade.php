@extends('layouts.admin')

@section('title', 'مدیریت آزمون‌ها')

@section('page-title', 'مدیریت آزمون‌ها')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست آزمون‌ها</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.exam.create') }}" class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-plus"></i>
                        آزمون جدید
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.exam.index') }}" class="mb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>منتشر شده</option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>آرشیو</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i> جستجو
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>دوره</th>
                                <th>مدت زمان</th>
                                <th>نمره کل</th>
                                <th>نمره قبولی</th>
                                <th>وضعیت</th>
                                <th>تاریخ ایجاد</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exams as $exam)
                                <tr>
                                    <td>{{ $exam->id }}</td>
                                    <td>{{ $exam->title }}</td>
                                    <td>{{ $exam->course?->title ?? 'ندارد' }}</td>
                                    <td>{{ $exam->duration_minutes }} دقیقه</td>
                                    <td>{{ $exam->total_marks }}</td>
                                    <td>{{ $exam->passing_marks }}</td>
                                    <td>
                                        @if($exam->status == 'published')
                                            <span class="badge badge-success">منتشر شده</span>
                                        @elseif($exam->status == 'draft')
                                            <span class="badge badge-warning">پیش‌نویس</span>
                                        @else
                                            <span class="badge badge-secondary">آرشیو</span>
                                        @endif
                                    </td>
                                    <td>{{ $exam->created_at?->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.exam.edit', $exam) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.exam.destroy', $exam) }}" method="POST" 
                                              class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">
                                        آزمونی یافت نشد
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $exams->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
