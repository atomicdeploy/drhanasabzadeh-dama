@extends('layouts.admin')

@section('title', 'مدیریت دسته‌بندی‌ها')

@section('page-title', 'مدیریت دسته‌بندی‌ها')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست دسته‌بندی‌ها</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.cat.create') }}" class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-plus"></i>
                        دسته‌بندی جدید
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Search and Filters -->
                <form method="GET" action="{{ route('admin.cat.index') }}" class="mb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                                جستجو
                            </button>
                            <a href="{{ route('admin.cat.index') }}" class="btn btn-secondary">
                                پاک کردن
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Errors -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Categories Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>نام فارسی</th>
                                <th>نام انگلیسی</th>
                                <th>والد</th>
                                <th>ترتیب</th>
                                <th>وضعیت</th>
                                <th>تعداد دوره‌ها</th>
                                <th width="15%">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        @if($category->icon)
                                            <i class="{{ $category->icon }}"></i>
                                        @endif
                                        {{ $category->name_fa }}
                                    </td>
                                    <td>{{ $category->name_en ?? '-' }}</td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge badge-light">{{ $category->parent->name_fa }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->order }}</td>
                                    <td>
                                        @if($category->status === 'active')
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-danger">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $category->courses->count() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.cat.edit', $category) }}" class="btn btn-sm btn-icon btn-light-primary" title="ویرایش">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.cat.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-light-danger" title="حذف">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        هیچ دسته‌بندی یافت نشد
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[title]').tooltip();
});
</script>
@endpush
