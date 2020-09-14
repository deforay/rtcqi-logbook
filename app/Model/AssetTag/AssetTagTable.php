<?php
namespace App\Model\AssetTag;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Service\AssetTagService;
use App\Service\CommonService;
use Illuminate\Support\Facades\Session;

class AssetTagTable extends Model
{
    //
    public function fetchAllAssetTag()
    {
        $data = DB::table('asset_tags')
            ->join('items', 'items.item_id', '=', 'asset_tags.item_id')
            ->join('branches', 'branches.branch_id', '=', 'asset_tags.branch_id')
            ->get();
        return $data;
    }

    public function saveAssetTag($request)
    {
        $data = $request->all();
        $assetTagId = 0;
        $commonservice = new CommonService();
        $assetTagId = DB::table('asset_tags')->insertGetId(
                [

                    'branch_id'             => $data['location'],
                    'item_id'               => $data['itemName'],
                    'asset_tag'             => $data['assetTag'],
                    'asset_tag_status'      => $data['assetTagStatus'],
                    'created_by'            => session('userId'),
                    'created_on'            => $commonservice->getDateTime(),
                ]
            );
        return $assetTagId;
    }

    public function updateAssetTag($params,$id)
    {
        $commonservice = new CommonService();
        $data = $params->all();
        if ($params->input('location')!=null && trim($params->input('location')) != '') {
            $response = DB::table('asset_tags')
                ->where('asset_id', '=',base64_decode($id))
                ->update(
                    [
                    'branch_id'             => $data['location'],
                    'item_id'               => $data['itemName'],
                    'asset_tag'             => $data['assetTag'],
                    'asset_tag_status'      => $data['assetTagStatus'],
                    'updated_by'            => session('userId'),
                    'updated_on'            => $commonservice->getDateTime(),
                    ]);

        $commonservice = new CommonService();
        $commonservice->eventLog(session('userId'), base64_decode($id), 'Asset Tag-update', 'Update Asset Tag '.$data['assetTag'], 'Asset Tag');
        }
        return $response;
    }
    
    public function fetchAssetId($params)
    {
        $req = $params->all();
        $itemdata = DB::table('items')
            ->select('items.item_code')
            ->where('items.item_id', '=', $req['itemId'])
            ->where('items.item_status','=','active')
            ->get();
            $itemdata = $itemdata->toArray();
            $itemCode=$itemdata[0]->item_code;
        $branchData = DB::table('branches')
            ->select('branches.branch_code')
            ->where('branches.branch_id', '=', $req['location'])
            ->where('branches.branch_status','=','active')
            ->get();
            $branchData = $branchData->toArray();
            $branchCode=$branchData[0]->branch_code;
        $assetcountData = DB::table('asset_tags')
            ->select('asset_tags.asset_id')
            ->get();
            $assetcountData = $assetcountData->toArray(); 
            $assetCount=count($assetcountData)+1;
        return $branchCode.$itemCode.$assetCount;
    }

    public function fetchAssetTagById($id)
    {
        $id = base64_decode($id);
        $data = DB::table('asset_tags')
                ->join('branches', 'branches.branch_id', '=', 'asset_tags.branch_id')
                ->join('items', 'items.item_id', '=', 'asset_tags.item_id')
                ->where('asset_tags.asset_id', '=',$id )
                ->where('items.item_status','=','active')
                ->where('branches.branch_status','=','active')
                ->get();
        return $data;
    }
}
