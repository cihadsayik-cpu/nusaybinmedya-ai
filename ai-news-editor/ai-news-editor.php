<?php
/**
 * Plugin Name: AI News Editor
 * Description: AI destekli WordPress haber editörü.
 * Version: 0.1.0
 * Author: Cihat Şayık
 * License: GPL v2 or later
 * Text Domain: ai-news-editor
 */

if (!defined('ABSPATH')) {
    exit;
}

define('AINE_VERSION', '0.1.0');
define('AINE_PATH', plugin_dir_path(__FILE__));
define('AINE_URL', plugin_dir_url(__FILE__));

require_once AINE_PATH . 'includes/class-loader.php';
require_once AINE_PATH . 'admin/class-admin.php';
require_once AINE_PATH . 'includes/class-plugin.php';


function aine_start()
{
    $plugin = new AINE\Plugin();
    $plugin->run();
}

add_action('plugins_loaded', 'aine_start');
includes/class-plugin.php
  <?php

namespace AINE;

defined('ABSPATH') || exit;


class Plugin
{

    public function run()
    {

        $admin = new \AINE\Admin\Admin();

        add_action(
            'admin_menu',
            [
                $admin,
                'menu'
            ]
        );

    }

}
admin/class-admin.php
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


    }



    public function dashboard()
    {

        ?>

        <div class="wrap">

            <h1>
                AI News Editor
            </h1>


            <div class="card">

                <h2>
                    Hoş Geldiniz
                </h2>


                <p>
                    Yapay zeka destekli haber analiz sistemi hazırlanıyor.
                </p>


                <hr>


                <h3>
                    Sistem Durumu
                </h3>


                <ul>

                    <li>✔ WordPress bağlantısı aktif</li>

                    <li>✔ Admin panel aktif</li>

                    <li>⏳ AI Motoru bekleniyor</li>

                    <li>⏳ SEO Analizi bekleniyor</li>

                </ul>


            </div>


        </div>

        <?php

    }

}
includes/class-loader.php
  uninstall.php
  <?php

defined('WP_UNINSTALL_PLUGIN') || exit;

admin/class-settings.php
  admin/settings-page.php
  includes/class-openai.php
