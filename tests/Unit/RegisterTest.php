<?php

namespace Tests\Unit;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_dengan_data_valid(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Testname',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_register_dengan_nama_kosong(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);
    }

    public function test_register_dengan_email_kosong(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Testname',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.'
        ]);
    }

    public function test_register_dengan_password_kosong(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Testname',
            'email' => 'test@gmail.com',
            'password' => '',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field is required.'
        ]);
    }

    public function test_register_dengan_confirm_password_kosong(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Testname',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => '',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field confirmation does not match.'
        ]);
    }

    public function test_register_dengan_confirm_password_salah(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Testname',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'wrong-password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field confirmation does not match.'
        ]);
    }

    public function test_register_dengan_email_terdaftar(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }
        $user = User::factory()->create();

        $response = $this->post('/register', [
            'name' => 'Testname',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email has already been taken.'
        ]);
    }
}
