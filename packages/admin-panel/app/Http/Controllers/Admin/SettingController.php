<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Display general settings.
     */
    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update general settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'social_instagram' => 'nullable|url',
            'social_telegram' => 'nullable|url',
            'social_whatsapp' => 'nullable|string',
        ]);

        $this->saveSettings($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'تنظیمات با موفقیت ذخیره شد');
    }

    /**
     * Display counseling settings.
     */
    public function counseling()
    {
        $settings = $this->getSettings('counseling');
        return view('admin.settings.counseling', compact('settings'));
    }

    /**
     * Update counseling settings.
     */
    public function updateCounseling(Request $request)
    {
        $validated = $request->validate([
            'counseling_enabled' => 'boolean',
            'counseling_price' => 'required|numeric|min:0',
            'counseling_duration' => 'required|integer|min:15',
            'counseling_description' => 'nullable|string',
            'available_days' => 'nullable|array',
            'available_hours_start' => 'nullable|string',
            'available_hours_end' => 'nullable|string',
        ]);

        $this->saveSettings($validated, 'counseling');

        return redirect()->route('admin.settings.counseling')
            ->with('success', 'تنظیمات مشاوره با موفقیت ذخیره شد');
    }

    /**
     * Display crypto payment settings.
     */
    public function crypto()
    {
        $settings = $this->getSettings('crypto');
        return view('admin.settings.crypto', compact('settings'));
    }

    /**
     * Update crypto settings.
     */
    public function updateCrypto(Request $request)
    {
        $validated = $request->validate([
            'crypto_enabled' => 'boolean',
            'crypto_wallet_address' => 'nullable|string|max:255',
            'crypto_currency' => 'nullable|string|max:10',
            'crypto_network' => 'nullable|string|max:50',
        ]);

        $this->saveSettings($validated, 'crypto');

        return redirect()->route('admin.settings.crypto')
            ->with('success', 'تنظیمات ارز دیجیتال با موفقیت ذخیره شد');
    }

    /**
     * Display slider management.
     */
    public function sliders()
    {
        $sliders = $this->getSettings('sliders') ?? [];
        return view('admin.settings.sliders', compact('sliders'));
    }

    /**
     * Update sliders.
     */
    public function updateSliders(Request $request)
    {
        $validated = $request->validate([
            'sliders' => 'nullable|array',
            'sliders.*.image' => 'required|string',
            'sliders.*.link' => 'nullable|string',
            'sliders.*.title' => 'nullable|string|max:255',
            'sliders.*.order' => 'nullable|integer',
        ]);

        $this->saveSettings($validated['sliders'] ?? [], 'sliders');

        return redirect()->route('admin.settings.sliders')
            ->with('success', 'اسلایدرها با موفقیت ذخیره شد');
    }

    /**
     * Display notices settings.
     */
    public function notices()
    {
        $notices = $this->getSettings('notices') ?? [];
        return view('admin.settings.notices', compact('notices'));
    }

    /**
     * Update notices.
     */
    public function updateNotices(Request $request)
    {
        $validated = $request->validate([
            'notices' => 'nullable|array',
            'notices.*.title' => 'required|string|max:255',
            'notices.*.content' => 'required|string',
            'notices.*.type' => 'required|in:info,warning,success,danger',
            'notices.*.active' => 'boolean',
        ]);

        $this->saveSettings($validated['notices'] ?? [], 'notices');

        return redirect()->route('admin.settings.notices')
            ->with('success', 'اطلاعیه‌ها با موفقیت ذخیره شد');
    }

    /**
     * Display satisfaction survey settings.
     */
    public function satisfaction()
    {
        $settings = $this->getSettings('satisfaction');
        return view('admin.settings.satisfaction', compact('settings'));
    }

    /**
     * Update satisfaction settings.
     */
    public function updateSatisfaction(Request $request)
    {
        $validated = $request->validate([
            'satisfaction_enabled' => 'boolean',
            'satisfaction_questions' => 'nullable|array',
            'satisfaction_email_notify' => 'boolean',
        ]);

        $this->saveSettings($validated, 'satisfaction');

        return redirect()->route('admin.settings.satisfaction')
            ->with('success', 'تنظیمات نظرسنجی با موفقیت ذخیره شد');
    }

    /**
     * Display subscriptions settings.
     */
    public function subscriptions()
    {
        $settings = $this->getSettings('subscriptions');
        return view('admin.settings.subscriptions', compact('settings'));
    }

    /**
     * Update subscriptions settings.
     */
    public function updateSubscriptions(Request $request)
    {
        $validated = $request->validate([
            'subscription_enabled' => 'boolean',
            'subscription_plans' => 'nullable|array',
            'subscription_plans.*.name' => 'required|string|max:255',
            'subscription_plans.*.price' => 'required|numeric|min:0',
            'subscription_plans.*.duration_days' => 'required|integer|min:1',
            'subscription_plans.*.features' => 'nullable|array',
        ]);

        $this->saveSettings($validated, 'subscriptions');

        return redirect()->route('admin.settings.subscriptions')
            ->with('success', 'تنظیمات اشتراک با موفقیت ذخیره شد');
    }

    /**
     * Display appearance settings.
     */
    public function appearance()
    {
        $settings = $this->getSettings('appearance');
        return view('admin.settings.appearance', compact('settings'));
    }

    /**
     * Update appearance settings.
     */
    public function updateAppearance(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
        ]);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('appearance', 'public');
        }
        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store('appearance', 'public');
        }

        $this->saveSettings($validated, 'appearance');

        return redirect()->route('admin.settings.appearance')
            ->with('success', 'تنظیمات ظاهری با موفقیت ذخیره شد');
    }

    /**
     * Get settings from storage.
     */
    private function getSettings($group = 'general')
    {
        $path = storage_path("app/settings/{$group}.json");
        if (File::exists($path)) {
            return json_decode(File::get($path), true);
        }
        return [];
    }

    /**
     * Save settings to storage.
     */
    private function saveSettings($data, $group = 'general')
    {
        $path = storage_path('app/settings');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
        
        File::put("{$path}/{$group}.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        // Clear cache
        Cache::forget("settings.{$group}");
    }
}
