<?php
namespace App\Library;


    class UpBid
    {
        private $sql_data = array();
        private $update_val = '';
        private $update_key = '';
        private $update_sql = array();
        private $user_id = array();
        private $user_bid = array();
        public function changeBid($array)    //sort array to change bit in auction
        {
            if(count($array) == 1){         //if auction have only 1 winner
                foreach($array as $row){
                    $this->sql_data[$row['winner_id']] = $row['bid'];
                }
                $this->update_val = reset($this->sql_data);
                $this->update_key = key($this->sql_data);
                $this->update_sql['check_data']['user_id'] =  $this->update_key;
                $this->update_sql['check_data']['user_old_bid'] =  $this->update_val;
                $this->update_sql['update_data']['user_id'] = $this->update_key;
                $this->update_sql['update_data']['user_old_bid'] =  $this->update_val;
                return $this->update_sql;
            } else {                        //if auction have multiple winner
                foreach($array as $val) {
                    $this->user_id[] = (int)$val['winner_id'];
                    $this->user_bid[] = (int)$val['bid'];
                }
                $this->sql_data = array_combine($this->user_bid, $this->user_id); //key => bid price and val=> user id
                ksort($this->sql_data);                     //sort by key => lowest bid to the top
                $this->update_key = reset($this->sql_data); // received value of the first array element
                $this->update_val = key($this->sql_data);   // received key of the first array element
                $this->update_sql['update_data']['user_id'] =  $this->update_key;
                $this->update_sql['update_data']['user_old_bid'] =  $this->update_val;
                $this->update_key = end($this->sql_data);   // received value of the last array element
                $this->update_val = key($this->sql_data);   // received key of the last array element
                $this->update_sql['check_data']['user_id'] =  $this->update_key;
                $this->update_sql['check_data']['user_old_bid'] =  $this->update_val;
                return $this->update_sql;                  //return new sort data to update bid in winners table
            }
        }
    }