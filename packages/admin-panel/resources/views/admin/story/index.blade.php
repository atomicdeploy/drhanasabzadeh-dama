@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مدیریت استوری‌ها</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.story.create') }}" class="btn btn-primary">
                            استوری جدید
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    {{-- Search Form --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="جستجو..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>منقضی شده</option>
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

                    {{-- Data Table --}}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>تصویر</th>
                                <th>لینک</th>
                                <th>ترتیب</th>
                                <th>بازدید</th>
                                <th>تاریخ انقضا</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stories as $story)
                                <tr>
                                    <td>{{ $story->id }}</td>
                                    <td>
                                        @if($story->image_url)
                                            <img src="{{ $story->image_url }}" alt="Story" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($story->link_url)
                                            <a href="{{ $story->link_url }}" target="_blank" class="text-truncate" style="max-width: 200px; display: inline-block;">
                                                {{ $story->link_url }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $story->order }}</td>
                                    <td>{{ $story->view_count }}</td>
                                    <td>
                                        @if($story->expires_at)
                                            {{ \Carbon\Carbon::parse($story->expires_at)->format('Y/m/d H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($story->isExpired())
                                            <span class="badge badge-danger">منقضی شده</span>
                                        @elseif($story->status == 'active')
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-warning">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.story.edit', $story->id) }}" class="btn btn-sm btn-info">ویرایش</a>
                                        <form method="POST" action="{{ route('admin.story.destroy', $story->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">استوری یافت نشد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    {{ $stories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
