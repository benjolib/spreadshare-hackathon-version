<?php

namespace SpreadShareTests;

use SpreadShareTests\AcceptanceTester;

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->haveInDatabase('user', [
            'id' => 1,
            'handle' => 'antonio',
            'name' => 'antonio',
            'email' => 'contact@antoniohs.com',
            'securitySalt' => '$2y$08$cVE1OHNtc3NOc2pmZ3BJMuZCNtDPqp0PLxQnvm2kawlzs13kPNSz.',
            'image' => '/assets/images/jim_hopper.png',
            'emailConfirmationToken' => 'x1RhxhNGFbVrpbVtrZGCswymyba1wz',
            'lastSessionId' => 'rkr0l5m6jl2435eeniav8579h2',
            'lastLogin' => '1526563546',
            'confirmed' => '1',
            'status' => '1',
            'createdAt' => '1526563509',
        ]);

    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function loginWithWrongCredentials(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('username', 'antonio');
        $I->fillField('password', 'antowrongpass');
        $I->click('button[type=submit]');
        $I->seeResponseCodeIs(200);
        $I->see('Invalid username or password');
    }

    // tests
    public function loginWithCorrectCredentials(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('username', 'antonio');
        $I->fillField('password', 'antopass');
        $I->click('button[type=submit]');
        $I->seeResponseCodeIs(200);
        $I->dontSee('Join with');
//        $I->seeInSource('re-hearder__user');
//        $I->seeElement('img', ['src' => '/assets/images/jim_hopper.png']);
    }
}
