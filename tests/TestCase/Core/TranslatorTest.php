<?php
declare(strict_types=1);

/**
 * BEdita, API-first content management framework
 * Copyright 2023 Atlas Srl, Chialab Srl
 *
 * This file is part of BEdita: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See LICENSE.LGPL or <http://gnu.org/licenses/lgpl-3.0.html> for more details.
 */
namespace BEdita\I18n\Google\Test\Core;

use BEdita\I18n\Google\Core\Translator;
use Cake\TestSuite\TestCase;
use Google\TextResult;
use Google\Cloud\Translate\V2\TranslateClient;

/**
 * {@see \BEdita\I18n\Google\Core\Translator} Test Case
 *
 * @covers \BEdita\I18n\Google\Core\Translator
 */
class TranslatorTest extends TestCase
{
    /**
     * Test setup.
     *
     * @return void
     * @covers ::setup()
     */
    public function testSetup(): void
    {
        $translator = new class extends Translator {
            public function getGoogleClient(): TranslateClient
            {
                return $this->googleClient;
            }
        };
        $translator->setup(['auth_key' => 'test-auth-key']);
        static::assertNotEmpty($translator->getGoogleClient());
    }

    /**
     * Test translate.
     *
     * @return void
     * @covers ::translate()
     */
    public function testTranslate(): void
    {
        $translator = new class extends Translator {
            public function setup(array $options = []): void
            {
                $this->googleClient = new class extends TranslateClient
                {
                    /**
                     * @inheritDoc
                     */
                    public function translate($text, array $options = []): ?array
                    {
                        return ['translation of ' . $text . ' from ' . $options['source'] . ' to ' . $options['target']];
                    }
                };
            }
        };
        $translator->setup([]);
        $actual = $translator->translate(['Hello world!'], 'en', 'it');
        $expected = json_encode([
            'translation' => [
                'translation of ["Hello world!"] from en to it',
            ],
        ]);
        static::assertEquals($expected, $actual);
    }
}
