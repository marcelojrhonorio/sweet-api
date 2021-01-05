<?php

namespace App\Http\Controllers\Messages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerMessagesController extends Controller
{
    public function getMessageById($id, Request $request)
    {
        $d1 = [
            'customers_id' => (string) $id,
            'created_at' => '2019-09-19 09:58:01',
            'opened_at' => '2019-09-19 10:30:05',
            'body' => [
                'message_id' => (string) 1015,
                'message_text' => '<h3>Pesquisa com pontuação elevada!!! uhuhu Mais uma vez o seu perfil foi escolhido pelos nossos parceiros para responder!</h3> <p>Basta clicar no link abaixo e responder a uma pesquisa.</p> <p><strong>Ganhe 10 pontos agora. E se você for selecionado pelos nossos parceiros você irá receber 100 pontos a pesquisa levará pouco tempo para ser concluída</strong></p> <p>A sua opinião é muito importante para nós.</p>',
                'link' => 'https://dkr1.ssisurveys.com/projects/boomerang?psid=rq7d5Hf1sCJDllWFULsdHcuwlD4ZewFu&sourceData=18983594',
                'image' => 'https://sweetmedia.com.br/storage/campaings/images/2019/8/15664144105d5d964a9bf0b.jpg',
            ],
            'push' => [
                'title' => 'Ganhe 100 pontos agora. Participe da pesquisa!',
                'text' => 'Seu perfil foi escolhido pelos nossos parceiros. Responda agora e ganhe!'
            ]
        ];

        $d2 = [
            'customers_id' => (string) $id,
            'created_at' => '2019-09-21 11:33:01',
            'opened_at' => null,
            'body' => [
                'message_id' => (string) 1033,
                'message_text' => '<h3>Pesquisa com pontuação elevada!!! uhuhu Mais uma vez o seu perfil foi escolhido pelos nossos parceiros para responder!</h3> <p>Basta clicar no link abaixo e responder a uma pesquisa.</p> <p><strong>Ganhe 10 pontos agora. E se você for selecionado pelos nossos parceiros você irá receber 100 pontos a pesquisa levará pouco tempo para ser concluída</strong></p> <p>A sua opinião é muito importante para nós.</p>',
                'link' => 'https://dkr1.ssisurveys.com/projects/boomerang?psid=rq7d5Hf1sCJDllWFULsdHcuwlD4ZewFu&sourceData=18983594',
                'image' => 'https://sweetmedia.com.br/storage/campaings/images/2019/8/15664144105d5d964a9bf0b.jpg',
            ],
            'push' => [
                'title' => 'Ganhe 100 pontos agora. Participe da pesquisa!',
                'text' => 'Seu perfil foi escolhido pelos nossos parceiros. Responda agora e ganhe!'
            ]
        ];

        $d3 = [
            'customers_id' => (string) $id,
            'created_at' => '2019-09-24 12:58:01',
            'opened_at' => '2019-09-25 10:11:05',
            'body' => [
                'message_id' => (string) 1054,
                'message_text' => '<h3>Pesquisa com pontuação elevada!!! uhuhu Mais uma vez o seu perfil foi escolhido pelos nossos parceiros para responder!</h3> <p>Basta clicar no link abaixo e responder a uma pesquisa.</p> <p><strong>Ganhe 10 pontos agora. E se você for selecionado pelos nossos parceiros você irá receber 100 pontos a pesquisa levará pouco tempo para ser concluída</strong></p> <p>A sua opinião é muito importante para nós.</p>',
                'link' => 'https://dkr1.ssisurveys.com/projects/boomerang?psid=rq7d5Hf1sCJDllWFULsdHcuwlD4ZewFu&sourceData=18983594',
                'image' => 'https://sweetmedia.com.br/storage/campaings/images/2019/8/15664144105d5d964a9bf0b.jpg',
            ],
            'push' => [
                'title' => 'Ganhe 100 pontos agora. Participe da pesquisa!',
                'text' => 'Seu perfil foi escolhido pelos nossos parceiros. Responda agora e ganhe!'
            ]            
        ];

        $data = [];
        array_push($data, $d1);
        array_push($data, $d2);
        array_push($data, $d3);

        return response()->json([
            'success' => true,
            'data'    => $data,
        ], 200);
    }

