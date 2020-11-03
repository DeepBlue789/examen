<?php require_once("database.php"); ?>
<?php

if(isset($_POST["action"]))
{
        if($_POST["action"] == 'fetch')
        {
                $output = '';
                $db = Database::connect();
                $user = 'user';
                $connexion = $db->prepare("SELECT * FROM user_details WHERE user_type = 'user' ORDER BY user_name ASC");
                $query = "SELECT * FROM user_details WHERE user_type = ? ORDER BY user_name ASC";
                $connexion -> execute(array($user));
                $result = $connexion->fetchAll();
                $output .= '
                <table class="table table-bordered table-striped">
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Status</td>
                    <td>Action</td>
                    </tr>
                ';
                foreach($result as $row)
                {
                        $status = '';
                        if($row["user_status"] == 'Active')
                        {
                            $status = '<span class ="label label-success">
                            Active</span>';
                        }
                        else{
                            $status = '<span class="label label-danger">
                            Inactive</span>';
                        }
                        $output .='
                        <tr>
                            <td>'.$row["user_name"].'</td>
                            <td>'.$row["user_email"].'</td>
                            <td>'.$status.'</td>
                            <td><button type"button" name="action" class="btn btn-info btn-xs action" data-user_id="'.$row["user_id"].'" data-user_status="'.$row["user_status"].'">Action</button></td>
                            </tr>
                            ';
                }
                $output .= '</table>';
                echo $output;
        }
}
?>

