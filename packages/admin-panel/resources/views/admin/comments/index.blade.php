@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مدیریت نظرات</h3>
                </div>
                
                <div class="card-body">
                    {{-- Search Form --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="جستجو در متن نظرات..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>تایید شده</option>
                                    <option value="spam" {{ request('status') == 'spam' ? 'selected' : '' }}>هرزنامه</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="rating" class="form-control">
                                    <option value="">همه امتیازها</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} ستاره</option>
                                    @endfor
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

                    {{-- Data Table --}}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>دوره/محتوا</th>
                                <th>کاربر</th>
                                <th>متن نظر</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>
                                        @if($comment->commentable)
                                            {{ $comment->commentable->title ?? 'نامشخص' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($comment->user)
                                            <a href="{{ route('admin.userlist') }}">{{ $comment->user->name ?? $comment->user->mobile }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($comment->content, 100) }}</td>
                                    <td>{{ $comment->created_at->format('Y/m/d H:i') }}</td>
                                    <td>
                                        @if($comment->status == 'pending')
                                            <span class="badge badge-warning">در انتظار تایید</span>
                                        @elseif($comment->status == 'approved')
                                            <span class="badge badge-success">تایید شده</span>
                                        @elseif($comment->status == 'spam')
                                            <span class="badge badge-danger">هرزنامه</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.comment.edit', $comment->id) }}" class="btn btn-sm btn-clean" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($comment->status == 'pending')
                                            <a href="{{ route('admin.comment.approve', $comment->id) }}" class="btn btn-sm btn-success" title="تایید">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.comment.destroy', $comment->id) }}" 
                                           class="btn btn-sm btn-danger" 
                                           title="حذف"
                                           onclick="return confirm('از حذف این نظر اطمینان دارید؟')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">نظری یافت نشد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
