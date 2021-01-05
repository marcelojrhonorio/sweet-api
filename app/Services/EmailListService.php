<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Support\Facades\Log;
use App\Services\SaveAppMessageService;

class EmailListService
{

    private static $fields = ['NM_EMAIL', 'NM_URL', 'NM_ID', 'NM_FIRSTNAME'];

    public static function createFile($project = null, $_filename = null)
    {
        $handle = fopen( $_filename,'w') or die('Permission error');
        // set CSV header
        fputcsv($handle, self::$fields);
        // respondents
        foreach($project->respondents as $respondent){
            $c = Customers::find($respondent->respondentId);

            // monta array com os dados da lista
            $listData = [
                'nm_email' => $c->email,
                'nm_url' => $project->startUrlHead.$respondent->startUrlId."&sourceData=".$respondent->id,
                'nm_id' => $respondent->respondentId,
                'nm_firstname' => explode(" ", $c->fullname)[0],
            ];         

            // preenche o arquivo csv.
            fputcsv($handle, [$listData['nm_email'], $listData['nm_url'], $listData['nm_id'], $listData['nm_firstname']]);

            // cria a mensagem e dispara o push para o usuário
            SaveAppMessageService::createMessage($listData['nm_id'], 'ssi', $listData['nm_url']."&sourceSubID=app");

        }
        fclose($handle);
        return true;
    }

    public static function callInsertListData($project = null, $_project_name = null)
    {
        foreach($project->respondents as $respondent){
            $c = Customers::find($respondent->respondentId);

            // monta array com os dados da lista
            $listData = [
                'nm_email' => $c->email,
                'nm_url' => $project->startUrlHead.$respondent->startUrlId."&sourceData=".$respondent->id,
                'nm_id' => $respondent->respondentId,
            ];

            // insere o registro na lista
            EmailListDataService::insertData($_project_name, $listData); 
        }
    }

    public static function getProjectFileListName(int $_project_id = null)
    {
        return "projeto_ssi_".date('Y')."_".date('m')."_".date('d')."_id_{$_project_id}_".round(microtime(true) * 1000);
    }

    public static function getRequestSendEmailFields(string $_name_list = null)
    {
        return [
            "acao_arquivo"=>"3",
            "campos_arquivo"=>"nm_email,nm_url,nm_id",
            "separador"=>"2",
            "qualificador"=>"0",
            "excluidos"=>"0",
            "nm_lista"=>$_name_list,
        ];
    }

    public static function getRequestCreateListFields()
    {
        return [
            [
                "nome"=> "nm_email",
                "tipo"=>"texto",
                "tamanho"=> "255",
                "unico"=> "1",
            ],
            [
                "nome"=> "nm_url",
                "tipo"=> "texto",
                "tamanho"=> "512"
            ],
            [
                "nome"=> "nm_id",
                "tipo"=> "texto",
                "tamanho"=> "512"
            ]
        ];
    }

    private static function getDaysLastOpenedEmail ($date) 
    {
        $date = new Carbon($date);

        $now  = Carbon::now();

        $diff = $date->diffInDays($now);
        
        return $diff;
    }
}