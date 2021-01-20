<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('My Crazy Guestbook ');
        $I->seeLink('About');
        $I->click('About');
        $I->see('About');
        $I->seeLink('Add new comment');
        $I->see('Add new comment');
    }
}