@extends('layouts.admin')

@section('title', 'مدیریت کاربران')

@section('page-title', 'مدیریت کاربران')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست کاربران</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-plus"></i>
                        کاربر جدید
                    </a>
                    <a href="{{ route('admin.user.upload') }}" class="btn btn-success font-weight-bolder mr-2">
                        <i class="fa fa-upload"></i>
                        آپلود گروهی
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Search Form --}}
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو نام، ایمیل، موبایل..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="role" class="form-control">
                                <option value="">همه نقش‌ها</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>کاربر</option>
                                <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>مدرس</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>مدیر</option>
                            </select>
                        </div>
                        <div class="col-md-2">
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
                                <th>نام</th>
                                <th>ایمیل</th>
                                <th>موبایل</th>
                                <th>نقش</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت‌نام</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge badge-danger">مدیر</span>
                                        @elseif($user->role == 'teacher')
                                            <span class="badge badge-primary">مدرس</span>
                                        @else
                                            <span class="badge badge-secondary">کاربر</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == 'active')
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-warning">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('Y/m/d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-info" title="نمایش">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-primary" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display:inline" onsubmit="return confirm('از حذف این کاربر اطمینان دارید؟')">
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
                                        کاربری یافت نشد
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
