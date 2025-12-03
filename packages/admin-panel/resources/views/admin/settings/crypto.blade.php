@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تنظیمات ارز دیجیتال</h3>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.settings.crypto.update') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label class="d-flex align-items-center">
                                <input type="checkbox" name="crypto_enabled" value="1" {{ ($settings['crypto_enabled'] ?? false) ? 'checked' : '' }}>
                                <span class="mr-2">فعال بودن پرداخت با ارز دیجیتال</span>
                            </label>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>آدرس کیف پول</label>
                                    <input type="text" name="crypto_wallet_address" class="form-control" value="{{ $settings['crypto_wallet_address'] ?? '' }}" placeholder="آدرس کیف پول شما">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ارز</label>
                                    <select name="crypto_currency" class="form-control">
                                        <option value="USDT" {{ ($settings['crypto_currency'] ?? '') == 'USDT' ? 'selected' : '' }}>USDT</option>
                                        <option value="BTC" {{ ($settings['crypto_currency'] ?? '') == 'BTC' ? 'selected' : '' }}>BTC</option>
                                        <option value="ETH" {{ ($settings['crypto_currency'] ?? '') == 'ETH' ? 'selected' : '' }}>ETH</option>
                                        <option value="TRX" {{ ($settings['crypto_currency'] ?? '') == 'TRX' ? 'selected' : '' }}>TRX</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>شبکه</label>
                                    <select name="crypto_network" class="form-control">
                                        <option value="TRC20" {{ ($settings['crypto_network'] ?? '') == 'TRC20' ? 'selected' : '' }}>TRC20</option>
                                        <option value="ERC20" {{ ($settings['crypto_network'] ?? '') == 'ERC20' ? 'selected' : '' }}>ERC20</option>
                                        <option value="BEP20" {{ ($settings['crypto_network'] ?? '') == 'BEP20' ? 'selected' : '' }}>BEP20</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i>
                            پس از فعال‌سازی، کاربران می‌توانند با ارز دیجیتال پرداخت کنند. اطمینان حاصل کنید که آدرس کیف پول صحیح است.
                        </div>
                        
                        <button type="submit" class="btn btn-primary">ذخیره تنظیمات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
