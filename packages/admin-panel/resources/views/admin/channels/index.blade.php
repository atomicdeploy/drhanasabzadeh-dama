@extends('layouts.admin')

@section('title', 'مدیریت کانال‌ها')

@section('page-title', 'مدیریت کانال‌ها')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست کانال‌ها</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.channels.create') }}" class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-plus"></i>
                        کانال جدید
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

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.channels.index') }}" class="mb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
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
                                <th>نام کانال</th>
                                <th>توضیحات</th>
                                <th>تعداد پست‌ها</th>
                                <th>وضعیت</th>
                                <th>تاریخ ایجاد</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($channels as $channel)
                                <tr>
                                    <td>{{ $channel->id }}</td>
                                    <td>{{ $channel->name }}</td>
                                    <td>{{ Str::limit($channel->description, 50) }}</td>
                                    <td>{{ $channel->posts()->count() }}</td>
                                    <td>
                                        @if($channel->status == 'active')
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-secondary">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td>{{ $channel->created_at?->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.channels.edit', $channel) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.channels.destroy', $channel) }}" method="POST" 
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
                                    <td colspan="7" class="text-center text-muted py-5">
                                        کانالی یافت نشد
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $channels->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
