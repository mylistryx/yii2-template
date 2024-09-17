<?php

namespace tests\unit\models;

use app\models\Identity;
use Codeception\Test\Unit;

class UserTest extends Unit
{
    public function testFindUserById()
    {
        verify($user = Identity::findIdentity(100))->notEmpty();
        verify($user->username)->equals('admin');

        verify(Identity::findIdentity(999))->empty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = Identity::findIdentityByAccessToken('100-token'))->notEmpty();
        verify($user->username)->equals('admin');

        verify(Identity::findIdentityByAccessToken('non-existing'))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = Identity::findByUsername('admin'))->notEmpty();
        verify(Identity::findByUsername('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = Identity::findByUsername('admin');
        verify($user->validateAuthKey('test100key'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('admin'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();        
    }

}
