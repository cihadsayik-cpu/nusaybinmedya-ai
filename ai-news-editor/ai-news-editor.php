<?php

namespace AINE\Admin;

defined('ABSPATH') || exit;


class Admin
{

    public function menu()
    {

        add_menu_page(
            'AI News Editor',
            'AI News Editor',
            'manage_options',
            'ai-news-editor',
            [
                $this,
                'dashboard'
            ],
            'dashicons-admin-site-alt3',
            25
        );


        add_submenu_page(
            'ai-news-editor',
            'AI Ayarları',
            'Ayarlar',
            'manage_options',
            'ai-news-editor-settings',
            [
                $this,
                'settings'
            ]
        );

    }



    public function dashboard()
    {

        require AINE_PATH . 'templates/dashboard.php';

    }



    public function settings()
    {

        require AINE_PATH . 'templates/settings.php';

    }

}
