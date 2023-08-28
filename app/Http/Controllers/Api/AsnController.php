<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asn;
use App\Models\AsnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsnController extends Controller
{
    function index(Request $request){
        $pageInfo = $request->get('pageInfo');
        $builder = Asn::query();
        $total = $builder->count();
        $limit = $pageInfo['limit']??10;
        $current = $pageInfo['current'];
        $offset = ($current - 1) * $limit;
        $data = Asn::query()->offset($offset)->limit($limit)->get()->toArray();
        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $data,
            'total' => $total
        ];
    }

    public function createOrUpdate(Request $request){
        try{
            DB::beginTransaction();
            $params = $request->only(['id','asn_number','remarks','items']);
            if(!empty($params['id'])){
                $msg = "更新成功";
                $asn = Asn::whereId($params['id'])->first();
                if(empty($asn)) throw new \Exception("找不到预报单信息");
                $asn->update([
                    'asn_number' => $params['asn_number'],
                    'remarks' => $params['remarks'],
                ]);
                $itemIds = array_filter(array_column($params['items'],'id'));
                $asn->items()->whereNotIn('id',$itemIds)->delete();
                foreach ($params['items'] as $item){
                    if(empty($item['id'])){
                        AsnItem::create([
                            'asn_id' => $asn->id,
                            'material_id' => $item['material_id'],
                            'supplier_id' => $item['supplier_id'],
                            'plan_qty' => $item['plan_qty'],
                            'plan_unit_price' => $item['plan_unit_price'],

                        ]);
                    }else{
                        $asn->items()->whereId($item['id'])->update([
                            'asn_id' => $asn->id,
                            'material_id' => $item['material_id'],
                            'supplier_id' => $item['supplier_id'],
                            'plan_qty' => $item['plan_qty'],
                            'plan_unit_price' => $item['plan_unit_price'],
                        ]);
                    }
                }
            }else{
                $msg = "创建成功";
                $exists = Asn::where('asn_number',$params['asn_number'])->exists();
                if($exists) throw new \Exception("预报单号码【{$params['asn_number']}】已经被使用");
                $asn = Asn::create([
                    'asn_number' => $params['asn_number'],
                    'status' => 'pending',
                    'remarks' => $params['remarks']
                ]);
                foreach ($params['items'] as $key => $item){
                    AsnItem::create([
                        'asn_id' => $asn->id,
                        'material_id' => $item['material_id'],
                        'supplier_id' => $item['supplier_id'],
                        'plan_qty' => $item['plan_qty'],
                        'plan_unit_price' => $item['plan_unit_price'],
                    ]);
                }
            }

            DB::commit();;
            return [
                'code' => 200,
                'msg' => $msg
            ];
        }catch (\Exception $exception){
            DB::rollBack();
            return [
                'code' => 400,
                'msg' => $exception->getMessage()
            ];
        }
    }

    public function delete($id){
        try {
            $asn = Asn::whereId($id)->first();
            if(empty($asn)) throw new \Exception("找不到预报单信息");
            $asn->delete();
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

    public function getInfo($id){
        $sku = Asn::with('items')->whereId($id)->first();
        return [
            'code' => 200,
            'data' => $sku->toArray(),
            'msg' => 'success'
        ];
    }
}
