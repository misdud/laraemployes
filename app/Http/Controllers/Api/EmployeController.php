<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\EmployeResource;
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

         return  EmployeResource::collection($employes)->additional(['meta'=>[
         'Api_base_url' => url('/')
         ]]);

    }

    public function sortFio(){

        $positionHeadDepartament = Position::select('id')
            ->where('name_position', 'Начальник отдела')->first();

        return  EmployeResource::collection(
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

        // return  EmployeResource::collection($employe);

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
       EmployeResource::withoutWrapping();
       return new EmployeResource(Employe::with('position', 'department')->findOrFail($id));



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
        $data = $request->validate([
            'name' => 'required',
            'position' => 'required',
            'employment' => 'required',
            'ratio' => 'required',
            'name_head_depart' => 'required',
        ]);


        //for search id departament
        $nameHeadDepart = $request->name_head_depart;
        $departamentId = Department::select('id')->where('name_head_depart', $nameHeadDepart)->first(); 

        $employe = Employe::find($id);
        $employe->full_name=$request->name;
       // $employe->employment=$request->employment;
        $employe->ratio=$request->ratio;
        $employe->id_departament=$departamentId->id;
        //$employe->id_positione=$request->id_positione;
        $employe->save();

        EmployeResource::withoutWrapping();
        return new EmployeResource(Employe::with('position', 'department')->find($id));
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

       EmployeResource::withoutWrapping();
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

    public function search(Request $request){

        //$employes = Employe::where('name', $request->keywords)->get();

        //return response()->json($employes);
    }


}