    public function readMessage ($messageId, $customerId)
    {
        $d1 = [
            'customers_id' => (string) $customerId,
            'created_at' => '2019-09-19 09:58:01',
            'opened_at' => '2019-09-19 10:30:05',
            'body' => [
                'message_id' => (string) 1015,
                'message_text' => '<h3>Pesquisa com pontuação elevada!!! uhuhu Mais uma vez o seu perfil foi escolhido pelos nossos parceiros para responder!</h3> <p>Basta clicar no link abaixo e responder a uma pesquisa.</p> <p><strong>Ganhe 10 pontos agora. E se você for selecionado pelos nossos parceiros você irá receber 100 pontos a pesquisa levará pouco tempo para ser concluída</strong></p> <p>A sua opinião é muito importante para nós.</p>',
                'link' => 'https://dkr1.ssisurveys.com/projects/boomerang?psid=rq7d5Hf1sCJDllWFULsdHcuwlD4ZewFu&sourceData=18983594',
                'image' => 'https://sweetmedia.com.br/storage/campaings/images/2019/8/15664144105d5d964a9bf0b.jpg',
            ],
            'push' => [
                'title' => 'Ganhe 100 pontos agora. Participe da pesquisa!',
                'text' => 'Seu perfil foi escolhido pelos nossos parceiros. Responda agora e ganhe!'
            ]
        ];

        $d2 = [
            'customers_id' => (string) $customerId,
            'created_at' => '2019-09-21 11:33:01',
            'opened_at' => '2019-09-21 11:33:01',
            'body' => [
                'message_id' => (string) 1033,
                'message_text' => '<h3>Pesquisa com pontuação elevada!!! uhuhu Mais uma vez o seu perfil foi escolhido pelos nossos parceiros para responder!</h3> <p>Basta clicar no link abaixo e responder a uma pesquisa.</p> <p><strong>Ganhe 10 pontos agora. E se você for selecionado pelos nossos parceiros você irá receber 100 pontos a pesquisa levará pouco tempo para ser concluída</strong></p> <p>A sua opinião é muito importante para nós.</p>',
                'link' => 'https://dkr1.ssisurveys.com/projects/boomerang?psid=rq7d5Hf1sCJDllWFULsdHcuwlD4ZewFu&sourceData=18983594',
                'image' => 'https://sweetmedia.com.br/storage/campaings/images/2019/8/15664144105d5d964a9bf0b.jpg',
            ],
            'push' => [
                'title' => 'Ganhe 100 pontos agora. Participe da pesquisa!',
                'text' => 'Seu perfil foi escolhido pelos nossos parceiros. Responda agora e ganhe!'
            ]
        ];

        $d3 = [
            'customers_id' => (string) $customerId,
            'created_at' => '2019-09-24 12:58:01',
            'opened_at' => '2019-09-25 10:11:05',
            'body' => [
                'message_id' => (string) 1054,
                'message_text' => '<h3>Pesquisa com pontuação elevada!!! uhuhu Mais uma vez o seu perfil foi escolhido pelos nossos parceiros para responder!</h3> <p>Basta clicar no link abaixo e responder a uma pesquisa.</p> <p><strong>Ganhe 10 pontos agora. E se você for selecionado pelos nossos parceiros você irá receber 100 pontos a pesquisa levará pouco tempo para ser concluída</strong></p> <p>A sua opinião é muito importante para nós.</p>',
                'link' => 'https://dkr1.ssisurveys.com/projects/boomerang?psid=rq7d5Hf1sCJDllWFULsdHcuwlD4ZewFu&sourceData=18983594',
                'image' => 'https://sweetmedia.com.br/storage/campaings/images/2019/8/15664144105d5d964a9bf0b.jpg',
            ],
            'push' => [
                'title' => 'Ganhe 100 pontos agora. Participe da pesquisa!',
                'text' => 'Seu perfil foi escolhido pelos nossos parceiros. Responda agora e ganhe!'
            ]            
        ];

        $data = [];
        array_push($data, $d1);
        array_push($data, $d2);
        array_push($data, $d3);

        return response()->json([
            'success' => true,
            'data'    => $data,
        ], 200);        
    }

    public function destroyMessage ($messageId, $customerId)
    {
        $d1 = [
            'customers_id' => (string) $customerId,
            'created_at' => '2019-09-19 09:58:01',
            'opened_at' => '2019-09-19 10:30:05',
            'body' => [
                'message_id' => (string) 1015,
                'message_text' => '<h3>Pesquisa com pontuação elevada!!! uhuhu Mais uma vez o seu perfil foi escolhido pelos nossos parceiros para responder!</h3> <p>Basta clicar no link abaixo e responder a uma pesquisa.</p> <p><strong>Ganhe 10 pontos agora. E se você for selecionado pelos nossos parceiros você irá receber 100 pontos a pesquisa levará pouco tempo para ser concluída</strong></p> <p>A sua opinião é muito importante para nós.</p>',
                'link' => 'https://dkr1.ssisurveys.com/projects/boomerang?psid=rq7d5Hf1sCJDllWFULsdHcuwlD4ZewFu&sourceData=18983594',
                'image' => 'https://sweetmedia.com.br/storage/campaings/images/2019/8/15664144105d5d964a9bf0b.jpg',
            ],
            'push' => [
                'title' => 'Ganhe 100 pontos agora. Participe da pesquisa!',
                'text' => 'Seu perfil foi escolhido pelos nossos parceiros. Responda agora e ganhe!'
            ]
        ];

        $d2 = [
            'customers_id' => (string) $customerId,
            'created_at' => '2019-09-21 11:33:01',
            'opened_at' => '2019-09-21 11:33:01',
            'body' => [
                'message_id' => (string) 1033,
                'message_text' => '<h3>Pesquisa com pontuação elevada!!! uhuhu Mais uma vez o seu perfil foi escolhido pelos nossos parceiros para responder!</h3> <p>Basta clicar no link abaixo e responder a uma pesquisa.</p> <p><strong>Ganhe 10 pontos agora. E se você for selecionado pelos nossos parceiros você irá receber 100 pontos a pesquisa levará pouco tempo para ser concluída</strong></p> <p>A sua opinião é muito importante para nós.</p>',
                'link' => 'https://dkr1.ssisurveys.com/projects/boomerang?psid=rq7d5Hf1sCJDllWFULsdHcuwlD4ZewFu&sourceData=18983594',
                'image' => 'https://sweetmedia.com.br/storage/campaings/images/2019/8/15664144105d5d964a9bf0b.jpg',
            ],
            'push' => [
                'title' => 'Ganhe 100 pontos agora. Participe da pesquisa!',
                'text' => 'Seu perfil foi escolhido pelos nossos parceiros. Responda agora e ganhe!'
            ]
        ];

        $data = [];
        array_push($data, $d1);
        array_push($data, $d2);

        return response()->json([
            'success' => true,
            'data'    => $data,
        ], 200);   
    }
}
