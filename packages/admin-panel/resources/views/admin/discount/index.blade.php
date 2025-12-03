@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مدیریت کدهای تخفیف</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.discount.create') }}" class="btn btn-primary">
                            کد تخفیف جدید
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    {{-- Search Form --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="جستجوی کد..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="type" class="form-control">
                                    <option value="">همه انواع</option>
                                    <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>درصدی</option>
                                    <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>منقضی شده</option>
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
                                <th>کد</th>
                                <th>نوع</th>
                                <th>مقدار</th>
                                <th>تاریخ شروع</th>
                                <th>تاریخ پایان</th>
                                <th>استفاده شده</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->id }}</td>
                                    <td><strong>{{ $discount->code }}</strong></td>
                                    <td>
                                        @if($discount->type == 'percentage')
                                            <span class="badge badge-info">درصدی</span>
                                        @else
                                            <span class="badge badge-secondary">مبلغ ثابت</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $discount->value }}
                                        @if($discount->type == 'percentage')
                                            %
                                        @else
                                            تومان
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($discount->start_date)->format('Y/m/d') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($discount->end_date)->format('Y/m/d') }}</td>
                                    <td>{{ $discount->used_count }}</td>
                                    <td>
                                        @if($discount->isValid())
                                            <span class="badge badge-success">فعال</span>
                                        @elseif($discount->isExpired())
                                            <span class="badge badge-danger">منقضی شده</span>
                                        @else
                                            <span class="badge badge-warning">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.discount.edit', $discount->id) }}" class="btn btn-sm btn-info">ویرایش</a>
                                        <form method="POST" action="{{ route('admin.discount.destroy', $discount->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">کد تخفیفی یافت نشد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    {{ $discounts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
