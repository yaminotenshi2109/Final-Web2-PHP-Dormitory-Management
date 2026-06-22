<?php
/**
 * app/controllers/HomeController.php
 * ─────────────────────────────────────────────────────────────
 *  Controller home page and about page.
 */

declare(strict_types=1);

class HomeController extends BaseController
{
    public function index(array $params = []): void
    {
        $this->view('home/index', [
            'title'     => 'Trang chủ',
            'pageClass' => 'page-body--landing',
            'extraCss'  => ['/assets/css/landing.css'],
            'navClass'  => 'public-navbar--landing',
        ]);
    }

    public function about(array $params = []): void
    {
        $this->view('home/about', [
            'title'     => 'Giới thiệu',
            'pageClass' => 'page-body--landing',
            'extraCss'  => ['/assets/css/landing.css'],
            'navClass'  => 'public-navbar--landing',
        ]);
    }
}
