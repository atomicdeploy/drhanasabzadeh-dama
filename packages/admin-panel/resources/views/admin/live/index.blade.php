@extends('layouts.admin')

@section('title', 'مدیریت جلسات زنده')

@section('page-title', 'مدیریت جلسات زنده')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست جلسات زنده</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.live.create') }}" class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-plus"></i>
                        جلسه زنده جدید
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
                <form method="GET" action="{{ route('admin.live.index') }}" class="mb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="جستجو..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>برنامه‌ریزی شده</option>
                                <option value="live" {{ request('status') == 'live' ? 'selected' : '' }}>در حال پخش</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>اتمام یافته</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
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
                                <th>زمان برگزاری</th>
                                <th>مدت زمان</th>
                                <th>وضعیت</th>
                                <th>تعداد شرکت‌کنندگان</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sessions as $session)
                                <tr>
                                    <td>{{ $session->id }}</td>
                                    <td>{{ $session->title }}</td>
                                    <td>{{ $session->course?->title ?? 'ندارد' }}</td>
                                    <td>{{ $session->scheduled_at?->format('Y-m-d H:i') }}</td>
                                    <td>{{ $session->duration_minutes }} دقیقه</td>
                                    <td>
                                        @if($session->status == 'scheduled')
                                            <span class="badge badge-info">برنامه‌ریزی شده</span>
                                        @elseif($session->status == 'live')
                                            <span class="badge badge-success">در حال پخش</span>
                                        @elseif($session->status == 'completed')
                                            <span class="badge badge-secondary">اتمام یافته</span>
                                        @else
                                            <span class="badge badge-danger">لغو شده</span>
                                        @endif
                                    </td>
                                    <td>{{ $session->attendees_count ?? 0 }}</td>
                                    <td>
                                        <a href="{{ route('admin.live.edit', $session) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.live.comments', $session) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-comments"></i>
                                        </a>
                                        <form action="{{ route('admin.live.destroy', $session) }}" method="POST" 
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
                                    <td colspan="8" class="text-center text-muted py-5">
                                        جلسه زنده‌ای یافت نشد
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $sessions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
