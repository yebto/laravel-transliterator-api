<?php
namespace Yebto\TransliteratorAPI;

use Illuminate\Support\Arr;
use RuntimeException;

class TransliteratorAPI
{
    private function post(array $payload): array
    {
        $url  = rtrim(config('transliterator.base_url'), '/') . '/transliterator';
        $key  = config('transliterator.key');

        if (!$key) {
            throw new RuntimeException('Missing YEB_KEY_ID in .env');
        }

        $payload = array_merge($payload, ['api_key' => $key]);
        $body    = json_encode($payload, JSON_UNESCAPED_UNICODE);

        $ch = curl_init($url);
        curl_setopt_array($ch, $this->curlOpts([
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $body,
        ]));

        $raw  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new RuntimeException("cURL error: $err");
        }

        $json = json_decode($raw, true);

        if ($code !== 200) {
            throw new RuntimeException('API error: ' . Arr::get($json, 'error', 'Unknown'));
        }

        return $json;
    }

    /* ---------- Convenience wrapper ---------- */
    public function transliterate(
        string $lang,
        string $text,
        string $type = 'plain',
        string $delimiter = '-'
    ): array {
        return $this->post(compact('lang', 'text', 'type', 'delimiter'));
    }

    /* ---------- Curl defaults ---------- */
    private function curlOpts(array $extra): array
    {
        return $extra + config('transliterator.curl', []);
    }
}
