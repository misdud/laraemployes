<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\HeadEnterpResource as HeadEnterpAs;
use App\Http\Resources\DirectorResource;
use App\Http\Resources\DeputysResource;
use App\Http\Resources\DepartResource;
use App\Http\Resources\EmployeResource;
use App\HeadEnterp;
use App\Director;
use App\Deputy;
use App\Department;
use App\Employe;


class HeadEnterpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headEnterps = HeadEnterp::with('position')->get();
        HeadEnterpAs::withoutWrapping();
        return HeadEnterpAs::collection($headEnterps);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDirector($id = 1)
    {
        $directors = Director::where('id_head', $id)->with('position')->get();
        DirectorResource::withoutWrapping();
        return DirectorResource::collection($directors);
    }

  public function getDeputy(Request $request)
  {

     $id = $request->id;
     DirectorResource::withoutWrapping();
     $dir =  new DirectorResource(Director::with('position')->findOrFail($id));


     $idDirect = $request->id;
     $deputys = Deputy::where('id_director', $idDirect)
     ->with('position', 'director')
     ->get();

     DeputysResource::withoutWrapping();
     $collDeputys = DeputysResource::collection($deputys);

     return response()->json(['dir' => $dir, 'collDeputys'=>$collDeputys],200);

    //  return DeputysResource::collection($deputys);

  }

  public function getDepart(Request $request)

  {

    $id = $request->id;
    DeputysResource::withoutWrapping();
    $deputy =  new DeputysResource(Deputy::with('position')->findOrFail($id));



    $idDeputy = $request->id;
    $depart = Department::where('id_deputys', $idDeputy)
              ->with('deputy', 'position')
              ->get();

    DepartResource::withoutWrapping();
    $departColl = DepartResource::collection($depart);

    return response()->json(['depart' => $deputy, 'collDepart'=>$departColl],200);

    //return DepartResource::collection($depart);
  }
    public function getEmploye(Request $request){

        $id = $request->id;
        DepartResource::withoutWrapping();
        $headDepart =  new DepartResource(Department::with('position')->findOrFail($id));

        $employes = Employe::with('position', 'department')
        ->where('id_departament', $id)
        ->orderBy('full_name')
        ->get();

        EmployeResource::withoutWrapping();
        $empls =  EmployeResource::collection($employes);

    return response()->json(['headDepart' => $headDepart, 'collEmploye'=>$empls],200);


    }

}
