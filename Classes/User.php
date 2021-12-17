<?php
class User extends Db {
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = Db::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                
                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    //process logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    // public function update($fields = array(), $id = null) {

    //     if(!$id && $this->isLoggedIn()) {
    //         $id = $this->data()->UsersID;
    //     }

    //     if(!$this->_db->update('users', $id, $fields)) {
    //         throw new Exception('There was a problem updating.');
    //     }
    // }

    public function createuser($fields = array()) {
        if(!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account.');
        }
    }

    public function createother_details($fields = array()) {
        if(!$this->_db->insert('other_Details', $fields)) {
            throw new Exception('There was a problem creating an account.');
        }
    }

    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'UsersID' : 'Username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        } 
        return false;
    }

    public function login($username = null, $password = null, $remember = false) {

        
    
        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->UsersID);
        } else {
            

            $user = $this->find($username);
        
            if($user) {
                if($this->data()->Password === Hash::make($password, $this->data()->Salt)) {
                    Session::put($this->_sessionName, $this->data()->UsersID);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('UserID', '=', $this->data()->UsersID)); 
                        
                        if(!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'UserID' => $this->data()->UsersID,
                                'Hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->Hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry')); 
                    }
                    
                    return true;
                }
            } 
        }
        return false;
    }

    public function hasPermission($key) {
        $group = $this->_db->get('groups', array('id', '=', $this->data()->Group));
        
        if($group->count()) {
            $permissions = json_decode($group->first()->Permission, true);

            if(isset($permissions[$key])) {
                return true;
            }
        }
        return false;
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout() {
        
        $this->_db->delete('users_session', array('UserID', '=', $this->data()->UsersID));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

    public function getfk() {
        $userid = "SELECT UsersID FROM users ORDER BY UsersID DESC";
        $stmt = $this->connect()->prepare($userid);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            return $row['UsersID'];
        }
    }

    protected function generateNumber($table, $column, $field, $number1, $trans)
    {
        $sql = "SELECT * FROM $table ORDER BY $column DESC LIMIT 1";
        $stmt = $this->connect()->query($sql);
        if ($stmt->rowCount() < 1) {
            if ($trans == "account")
                return "0000000001";
            else
                return "000000000001";
        }
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $a = $row[$field];
            $generate_account_number = intval($a);
            return str_pad($generate_account_number + 1, $number1, 0, STR_PAD_LEFT);
        }
    }

    public function generateAccountNumber() {
        return $this->generateNumber('other_details', 'account_num', 'account_num', 10, 'account');
    }
}