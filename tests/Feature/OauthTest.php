<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\User;
use Laravel\Passport\Client as OauthClient;
use Illuminate\Support\Facades\Hash;

class OauthTest extends TestCase
{

    /**
     * Test the login with passport
     *
     * @return void
     */
    public function testOauthLogin()
    {
        $pw = 'qwerty';
        $user = factory(User::class)->create([
            'password' => Hash::make($pw)
        ]);
        $oauthClient = OauthClient::where('password_client', 1)->first();
        $body = [
            'username' => $user->email,
            'password' => $pw,
            'client_id' => $oauthClient->id,
            'client_secret' => $oauthClient->secret,
            'grant_type' => 'password',
            'scope' => '*'
        ];

        $this->post('/oauth/token', $body)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
                'oauth' => [
                    'token_type',
                    'expires_in',
                    'access_token',
                    'refresh_token',
                ],
            ]);
    }
}
