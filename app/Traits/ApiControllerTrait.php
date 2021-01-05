<?php
/**
 * ApiController of the resource and Rest
 * PHP version 7.1.
 *
 * @category Api_Logic
 *
 * @author "SmithJunior <smith.junior@icloud.com>"
 * @license MIT
 */

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator as PaginatorS;
use Illuminate\Pagination\Paginator;

trait ApiControllerTrait
{

    /**
     * Display a listing of the resource.
     *
     * @param request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        !empty($request->all()['limit']) && isset($request->all()['limit']) ? $limit = $request->all()['limit'] : $limit = -1;
        !empty($request->all()['order']) ? $order = $request->all()['order'] : $order = null;

        if ($order !== null) {
            $order = explode(',', $order);
        }

        !empty($order[0]) ? $order[0] = $order[0] : $order[0] = 'id';
        !empty($order[1]) ? $order[1] = $order[1] : $order[1] = 'asc';

        !empty($request->all()['where']) ? $where = $request->all()['where'] : $where = [];
        !empty($request->all()['like']) ? $like = $request->all()['like'] : $like = null;

        if ($like) {
            $like = explode(',', $like);
            $like[1] = '%' . $like[1] . '%';
        }

        if ($limit > 0) {
            $result = $this->model->orderBy($order[0], $order[1])
                ->where(function ($query) use ($like) {
                    if ($like) {
                        return $query->where($like[0], 'like', $like[1]);
                    }

                    return $query;
                })
                ->where($where)
                ->with($this->relationships())
                ->paginate($limit);
            return response()->json($result);
        }

        $result = $this->model->orderBy($order[0], $order[1])
            ->where(function ($query) use ($like) {
                if ($like) {
                    return $query->where($like[0], 'like', $like[1]);
                }

                return $query;
            })
            ->where($where)
            ->with($this->relationships())
            ->take($limit)->get();

        $paginator = new PaginatorS($result, $result->count(), $limit);

        $paginator->setPath(Paginator::resolveCurrentPath());

        return response()->json($paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->model->validate($request->all())) {
            return response()->json(array('modelError' => $this->model->errors()))
                ->setStatusCode(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY]
                );
        }

        try {
            $result = $this->model->create($request->all());
        } catch (\PDOException $e) {
            return response()->json(array('databaseError' => $e->getMessage()))
                ->setStatusCode(
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]
                );
        }

        return response()->json(array('data' => $result))
            ->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->model->with($this->relationships())
            ->findOrFail($id);

        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$this->model->validate($request->all())) {
            return response()->json(array('modelError' => $this->model->errors()))
                ->setStatusCode(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY]
                );
        }

        try {
            $result = $this->model->findOrFail($id);
            $result->fill($request->all());
            $result->save();
        } catch (\PDOException $e) {
            return response()->json(array('databaseError' => $e->getMessage()))
                ->setStatusCode(
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]
                );
        }

        return response()->json(array('data' => $result))
            ->setStatusCode(
                Response::HTTP_OK,
                Response::$statusTexts[Response::HTTP_OK]
            );

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->model->findOrFail($id);
        $result->delete();

        return response()->json(array('success' => true, 'result' => $result));
    }

    /**
     * Relationships method to return all models that are releated with my model.
     */
    protected function relationships()
    {
        if (isset($this->relationships)) {
            return $this->relationships;
        }

        return [];
    }
}
