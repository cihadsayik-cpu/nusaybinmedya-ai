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


templates


    dashboard.php
settings.php
    <div class="wrap">

<h1>AI News Editor</h1>

<div class="card">

<h2>Sistem Durumu</h2>

<ul>

<li>✅ WordPress Bağlantısı</li>

<li>✅ Yönetim Paneli</li>

<li>⏳ AI Motoru</li>

<li>⏳ SEO Analizi</li>

<li>⏳ Rank Math Entegrasyonu</li>

</ul>

</div>

</div>
    <div class="wrap">

<h1>AI News Editor Ayarları</h1>


<form method="post" action="options.php">

<?php

settings_fields('aine_settings');

do_settings_sections('ai-news-editor-settings');

submit_button();

?>

</form>


</div>
includes/class-openai.php
<?php

namespace AINE;

defined('ABSPATH') || exit;


class OpenAI
{


    private $api_key;


    public function __construct()
    {

        $this->api_key = get_option(
            'aine_openai_key'
        );

    }



    public function ask($prompt)
    {

        if(empty($this->api_key))
        {
            return 'API anahtarı bulunamadı';
        }


        return 'AI bağlantısı hazır';

    }


}
