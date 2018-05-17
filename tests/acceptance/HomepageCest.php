<?php
namespace SpreadShareTests;
use SpreadShareTests\AcceptanceTester;

class HomepageCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Explore');
    }
}
