<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase {

    public function testGetEmail(): void {
        $user = new \App\Models\User('test@gmail.com', '12345', '22/03/2022');
        $this->assertSame("test@gmail.com",$user->getEmail());
    }

    public function testGetPwd(): void {
        $user = new \App\Models\User('test@gmail.com', '12345', '22/03/2022');
        $this->assertSame("12345",$user->getPwd());
    }

    public function testGetCreatedAt(): void {
        $user = new \App\Models\User('test@gmail.com', '12345', '22/03/2022');
        $this->assertSame("22/03/2022",$user->getCreatedAt());
    }
}