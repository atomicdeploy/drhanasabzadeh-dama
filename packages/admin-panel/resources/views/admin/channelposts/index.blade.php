@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مدیریت پست‌های کانال</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.channelposts.create') }}" class="btn btn-primary">
                            پست جدید
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
                                <select name="channel_id" class="form-control">
                                    <option value="">همه کانال‌ها</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ request('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>منتشر شده</option>
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

                    {{-- Data Table --}}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>کانال</th>
                                <th>نویسنده</th>
                                <th>تاریخ انتشار</th>
                                <th>بازدید</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($channelPosts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->channel->name ?? '-' }}</td>
                                    <td>{{ $post->author->name ?? '-' }}</td>
                                    <td>{{ $post->published_at ? $post->published_at->format('Y/m/d') : '-' }}</td>
                                    <td>{{ $post->view_count }}</td>
                                    <td>
                                        @if($post->status == 'published')
                                            <span class="badge badge-success">منتشر شده</span>
                                        @else
                                            <span class="badge badge-warning">پیش‌نویس</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.channelposts.edit', $post->id) }}" class="btn btn-sm btn-info">ویرایش</a>
                                        <form method="POST" action="{{ route('admin.channelposts.destroy', $post->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">پستی یافت نشد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    {{ $channelPosts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
