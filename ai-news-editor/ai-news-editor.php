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
includes/class-openai.php
    <?php

namespace AINE;

defined('ABSPATH') || exit;


class OpenAI
{

    private $api_key;

    private $endpoint = 'https://api.openai.com/v1/chat/completions';


    public function __construct()
    {

        $this->api_key = get_option(
            'aine_openai_key'
        );

    }



    public function generate($prompt)
    {

        if(empty($this->api_key))
        {
            return [
                'error' => 'OpenAI API anahtarı bulunamadı.'
            ];
        }


        $body = [
            'model' => 'gpt-4.1-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Sen profesyonel bir haber editörüsün.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.7
        ];



        $response = wp_remote_post(
            $this->endpoint,
            [
                'headers'=>[
                    'Content-Type'=>'application/json',
                    'Authorization'=>'Bearer '.$this->api_key
                ],

                'body'=>json_encode($body),

                'timeout'=>60
            ]
        );



        if(is_wp_error($response))
        {

            return [
                'error'=>$response->get_error_message()
            ];

        }



        $data = json_decode(
            wp_remote_retrieve_body($response),
            true
        );



        if(isset($data['choices'][0]['message']['content']))
        {

            return [
                'success'=>true,
                'content'=>$data['choices'][0]['message']['content']
            ];

        }


        return [
            'error'=>'AI cevap üretilemedi.'
        ];

    }


}
admin/class-ai-test.php
    <?php

namespace AINE\Admin;

use AINE\OpenAI;


defined('ABSPATH') || exit;


class AITest
{


    public function register()
    {

        add_action(
            'admin_post_aine_test_ai',
            [
                $this,
                'test'
            ]
        );

    }



    public function test()
    {


        if(!current_user_can('manage_options'))
        {
            wp_die('Yetki yok');
        }



        check_admin_referer(
            'aine_test_ai'
        );



        $ai = new OpenAI();



        $result = $ai->generate(
            'Bana kısa bir teknoloji haberi başlığı yaz.'
        );



        update_option(
            'aine_last_test',
            $result
        );


        wp_redirect(
            admin_url(
                'admin.php?page=ai-news-editor'
            )
        );


        exit;

    }


}require_once AINE_PATH . 'admin/class-ai-test.php';
$admin = new \AINE\Admin\Admin();
$ai_test = new \AINE\Admin\AITest();

$ai_test->register();
templates/dashboard.php
    <hr>

<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">

<input type="hidden" name="action" value="aine_test_ai">

<?php wp_nonce_field('aine_test_ai'); ?>

<button class="button button-primary">
AI Test Et
</button>

</form>
