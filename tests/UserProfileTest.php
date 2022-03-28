<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Models\UserProfile;

final class UserProfileTest extends TestCase {

    public function testName() {
        $profile = new UserProfile('Artis', 'Smirnovs', '26/12/2001', 4);
        $this->assertSame('Artis',$profile->getName());
    }

    public function testSurname() {
        $profile = new UserProfile('Artis', 'Smirnovs', '26/12/2001', 4);
        $this->assertSame('Smirnovs',$profile->getSurname());
    }

    public function testGetBirthday() {
        $profile = new UserProfile('Artis', 'Smirnovs', '26/12/2001', 4);
        $this->assertSame('26/12/2001',$profile->getBirthday());
    }

    public function testGetUserID() {
        $profile = new UserProfile('Artis', 'Smirnovs', '26/12/2001', 4);
        $this->assertSame(4,$profile->getUserID());
    }

}