@extends('layouts.admin')

@section('title', 'مدیریت سفارشات')

@section('page-title', 'مدیریت سفارشات')

@section('content')
{{-- Statistics Cards --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">کل سفارشات</h5>
                <h2>{{ number_format($stats['total']) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">تکمیل شده</h5>
                <h2>{{ number_format($stats['completed']) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">در انتظار</h5>
                <h2>{{ number_format($stats['pending']) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">کل درآمد</h5>
                <h2>{{ number_format($stats['total_revenue']) }} تومان</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">لیست سفارشات</h3>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Search Form --}}
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="شماره سفارش، نام کاربر..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>در حال پردازش</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="from_date" class="form-control" placeholder="از تاریخ" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control" placeholder="تا تاریخ" value="{{ request('to_date') }}">
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
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>شماره سفارش</th>
                                <th>کاربر</th>
                                <th>مبلغ</th>
                                <th>روش پرداخت</th>
                                <th>وضعیت</th>
                                <th>تاریخ</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>
                                        @if($order->user)
                                            <a href="{{ route('admin.user.show', $order->user->id) }}">
                                                {{ $order->user->name }} ({{ $order->user->mobile }})
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ number_format($order->total_amount) }} تومان</td>
                                    <td>
                                        @if($order->payment_method == 'gateway')
                                            درگاه
                                        @elseif($order->payment_method == 'card_to_card')
                                            کارت به کارت
                                        @elseif($order->payment_method == 'wallet')
                                            کیف پول
                                        @else
                                            {{ $order->payment_method }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge badge-warning">در انتظار</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge badge-info">در حال پردازش</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge badge-success">تکمیل شده</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge badge-danger">لغو شده</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-info" title="نمایش">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        سفارشی یافت نشد
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
