<?php

class AnthropicAPIClient {
    private $apiUrl = 'https://api.anthropic.com/v1/messages';
    private $apiKey;
    private $anthropicVersion;

    public function __construct($apiKey, $anthropicVersion) {
        $this->apiKey = $apiKey;
        $this->anthropicVersion = $anthropicVersion;
    }

    public function generateMessage($model, $maxTokens, $messages) {
        $headers = [
            'x-api-key: ' . $this->apiKey,
            'anthropic-version: ' . $this->anthropicVersion,
            'content-type: application/json',
        ];

        $data = [
            'model' => $model,
            'max_tokens' => $maxTokens,
            'messages' => $messages,
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }
}

// Usage
$ANTHROPIC_API_KEY = 'YOUR_ANTHROPIC_API_KEY';
$anthropicVersion = '2023-06-01';

$anthropicClient = new AnthropicAPIClient($ANTHROPIC_API_KEY, $anthropicVersion);

$model = 'claude-3-opus-20240229';
$maxTokens = 1024;
$messages = [
    ['role' => 'user', 'content' => 'Hello, world'],
];

$response = $anthropicClient->generateMessage($model, $maxTokens, $messages);

echo "API Response:\n";
echo $response;
?>
