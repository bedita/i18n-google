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
namespace BEdita\I18n\Google\Core;

use BEdita\I18n\Core\TranslatorInterface;
use Cake\Utility\Hash;
use Google\Cloud\Translate\V2\TranslateClient;

/**
 * Translator class that uses Google.
 *
 * This class uses the Google API to translate texts.
 * Pass a valid 'auth_key' to the options array to use this engine.
 * Example:
 * ```
 * use BEdita\I18n\Google\Core\Translator;
 * [...]
 * $translator = new Translator();
 * $translator->setup(['auth_key' => 'your-auth-key']);
 * $translation = $translator->translate(['Hello world!'], 'en', 'it');
 * ```
 */
class Translator implements TranslatorInterface
{
    /**
     * The Google API client.
     *
     * @var \Google\Cloud\Translate\V2\TranslateClient
     */
    protected TranslateClient $googleClient;

    /**
     * The engine options.
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Setup translator engine.
     *
     * @param array $options The options
     * @return void
     */
    public function setup(array $options = []): void
    {
        $this->options = $options;
        $this->options['key'] = (string)Hash::get($options, 'auth_key');
        $this->googleClient = new TranslateClient($this->options);
    }

    /**
     * Translate an array of texts $texts from language source $from to language target $to
     *
     * @param array $texts The texts to translate
     * @param string $from The source language
     * @param string $to The target language
     * @param array $options The options
     * @return string The translation in json format, i.e.
     * {
     *     "translation": [
     *         "<translation of first text>",
     *         "<translation of second text>",
     *         [...]
     *         "<translation of last text>"
     *     ]
     * }
     */
    public function translate(array $texts, string $from, string $to, array $options = []): string
    {
        $translation = [];
        foreach ($texts as $text) {
            $translation[] = (string)Hash::get(
                $this->googleClient->translate($text, ['source' => $from, 'target' => $to]),
                'text'
            );
        }

        return (string)json_encode(compact('translation'));
    }
}
