<?php

namespace App\Http\Controllers;

use App\Http\Requests\Spl\SplCreateRequest;
use App\Http\Requests\Spl\SplEditRequest;
use Illuminate\Http\Request;
use App\Domain\Repositories\SplRepository;

class SplController extends Controller
{

    /**
     * @var SplRepository
     */
    protected $spl;

    /**
     * SplController constructor.
     * @param SplRepository $spl
     */
    public function __construct(SplRepository $spl)
    {
        $this->spl = $spl;
        // $this->middleware('auth');
    }

    /**
     * @api {get} api/spl Request Spl with Paginate
     * @apiName GetSplWithPaginate
     * @apiGroup Spl
     *
     * @apiParam {Number} page Paginate Spl lists
     */
    public function index(Request $request)
    {
        return $this->spl->paginate(10, $request->input('page'), $column = ['*'], '', $request->input('term'));
    }

    /**
     * @api {get} api/spl/id Request Get Spl
     * @apiName GetSpl
     * @apiGroup spl
     *
     * @apiParam {Number} id id_spl
     * @apiSuccess {Number} id id_spl
     * @apiSuccess {Varchar} nama of spl
     * @apiSuccess {Time} jam_masuk of spl
     * @apiSuccess {Time} jam_keluar of spl
     * @apiSuccess {Varchar} pekerjaan of spl
     * @apiSuccess {Date} tanggal of spl
     * @apiSuccess {Varchar} penanggul_jawab of spl
     * @apiSuccess {Number} pin of spl
     */
    public function show($id)
    {
        return $this->spl->findById($id);
    }

    /**
     * @api {spl} api/spl/ Request Spl Spl
     * @apiName SplSpl
     * @apiGroup Spl
     *
     * @apiParam {Varchar} nama of spl
     * @apiParam {Time} jam_masuk of spl
     * @apiParam {Time} jam_keluar of address
     * @apiParam {Varchar} pekerjaan of spl
     * @apiParam {Date} tanggal of spl
     * @apiParam {Varchar} penanggung_jawab of spl
     * @apiSuccess {Number} pin of spl
     */
    public function store(Request $request)
    {
        return $this->spl->create($request->all());
    }

    /**
     * @api {put} api/spl/id Request Update Spl by ID
     * @apiName UpdateSplByID
     * @apiGroup Spl
     *
     * @apiParam {Varchar} nama of spl
     * @apiParam {Time} jam_masuk of spl
     * @apiParam {Time} jam_keluar of spl
     * @apiParam {Varchar} pekerjaan of spl
     * @apiParam {Date} tanggal of spl
     * @apiParam {Varchar} penanggung_jawab of spl
     * @apiParam {Number} pin of spl
     *
     * @apiError EmailHasRegitered The Email must diffrerent.
     */
    public function update(SplEditRequest $request, $id)
    {
        return $this->spl->update($id, $request->all());
    }

    /**
     * @api {delete} api/spl/id Request Delete Spl by ID
     * @apiName DeleteSplByID
     * @apiGroup Spl
     *
     * @apiParam {Number} id id of spl
     *
     * @apiError SplNotFound The <code>id</code> of the Spl was not found.
     * @apiError NoAccessRight Only authenticated Admins can access the data.
     */
    public function destroy($id)
    {
        return $this->spl->delete($id);
    }

}
