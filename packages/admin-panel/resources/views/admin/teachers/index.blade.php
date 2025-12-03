@extends('layouts.admin')

@section('title', 'مدیریت اساتید')

@section('page-title', 'مدیریت اساتید')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست اساتید</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-plus"></i>
                        استاد جدید
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Search Form --}}
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" placeholder="جستجو نام، تخصص..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary">جستجو</button>
                        </div>
                    </div>
                </form>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام استاد</th>
                                <th>تخصص</th>
                                <th>سابقه (سال)</th>
                                <th>تعداد دوره‌ها</th>
                                <th>امتیاز</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->id }}</td>
                                    <td>
                                        @if($teacher->user)
                                            {{ $teacher->user->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $teacher->expertise }}</td>
                                    <td>{{ $teacher->experience_years ?? '-' }}</td>
                                    <td>{{ $teacher->courses_count ?? 0 }}</td>
                                    <td>
                                        @if($teacher->rating)
                                            <span class="text-warning">
                                                <i class="fas fa-star"></i> {{ number_format($teacher->rating, 1) }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($teacher->status == 'active')
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-warning">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="btn btn-sm btn-info" title="نمایش">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-primary" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" style="display:inline" onsubmit="return confirm('از حذف این مدرس اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        مدرسی یافت نشد
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                {{ $teachers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
