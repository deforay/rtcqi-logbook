<?php
namespace App\Http\Controllers\AssetTag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\AssetTagService;
use App\Service\BranchesService;
use App\Service\InventoryOutwardsService;
use App\Service\GlobalConfigService;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use View;
use Redirect;

class AssetTagController extends Controller
{
    //View Asset Tag main screen
    public function index()
    {
        if(session('login')==true)
        {
            return view('assettag.index');
        }
        else
            return Redirect::to('login')->with('status', 'Please Login');
    }

    //Add Asset Tag Screen
    public function add(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $assetService = new AssetTagService();
            $add = $assetService->saveAssetTag($request);
            return Redirect::route('assettag.index')->with('status', $add);
        }
        else
        {
            $assetService = new BranchesService();
            $branch = $assetService->getBranchesByUser();
            // dd($branch);
            return view('assettag.add',array('branch'=>$branch));
        }
    }

    // Get all the Asset Tag list
    public function getAllAssetTag(Request $request)
    {
        $all = new AssetTagService();
        $data = $all->getAllAssetTag();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<div style="width: 180px;">';
                        $role = session('role');
                        if (isset($role['App\\Http\\Controllers\\AssetTag\\AssetTagController']['edit']) && ($role['App\\Http\\Controllers\\AssetTag\\AssetTagController']['edit'] == "allow")){
                           $button .= '<a href="/assettag/edit/'. base64_encode($data->asset_id).'" name="edit" id="'.$data->asset_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a>';
                        }else{
                            $button .= '';
                        }
                        $button .= '&nbsp;&nbsp;<a href="/assettag/createPdf/'. base64_encode($data->asset_id).'" name="edit" id="'.$data->asset_id.'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-file"></i></a>';
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }
    public function createAssetId(Request $request){
        $service = new AssetTagService();
        $assetTag = $service->getAssetId($request);
        return $assetTag;
    }
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {
            $assetService = new AssetTagService();
            $edit = $assetService->updateAssetTag($request,$id);
            return Redirect::route('assettag.index')->with('status', $edit);
        }
        else
        {
            $assetService = new AssetTagService();
            $assetResult = $assetService->getAssetTagById($id);
            $assetService = new BranchesService();
            $branch = $assetService->getBranchesByUser();
            return view('assettag.edit',array('result'=>$assetResult,'branch'=>$branch));
        }
    }
    public function createPdf(Request $request,$id)
    {
        if ($request->isMethod('post')) 
        {

        }
        else
        {
            $assetService = new AssetTagService();
            $assetResult = $assetService->getAssetTagById($id);
            $configService = new GlobalConfigService();
            $config = $configService->getGlobalConfigLogo();
            $assetResult[0]->logo = public_path('assets').$config[0]->global_value;
            // dd($assetResult);
            // return view('assettag.assettagpdf',array('assetResult'=>$assetResult));
            // dd($assetResult);
            // $assetTag = $assetResult[0]->asset_tag;
            view()->share('assetResult',$assetResult);
            $customPaper = array(0,0,250.00,400.00);
            $pdf = PDF::loadView('assettag.assettagpdf', $assetResult)->setPaper($customPaper, 'landscape');
            // dd($pdf);
            return $pdf->download($assetResult[0]->asset_tag.'.pdf');
            // dd($assetResult);
        }
    }
}
