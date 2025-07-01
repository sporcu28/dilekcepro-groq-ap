<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AIService
{
    private $client;
    private $apiKey;
    
    public function __construct()
    {
        $this->apiKey = $_ENV['OPENAI_API_KEY'] ?? '';
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'timeout' => 30.0,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ]
        ]);
    }
    
    public function generatePetition(string $subject, string $category, array $userInfo = []): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error' => 'OpenAI API anahtarı tanımlanmamış. Lütfen .env dosyasında OPENAI_API_KEY değerini ayarlayın.'
            ];
        }
        
        $prompt = $this->createPetitionPrompt($subject, $category, $userInfo);
        
        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Sen profesyonel bir dilekçe yazma uzmanısın. Türk hukuku ve resmi yazışma kurallarına uygun, düzgün ve etkili dilekçeler yazarsın.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 1000,
                    'temperature' => 0.7
                ]
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            
            if (isset($body['choices'][0]['message']['content'])) {
                $content = trim($body['choices'][0]['message']['content']);
                
                // Başlık ve içeriği ayır
                $lines = explode("\n", $content);
                $title = trim($lines[0], " \t\n\r\0\x0B#*-");
                $petitionContent = implode("\n", array_slice($lines, 1));
                
                return [
                    'success' => true,
                    'title' => $title ?: $subject,
                    'content' => trim($petitionContent)
                ];
            }
            
            return [
                'success' => false,
                'error' => 'AI yanıtı alınamadı.'
            ];
            
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => 'AI servisi hatası: ' . $e->getMessage()
            ];
        }
    }
    
    public function generateResponse(string $petitionContent, string $decision = 'neutral'): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error' => 'OpenAI API anahtarı tanımlanmamış.'
            ];
        }
        
        $prompt = $this->createResponsePrompt($petitionContent, $decision);
        
        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Sen bir kurum yetkilisisin ve dilekçelere resmi, profesyonel yanıtlar yazarsın. Türk resmi yazışma kurallarına uygun, saygılı ve net yanıtlar verirsin.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 800,
                    'temperature' => 0.6
                ]
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            
            if (isset($body['choices'][0]['message']['content'])) {
                return [
                    'success' => true,
                    'content' => trim($body['choices'][0]['message']['content'])
                ];
            }
            
            return [
                'success' => false,
                'error' => 'AI yanıtı alınamadı.'
            ];
            
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => 'AI servisi hatası: ' . $e->getMessage()
            ];
        }
    }
    
    public function improvePetition(string $content): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error' => 'OpenAI API anahtarı tanımlanmamış.'
            ];
        }
        
        $prompt = "Aşağıdaki dilekçeyi daha profesyonel, net ve etkili hale getir. Türk resmi yazışma kurallarına uygun olarak düzenle:\n\n" . $content;
        
        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Sen profesyonel bir editörsün. Dilekçeleri daha etkili, net ve profesyonel hale getirirsin.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 1000,
                    'temperature' => 0.5
                ]
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            
            if (isset($body['choices'][0]['message']['content'])) {
                return [
                    'success' => true,
                    'content' => trim($body['choices'][0]['message']['content'])
                ];
            }
            
            return [
                'success' => false,
                'error' => 'AI yanıtı alınamadı.'
            ];
            
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => 'AI servisi hatası: ' . $e->getMessage()
            ];
        }
    }
    
    private function createPetitionPrompt(string $subject, string $category, array $userInfo): string
    {
        $userName = $userInfo['full_name'] ?? 'Değerli Yetkili';
        
        $prompt = "Aşağıdaki bilgilere göre profesyonel bir dilekçe yaz:\n\n";
        $prompt .= "Konu: {$subject}\n";
        $prompt .= "Kategori: {$category}\n";
        
        if (!empty($userInfo['full_name'])) {
            $prompt .= "Dilekçe sahibi: {$userInfo['full_name']}\n";
        }
        
        $prompt .= "\nDilekçe şunları içermeli:\n";
        $prompt .= "1. Uygun bir başlık\n";
        $prompt .= "2. Giriş (sayın yetkili hitabı)\n";
        $prompt .= "3. Konunun açıklanması\n";
        $prompt .= "4. Talep edilen işlem\n";
        $prompt .= "5. Saygılarla sonuç\n\n";
        $prompt .= "Türk resmi yazışma kurallarına uygun, saygılı ve profesyonel bir dil kullan.";
        
        return $prompt;
    }
    
    private function createResponsePrompt(string $petitionContent, string $decision): string
    {
        $prompt = "Aşağıdaki dilekçeye ";
        
        switch ($decision) {
            case 'approved':
                $prompt .= "olumlu ";
                break;
            case 'rejected':
                $prompt .= "olumsuz ";
                break;
            default:
                $prompt .= "değerlendirme ";
        }
        
        $prompt .= "yanıtı yaz:\n\n{$petitionContent}\n\n";
        $prompt .= "Yanıt profesyonel, resmi ve saygılı olmalı. Türk resmi yazışma kurallarına uygun olsun.";
        
        return $prompt;
    }
}