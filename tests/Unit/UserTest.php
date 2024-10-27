<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_user_with_attributes()
    {
        $user = new User([
            'name' => 'Eliezer Buczak',
            'email' => 'eliezerbuczak@example.com',
            'password' => bcrypt('test123'),
        ]);

        $this->assertEquals('Eliezer Buczak', $user->name);
        $this->assertEquals('eliezerbuczak@example.com', $user->email);
        $this->assertTrue(Hash::check('test123', $user->password));
    }

    #[Test]
    public function it_hashes_password_correctly_when_saving()
    {
        $user = User::create([
            'name' => 'Eliezer Buczak',
            'email' => 'eliezerbuczak@example.com',
            'password' => 'test123',
        ]);

        $this->assertTrue(Hash::check('test123', $user->password));
    }

    #[Test]
    public function it_hides_sensitive_attributes_when_serialized()
    {
        $user = User::factory()->make([
            'password' => 'hidden_password',
        ]);

        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }
}
