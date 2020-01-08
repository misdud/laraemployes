<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\EmployeResoutse;
use App\Http\Resources\HeadDepartResource;
use App\Http\Resources\PositionResource;
use App\Employe;
use App\Position;
use App\Department;


class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $positionHeadDepartament = Position::select('id')
        // ->where('name_position', 'Начальник отдела')->first();

          $employes = Employe::with('position', 'department')
             // ->where('id_positione','!=',$positionHeadDepartament->id)
              ->orderBy('full_name')
              ->paginate(5);

         return  EmployeResoutse::collection($employes)->additional(['meta'=>[
         'Api_base_url' => url('/')
         ]]);

    }

    public function sortFio(){

        $positionHeadDepartament = Position::select('id')
            ->where('name_position', 'Начальник отдела')->first();

        return  EmployeResoutse::collection(
            Employe::with('position', 'department')
                ->where('id_positione','<>',$positionHeadDepartament->id)
                ->orderBy('full_name', 'desc')
                ->paginate(5)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $employe = Employe::with('position', 'department')
        //  ->where('id', $id)->get();

        // return  EmployeResoutse::collection($employe);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //  $employe = Employe::with('position', 'department')
       //  ->where('id', $id)->first();
       EmployeResoutse::withoutWrapping();
       return new EmployeResoutse(Employe::with('position', 'department')->findOrFail($id));



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employees = Employe::findOrFail($id);

        $employees->delete();

        return response()->json(['message'=>'Сотрудник удалён']);

    }

    public function getHeadDepart(){

       $headDeparts = Department::select('id', 'name','name_head_depart')
       ->orderBy('name_head_depart')->get();

       EmployeResoutse::withoutWrapping();
       return HeadDepartResource::collection($headDeparts);
    }

    public function getPosition(){

        $positions = Position::select('id', 'name_position', 'salary_position')
        ->where('id','>',9)
        ->orderBy('name_position')->get();

        PositionResource::withoutWrapping();
        return PositionResource::collection($positions);
    }



    public function storPhoto(Request $request){

        //$path = $request->file('file')->store('/public/photos');

        $path = Storage::putFile('/public/photos', $request->file('file'));
        return $path;
    }


}
