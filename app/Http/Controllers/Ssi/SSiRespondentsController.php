<?php
namespace App\Http\Controllers\Ssi;

use App\Http\Controllers\Controller;
use App\Models\Ssi\SsiProjectRespondent;
use App\Services\PixelService;

class SSiRespondentsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = [];

    public function __construct(SsiProjectRespondent $model)
    {
        $this->model = $model;
    }

    public function registerPixel($respondent_id)
    {
        $r = $this->model->find($respondent_id);
        $r->count_opened_email+=1;
        $r->update();
        return PixelService::returnPixel();
    }

}
