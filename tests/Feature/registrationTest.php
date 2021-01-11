<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class registrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_page_contains_livewire_component()
    {
        $this->get('/register')->assertSeeLivewire('auth.register');
    }

    /** @test */
    public function can_register()
    {
        Livewire::test('auth.register')
            ->set('email', 'test@gmail.com')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertRedirect('/');

        $this->assertTrue(User::whereEmail('test@gmail.com')->exists());
        $this->assertEquals('test@gmail.com', auth()->user()->email);
    }

    /** @test */
    public function email_is_required()
    {
        Livewire::test('auth.register')
            ->set('email', '')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_is_valid_email()
    {
        Livewire::test('auth.register')
            ->set('email', 'gfdfg')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'email']);
    }
    
    /** @test */
    public function email_hasnt_been_taken_already()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);
        
        Livewire::test('auth.register')
            ->set('email', 'test@gmail.com')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    public function see_email_hasnt_already_taken_validation_message_as_user_types()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);
        
        Livewire::test('auth.register')
            ->set('email', 'tes@gmail.com')
            ->assertHasNoErrors()
            ->set('email', 'test@gmail.com')
            ->assertHasErrors(['email' => 'unique']);
    }
    
    /** @test */
    public function password_is_required()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);
        
        Livewire::test('auth.register')
            ->set('email', 'test@gmail.com')
            ->set('password', '')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }
    
    /** @test */
    public function password_is_minimum_of_six_characters()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);
        
        Livewire::test('auth.register')
            ->set('email', 'test@gmail.com')
            ->set('password', '1234')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    public function password_matches_password_confirmation()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);
        
        Livewire::test('auth.register')
            ->set('email', 'test@gmail.com')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'azerty')
            ->call('register')
            ->assertHasErrors(['password' => 'same']);
    }
}
