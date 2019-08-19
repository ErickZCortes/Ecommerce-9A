<?php
    namespace app\Models;
    class OrderModel extends Models{
        public function selectOrders(){
                $query = $this->db->pdo->prepare(
                    'SELECT 
                    orders.`orderNumber`, 
                    orders.`orderDate`, 
                    orders.`requiredDate`, 
                    orders.`shippedDate`, 
                    orders.`status`, 
                    orders.`comments`, 
                    orders.`customerNumber`,
                    orderdetails.`orderNumber`, 
                    orderdetails.`productCode`, 
                    orderdetails.`quantityOrdered`, 
                    orderdetails.`priceEach`, 
                    orderdetails.`orderLineNumber`
                    FROM 
                    orders INNER JOIN  orderdetails ON orders.`orderNumber` = orderdetails.`orderNumber`'
                );
                
        
                if(!$query->execute()){
                    return array(
                        'sucess' => false,
                        'description' => $query->errorInfo()
                    
                    );
                }else{
                    $result = $query -> fetchAll(\ PDO::FETCH_ASSOC);
                    return array(
                        'sucess' => true,
                        'description' => 'The orders were found',
                        'orders' => $result
                    );
                }
        
                return array(
                    'sucess' => true,
                    'description' => 'The orders were found',
                    'orders' => $result
                );
            }
        public function insertOrder($order){
            $orderNumber = time();
            $lines = $order['cart']['lines'];
            //var_dump('model');die();

            $this->db->pdo->beginTransaction();

            $this->db->insert('orders',[
                'orderNumber'=>$orderNumber,
                'orderDate'=> date('Y-m-d',time()),
                'requiredDate'=> date('Y-m-d',time()),
                'status'=> 'In process',
                'customerNumber'=> '496'
            ]);

            foreach ($lines as $key => $line) {
                $this->db->insert('orderdetails',[
                    'orderNumber'=>$orderNumber,
                    'productCode'=> $line['product']['productCode'],
                    'quantityOrdered'=> $line['quantity'],
                    'priceEach'=> $line['product']['MSRP'],
                    'orderLineNumber'=> $key + 1
                ]);
            }

            if(!is_null($this->db->error()[1])){
                $this->db->pdo->rollBack();
                return array('error'=>true, 'Description'=>$this->db->error()[2]);
            }
            $this->db->pdo->commit();
            return array('access'=>true, 'description'=>'order registered');
        }
    }
?>