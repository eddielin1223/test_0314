<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class RecommendationController extends Controller
{
    public function __construct(){
        $this->redis = Redis::connection();
    }
    public function getAll(){
        
        $refresh = $this->redis->get('need_refresh');
        $recommList = null;
        $list = $this->redis->get('recomm_list');
        if (!$list || !empty($refresh))
        {
            Log::info('cache gone, set it');
            $recommList = \DB::table('Recommendation')->get();

            $recommList = $recommList->map(function ($item, $key) {

                $commStr = '';
                $comments=\DB::table('comment')->where('prod_id',$item->id)->get();
                $comments= json_decode($comments,true);

                $comments= array_filter($comments);
                if (!empty($comments))
                {
                    $aryContent = array_column($comments, 'content');
                    $commStr   = implode(',', $aryContent);
                }

                $item->comment = $commStr;
                return $item;
            });

            $this->redis->set('need_refresh', 0);
            $this->redis->set('recomm_list', $recommList);
            $this->redis->expire('recomm_list', 600);
        }
        else
        {
            Log::info('get list from cache');
            $recommList = $this->redis->get('recomm_list');
        }


        $recommList = json_decode($recommList, true);
        Log::info(json_encode($recommList));
        return view('recommendation', ['data' => $recommList]);
        // return $recommList;
    }

    public function setComment()
    {
        $request = request()->only(
            'prod_id',
            'content', 
        );
        Log::info('set comment');
        Log::info($request['content']);
        $rsUpdate   = \DB::table('comment')->insert($request);
        Log::info(json_encode($rsUpdate));

        $this->redis->set('need_refresh', 1);
        $rsAry = array();
        $rsAry['response'] = $rsUpdate;
        return json_encode($rsAry);
    }
}
