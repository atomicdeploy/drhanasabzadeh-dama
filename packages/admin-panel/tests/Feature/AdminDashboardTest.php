<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    /**
     * Test that admin dashboard loads successfully.
     *
     * @return void
     */
    public function test_admin_dashboard_loads()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('داشبورد');
        $response->assertSee('پنل مدیریت');
    }

    /**
     * Test that admin dashboard route is registered.
     *
     * @return void
     */
    public function test_admin_dashboard_route_exists()
    {
        $this->assertTrue(
            \Route::has('admin.dashboard'),
            'Admin dashboard route should exist'
        );
    }

    /**
     * Test that static assets paths are accessible.
     *
     * @return void
     */
    public function test_static_assets_exist()
    {
        $this->assertFileExists(
            public_path('adminassets/css/style.bundle.rtl.css'),
            'Main CSS file should exist'
        );
        
        $this->assertFileExists(
            public_path('adminassets/js/scripts.bundle.js'),
            'Main JS file should exist'
        );
    }

    /**
     * Test that crawled HTML pages exist.
     *
     * @return void
     */
    public function test_crawled_html_pages_exist()
    {
        $this->assertFileExists(
            resource_path('static-html/dashboard.html'),
            'Dashboard HTML snapshot should exist'
        );
        
        $htmlFiles = glob(resource_path('static-html/*.html'));
        $this->assertGreaterThanOrEqual(
            40,
            count($htmlFiles),
            'At least 40 HTML pages should be available'
        );
    }
}
