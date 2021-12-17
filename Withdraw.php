<?php

include_once 'core/Init.php';

if (isset($_POST['withdraw'])) {
    $insertTrans = new Transaction();
    $insertTrans->transaction($_POST['name'], $_POST['account_number'], $_POST['amount'], $_POST['teller_id'],"withdraw");
}
?>

<form method="POST">
    <label for="">Name</label>
    <input type="text" name="name" value="">
    
    <label for="">Account Number</label>
    <input type="text" name="account_number" value="">
    
    <label for="">Amount To Withdraw</label>
    <input type="text" name="amount" value="">
    
    <button type="submit" value="<?php echo $_SESSION['UsersId']; ?>">Withdraw</button>
</form>