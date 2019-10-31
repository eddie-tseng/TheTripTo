<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignupTest extends TestCase
{
    use RefreshDatabase;

    public function testSignup_PositiveTest()
    {
        $this->post('/sign-up', [
            'account' => 'test@mail.com',
            'password' => '88888888',
            'password_confirmation' => '88888888',
            'first_name' => 'unit',
            'last_name' => 'test',
            'phone' => '0000000',
            ])
            ->assertRedirect('/')
            ->assertSessionHasNoErrors();
    }


    public function testSignup_NegativeTest()
    {
        //password fail
        $this->post('/sign-up', [
            'account' => 'testmail.com',
            'password' => '88888888',
            'password_confirmation' => '88888888',
            'first_name' => 'unit',
            'last_name' => 'test',
            'phone' => '0000000',
            ])
            ->assertRedirect('/sign-up')
            ->assertSessionHasErrors();

        //inconsistent password
        $this->post('/sign-up', [
            'account' => 'test@mail.com',
            'password' => '88888888',
            'password_confirmation' => '8',
            'first_name' => 'unit',
            'last_name' => 'test',
            'phone' => '0000000',
            ])
            ->assertRedirect('/sign-up')
            ->assertSessionHasErrors();

        //password fail
        $this->post('/sign-up', [
            'account' => 'test@mail.com',
            'password' => '8',
            'password_confirmation' => '8',
            'first_name' => 'unit',
            'last_name' => 'test',
            'phone' => '0000000',
            ])
            ->assertRedirect('/sign-up')
            ->assertSessionHasErrors();

        //first_name fail
        $this->post('/sign-up', [
            'account' => 'test@mail.com',
            'password' => '88888888',
            'password_confirmation' => '88888888',
            'first_name' => '',
            'last_name' => 'test',
            'phone' => '0000000',
            ])
            ->assertRedirect('/sign-up')
            ->assertSessionHasErrors();

        //last_name fail
        $this->post('/sign-up', [
            'account' => 'test@mail.com',
            'password' => '88888888',
            'password_confirmation' => '88888888',
            'first_name' => 'unit',
            'last_name' => '',
            'phone' => '0000000',
            ])
            ->assertRedirect('/sign-up')
            ->assertSessionHasErrors();
    }
}
