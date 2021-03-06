<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Phrase;
use AppBundle\Util\InvalidPhraseMessage;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PhraseTest extends KernelTestCase
{
    private $container;
    private $entity;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->container = $kernel->getContainer();
        $this->entity = new Phrase();
    }

    public function testUpdateGainCreateur()
    {
        $this->entity->setGainCreateur(0);

        $this->entity->updateGainCreateur(0);
        $this->assertEquals($this->entity->getGainCreateur(), 0);

        $this->entity->updateGainCreateur(100);
        $this->assertEquals($this->entity->getGainCreateur(), 100);

        $this->entity->updateGainCreateur(100);
        $this->assertEquals($this->entity->getGainCreateur(), 200);

        $this->entity->updateGainCreateur(-150);
        $this->assertEquals($this->entity->getGainCreateur(), 50);

        $this->entity->updateGainCreateur(-100);
        $this->assertEquals($this->entity->getGainCreateur(), 0);
    }

    public function testGetContenuAmb()
    {
        $this->entity->setContenu('<amb id="1">amb</amb>');
        $this->assertEquals('<amb>amb</amb>', $this->entity->getContenuAmb());

        $this->entity->setContenu('<amb id="1">amb</amb> <amb id="2">amb</amb>');
        $this->assertEquals('<amb>amb</amb> <amb>amb</amb>', $this->entity->getContenuAmb());

        $this->entity->setContenu('Un mot <amb id="1">amb</amb> puis un autre <amb id="2">amb</amb>.');
        $this->assertEquals('Un mot <amb>amb</amb> puis un autre <amb>amb</amb>.', $this->entity->getContenuAmb());
    }

    public function testGetContenuHTML()
    {
        $this->entity->setContenu('<amb id="1">amb</amb>');
        $expected = '<amb id="ma1" class="ma color-red" title="Ce mot est ambigu (id : 1)">amb</amb>';
        $this->assertEquals($expected, $this->entity->getContenuHTML());

        $this->entity->setContenu('<amb id="1">amb</amb> <amb id="2">amb</amb>');
        $expected = '<amb id="ma1" class="ma color-red" title="Ce mot est ambigu (id : 1)">amb</amb> <amb id="ma2" class="ma color-red" title="Ce mot est ambigu (id : 2)">amb</amb>';
        $this->assertEquals($expected, $this->entity->getContenuHTML());

        $this->entity->setContenu('Un mot <amb id="1">amb</amb> puis un autre <amb id="2">amb</amb>.');
        $expected = 'Un mot <amb id="ma1" class="ma color-red" title="Ce mot est ambigu (id : 1)">amb</amb> puis un autre <amb id="ma2" class="ma color-red" title="Ce mot est ambigu (id : 2)">amb</amb>.';
        $this->assertEquals($expected, $this->entity->getContenuHTML());
    }

    public function testNormalizePreValidation()
    {
        $this->entity->setContenu('');
        $this->entity->normalizePreValidation();
        $this->assertEquals('', $this->entity->getContenu());

        $this->entity->setContenu('perfect');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Perfect.', $this->entity->getContenu());

        $this->entity->setContenu('àççént');
        $this->entity->normalizePreValidation();
        $this->assertEquals('àççént.', $this->entity->getContenu());

        $this->entity->setContenu(' espace');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Espace.', $this->entity->getContenu());

        $this->entity->setContenu('espace ');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Espace.', $this->entity->getContenu());

        $this->entity->setContenu('  espace');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Espace.', $this->entity->getContenu());

        $this->entity->setContenu('espace  ');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Espace.', $this->entity->getContenu());

        $this->entity->setContenu('a<b>ah<b> <amb>c<br>ou<p>co</p>u</amb> test<br>');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Aah <amb>coucou</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb id="1">id</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb id=\'1\'>id</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb id=\'1\'>id</amb> test <amb id=\'2\'>id2</amb>');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test <amb id="2">id2</amb>.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb id="1" color="red">id</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb id="1" color="red" size="16px">id</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb  id="1"  color="red"  size="16px" >id</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb color="red" id="1">id</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb color="red" size="16px" id="1">id</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb  color="red"  size="16px"  id="1" >id</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('A <amb color="red" id="1" size="16px">id</amb> test <amb color="red" id="2" size="16px">id2</amb>');
        $this->entity->normalizePreValidation();
        $this->assertEquals('A <amb id="1">id</amb> test <amb id="2">id2</amb>.', $this->entity->getContenu());

        $this->entity->setContenu('<amb>majuscule</amb> test');
        $this->entity->normalizePreValidation();
        $this->assertEquals('<amb>Majuscule</amb> test.', $this->entity->getContenu());

        $this->entity->setContenu('plusieurs mots !');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Plusieurs mots !', $this->entity->getContenu());

        $this->entity->setContenu('plusieurs  mots ?');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Plusieurs mots ?', $this->entity->getContenu());

        $this->entity->setContenu('Un <amb id="1">test</amb> un <amb id="2">test</amb>.');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Un <amb id="1">test</amb> un <amb id="2">test</amb>.', $this->entity->getContenu());

        $this->entity->setContenu('Un <amb id="5">test</amb> un <amb id="3">test</amb>.');
        $this->entity->normalizePreValidation();
        $this->assertEquals('Un <amb id="5">test</amb> un <amb id="3">test</amb>.', $this->entity->getContenu());
    }

    private function tryIsValidFalseEquals($p) {
        $res = $this->entity->isValid();
        $this->assertFalse($res['succes']);
        $this->assertEquals($p, $res['message']);
    }

    private function tryIsValidFalseContains($p) {
        $res = $this->entity->isValid();
        $this->assertFalse($res['succes']);
        $this->assertStringContainsString($p, $res['message']);
    }

    public function testIsValid()
    {
        $this->entity->setContenu('');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$EMPTY_PHRASE);

        $this->entity->setContenu('<b>test test</b>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$ONLY_AMB_TAG);

        $this->entity->setContenu('<amb id="1">test<amb id="2">test</amb>test</amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$NESTED_AMB_TAG);

        $this->entity->setContenu('<amb>test</amb> <amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$WRONG_NB_AMB_TAG);

        $this->entity->setContenu('</amb> <amb>test</amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$WRONG_NB_AMB_TAG);

        $this->entity->setContenu('test test test test');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$NB_AMB_MIN);

        $this->entity->setContenu('<amb id="1">1</amb><amb id="2">2</amb><amb id="3">3</amb><amb id="4">4</amb><amb id="5">5</amb><amb id="6">6</amb><amb id="7">7</amb><amb id="8">8</amb><amb id="9">9</amb><amb id="10">10</amb><amb id="11">11</amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$NB_AMB_MAX);

        $this->entity->setContenu('<amb id="1">1</amb> test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test');
        $this->tryIsValidFalseContains(InvalidPhraseMessage::$NB_CHAR_MAX);

        $this->entity->setContenu('a<amb id="1">1</amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$WRONG_SELECT_EXT);

        $this->entity->setContenu('<amb id="1">1</amb>a');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$WRONG_SELECT_EXT);

        $this->entity->setContenu('a<amb id="1">1</amb>a');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$WRONG_SELECT_EXT);

        $this->entity->setContenu('<amb id="1"> 1</amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$WRONG_SELECT_INT);

        $this->entity->setContenu('<amb id="1">1 </amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$WRONG_SELECT_INT);

        $this->entity->setContenu('<amb id="1"> 1 </amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$WRONG_SELECT_INT);

        $this->entity->setContenu('<amb id="1">1</amb> <amb id="1">1</amb>');
        $this->tryIsValidFalseEquals(InvalidPhraseMessage::$SAME_ID_AMB);
    }

    private function tryNormalizePostValidationTrueEquals($p) {
        $this->entity->normalizePostValidation();
        $this->assertEquals($p, $this->entity->getContenu());
    }

    public function testNormalizePostValidation()
    {
        $this->entity->setContenu('Avant <amb id="2">2</amb>');
        $this->tryNormalizePostValidationTrueEquals('Avant <amb id="1">2</amb>');

        $this->entity->setContenu('<amb id="2">2</amb> après.');
        $this->tryNormalizePostValidationTrueEquals('<amb id="1">2</amb> après.');

        $this->entity->setContenu('Avant <amb id="2">2</amb> après.');
        $this->tryNormalizePostValidationTrueEquals('Avant <amb id="1">2</amb> après.');

        $this->entity->setContenu('Avant <amb id="2">2</amb> test à@&é <amb id="1">1</amb> après.');
        $this->tryNormalizePostValidationTrueEquals('Avant <amb id="1">2</amb> test à@&é <amb id="2">1</amb> après.');

        $this->entity->setContenu('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');
        $this->tryNormalizePostValidationTrueEquals('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');

        $this->entity->setContenu('1 <amb id="3">test</amb> 2 <amb id="2">test</amb> 3 <amb id="1">test</amb> 4.');
        $this->tryNormalizePostValidationTrueEquals('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');

        $this->entity->setContenu('1 <amb id="2">test</amb> 2 <amb id="1">test</amb> 3 <amb id="3">test</amb> 4.');
        $this->tryNormalizePostValidationTrueEquals('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');

        $this->entity->setContenu('1 <amb id="2">test</amb> 2 <amb id="3">test</amb> 3 <amb id="1">test</amb> 4.');
        $this->tryNormalizePostValidationTrueEquals('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');

        $this->entity->setContenu('1 <amb id="3">test</amb> 2 <amb id="1">test</amb> 3 <amb id="2">test</amb> 4.');
        $this->tryNormalizePostValidationTrueEquals('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');

        $this->entity->setContenu('1 <amb id="1">test</amb> 2 <amb id="3">test</amb> 3 <amb id="2">test</amb> 4.');
        $this->tryNormalizePostValidationTrueEquals('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');

        $this->entity->setContenu('1 <amb id="2">test</amb> 2 <amb id="4">test</amb> 3 <amb id="6">test</amb> 4.');
        $this->tryNormalizePostValidationTrueEquals('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');

        $this->entity->setContenu('1 <amb id="6">test</amb> 2 <amb id="4">test</amb> 3 <amb id="2">test</amb> 4.');
        $this->tryNormalizePostValidationTrueEquals('1 <amb id="1">test</amb> 2 <amb id="2">test</amb> 3 <amb id="3">test</amb> 4.');
    }

}
