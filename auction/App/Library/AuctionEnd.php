<?php
namespace App\Library;
use DB;
use Mail;

trait AuctionEnd {
    public static function auctionOver(){
        $time = date("Y-m-d H:i:s"); //check time in mysql
        $promise = DB::table('promise')
            ->join('request', 'promise.id', '=', 'request.promise_id')
            ->select('promise.id','promise.price','promise.auction_end','promise.sold')
            ->where ('promise.auction_end', '<' , $time)
            ->where ('promise.sold', '=' , null)
            ->where ('promise.type', '=' , 1) //select only auction promise
            ->get();
        $auction_end_id = array();
        foreach ($promise as $row){
            $auction_end_id []= $row->id;
        }
        foreach ($auction_end_id as $row){
            $winners = DB::table('winners')
                ->where ('promise_id', '=' , $row)
                ->where ('if_email', '=', null)
                ->get();
            if(count($winners) == 0){
                //$test1[] = $row.'has no winners';
                //close auction if no winners
                /*
                $close_auction = DB::table('promise') //sold update to 1 => auction close
                    ->where('id', $row)
                    ->update(['sold' => 1]);
                */
            } else {

                $auction_winners = DB::table('winners')
                    ->join('promise', 'winners.promise_id', '=', 'promise.id')
                    ->join('users','winners.winner_id', '=','users.id')
                    ->select('promise.id','users.id as buyer_id','users.f_name','users.email')
                    ->where ('promise.id', '=' , $row)
                    ->get();

                foreach ($auction_winners as $row) { //SEND MAIL TO ALL AUCTION WINNERS

                    // Проплату включить сдесь - отправить всем ссылки на оплату аукциона

                    $data = array( //send variable to mail view
                        'name' => $row->f_name,
                        'email' => $row->email,
                        'c_message' => \Lang::get('message.user.successful_purchase') . ' ' . $row->id
                    );
                    Mail::send('mail.promise_buy', $data, function ($m) use ($row) {
                        $m->from(env('admin_email'), 'Auction');
                        $m->to($row->email)->cc($row->email);
                        $m->subject(\Lang::get('message.promise.buy'));
                    });
                    $buyer_send_mail = DB::table('winners')
                        ->where('promise_id', $row->id)
                        ->where('winner_id', $row->buyer_id)
                        ->update(['if_email' => 1]); //set 1 => buyer buy the promise and send email
                }
            }
        }
    }
}