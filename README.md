---
# Laravel Transliterator API SDK

Simple, fluent Laravel 10 / 11 wrapper around the **[YEB Transliterator](https://yeb.to)** endpoint—convert Cyrillic, Greek, and other non-Latin text to Romanised output or various case/sluggified forms straight from your Laravel codebase.

---

## Table of Contents
1. [Features](#features)  
2. [Requirements](#requirements)  
3. [Installation](#installation)  
4. [Configuration](#configuration)  
5. [Usage](#usage)  
6. [Options Reference](#options-reference)  
7. [Examples](#examples)  
8. [Troubleshooting](#troubleshooting)  
9. [Contributing](#contributing)  
10. [License](#license)

---

## Features
- **Zero-boilerplate** – auto-discovered service provider & facade  
- **Supports Laravel 10 & 11** via `illuminate/support`  
- One-line helper `TransliteratorAPI::transliterate()` for every request  
- Easily publish & tweak default `config/transliterator.php`  
- Sensible cURL defaults (timeout, JSON headers, UA string)  
- Throws expressive `RuntimeException`s on missing keys / API errors  

---

## Requirements
|                | Minimum |
|----------------|---------|
| PHP            | 8.1     |
| Laravel        | 10.x / 11.x |
| YEB Account    | Valid API key (`YEB_KEY_ID`) |

---

## Installation

```bash
composer require yebto/laravel-transliterator-api

# (optional) publish the config so you can edit defaults
php artisan vendor:publish --tag=transliterator-config
````

---

## Configuration

```dotenv
# .env
YEB_KEY_ID=****************************************
YEB_API_BASE=https://api.yeb.to/v1/   # override if self-hosting
```

The published **`config/transliterator.php`** lets you tune:

* `base_url` – alternate endpoint
* global cURL options (timeouts, headers, etc.)

---

## Usage

```php
use TransliteratorAPI;

// basic
$result = TransliteratorAPI::transliterate('bg', 'Дядовите чички');

/*
[
    "lang"      => "bg",
    "type"      => "plain",
    "delimiter" => "-",
    "original"  => "Дядовите чички",
    "result"    => "Dyadovite chichki"
]
*/

// slug with custom delimiter
TransliteratorAPI::transliterate(
    lang:      'ru',
    text:      'Мой дядя самых честных правил',
    type:      'slug',
    delimiter: '_'
); // => "moy_dyadya_samykh_chestnykh_pravil"
```

---

## Options Reference

| Key         | Allowed values                                                 | Default |
| ----------- | -------------------------------------------------------------- | ------- |
| `lang`      | `bg`, `ru`, `el`, … (see YEB docs)                             | —       |
| `text`      | Source string                                                  | —       |
| `type`      | `plain`, `slug`, `snake`, `camel`, `capital`, `upper`, `lower` | `plain` |
| `delimiter` | Single character (only used when `type = slug`)                | `-`     |

---

## Examples

### Route stub (Laravel API)

```php
Route::post('/transliterator', function () {
    return TransliteratorAPI::transliterate(
        request('lang'),
        request('text'),
        request('type', 'plain'),
        request('delimiter', '-')
    );
});
```

### Programmatic call inside a job

```php
class GenerateFilename implements ShouldQueue
{
    public function handle()
    {
        $slug = TransliteratorAPI::transliterate(
            'el',
            $this->originalTitle,
            'slug'
        )['result'];

        // ...
    }
}
```
---

## Free Tier Access

🎁 You can get **1,000+ free API requests** by registering on [yeb.to](https://yeb.to) using your **Google account**.

Steps:

1. Visit [https://yeb.to](https://yeb.to)
2. Click **Login with Google**
3. Retrieve your API key and add it to your `.env` as `YEB_KEY_ID`

No credit card required!

---

## Troubleshooting

If you encounter issues:

* Ensure your API key is correct and active
* Double-check that the config file is published
* Validate parameters against the [API reference](https://docs.yeb.to/)
* Check for typos in method names or required fields

---

## Support

* 📘 API Documentation: [https://docs.yeb.to](https://docs.yeb.to)
* 📧 Email: [support@yeb.to](mailto:support@yeb.to)
* 🐛 Issues: [GitHub Issues](https://github.com/yebto/youtube-api/issues)

---

## License

© NETOX Ltd. Licensed under a proprietary or custom license unless stated otherwise in the repository.

> 💬 Have an idea, feature request, or want to suggest a new YouTube-related API?
> Reach out to us at [support@yeb.to](mailto:support@yeb.to) — we’d love to hear from you!

---
