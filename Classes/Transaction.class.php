<?php
include_once 'core/Init.php';

class Transaction extends Db
{
    public function transaction($name, $account_number, $amount, $tellerId, $transType)
    {
        $sql = "SELECT * FROM other_details WHERE account_num = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$account_number]);
        if ($row = $stmt->fetch()) {
            
            $amount = $this->operation($row['balance'], $amount, '+');
            $sql = "INSERT INTO transactions (acc_name, users_fk, acc_num, amount, trans_type, teller_id) VALUES (?,?,?,?,?,?)";
            $stmt = $this->connect->prepare($sql);
            if ($stmt->execute([$name, $row['users_fk'], $account_number, $amount, $transType, $tellerId])) {
                $sql = "UPDATE other_details SET balance = ? WHERE account_num = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$amount, $account_number]);
            }
        }
    }

    private function operation($a, $b, $operator)
    {

        switch ($operator) {
            case '+':
                return $a + $b;
            case '-':
                return $a + $b;
        }
    }
}
