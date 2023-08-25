<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    public function index(Request $request){
        $pageInfo = $request->get('pageInfo');
        $builder = Sku::query();
        $total = $builder->count();
        $limit = $pageInfo['limit']??10;
        $current = $pageInfo['current'];
        $offset = ($current - 1) * $limit;
        $data = Sku::query()->offset($offset)->limit($limit)->get()->toArray();
        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $data,
            'total' => $total
        ];
    }

    public function create(Request $request){
        $params = $request->all();
        $createData = $request->only(['barcode','name','description']);
        try{
            if(!empty($params['id'])){
                $sku = Sku::whereId($params['id'])->first();
                if (empty($sku)) throw new \Exception("找不到商品");
                $exists = Sku::whereBarcode($params['barcode'])->where('id','<>',$params['id'])->exists();
                if($exists) throw new \Exception("条码【{$params['barcode']}】已经被使用");
                $sku->update($createData);
            }else{
                $sku = Sku::whereBarcode($params['barcode'])->first();
                if($sku) throw new \Exception("条码【{$params['barcode']}】已经被使用");
                Sku::create($createData);
            }
            return [
                'code' => 200,
                'msg' => '创建成功'
            ];
        }catch (\Exception $exception){
            return [
                'code' => 400,
                'msg' => $exception->getMessage()
            ];
        }
    }

    public function delete($id){
        try {
            $sku = Sku::whereId($id)->first();
            if(empty($sku)) throw new \Exception("找不到商品信息");
            $sku->delete();
            return [
                'code' => 200,
                'msg' => '删除成功'
            ];
        }catch (\Exception $exception){
            return [
                'code' => 400,
                'msg' => $exception->getMessage()
            ];
        }
    }
}
