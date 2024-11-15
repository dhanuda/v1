<?php
 
	include 'db.php';

 	Class Manageaccess extends Db{


 		public function pagesList($PID){
 			$conn = $this->conn;
 			$sql = "SELECT page_id , page_name FROM pages_master where parent_id= '$PID' ";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			  // output data of each row
			  while($row = $result->fetch_assoc()) {
			  	 $childs = $this->pagesList($row['page_id']);
			     $arr[$row['page_id']] = ['name'=>$row['page_name'],'childs'=>$childs];
			  }
				return $arr;
			}
			return false;
 		}


 		public function userGroupList(){
 			$conn = $this->conn;
 			$sql = "SELECT * FROM `usergroups` ORDER BY `usergroups`.`id` ASC ";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			  // output data of each row
			  while($row = $result->fetch_assoc()) { 
			     $arr[$row['id']] = $row['groupname'];
			  }
				return $arr;
			}
			return false;
 		}

 		public function getPageAccessByRole($pageID,$roleID){
 			$conn = $this->conn;
 			$sql = "SELECT access_view,access_add,access_edit,access_delete FROM  usergroups_permission where page_id= '$pageID' and usergroup_id='$roleID' ";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				var_dump($row);
				return $row;	
			}
			return false;
 		}

 		public function defaultCols(){
 			$arr = ['access_view'=>'View','access_add'=>'Add','access_edit'=>'Edit','access_delete'=>'Delete','all'=>'All'];
 			return $arr; 
 		}
 		public function setPermissionData($roleId) {
    $conn = $this->conn;

    // Delete existing permissions for the role
    $delSql = "DELETE FROM usergroups_permission WHERE page_id IS NOT NULL AND usergroup_id = '$roleId'";
    $conn->query($delSql);

    // Fetch the list of pages
    $listData = $this->pagesList(0);

    foreach($listData as $_id => $_data) {
        // Insert permissions for parent page
        $_v = isset($_POST['access_view_' . $_id]) && !empty((int)$_POST['access_view_' . $_id]) ? '1' : '0';
        $_a = isset($_POST['access_add_' . $_id]) && !empty((int)$_POST['access_add_' . $_id]) ? '1' : '0';
        $_e = isset($_POST['access_edit_' . $_id]) && !empty((int)$_POST['access_edit_' . $_id]) ? '1' : '0';
        $_d = isset($_POST['access_delete_' . $_id]) && !empty((int)$_POST['access_delete_' . $_id]) ? '1' : '0';

        $iSql = "INSERT INTO usergroups_permission (usergroup_id, page_id, access_view, access_add, access_edit, access_delete) 
                 VALUES ('$roleId', '$_id', '$_v', '$_a', '$_e', '$_d')";
        $conn->query($iSql);

        // Insert permissions for child pages (if any)
        if (!empty($_data['childs'])) {
            foreach($_data['childs'] as $_idC => $_childData) {
                $_vC = isset($_POST['access_view_' . $_idC]) && !empty((int)$_POST['access_view_' . $_idC]) ? '1' : '0';
                $_aC = isset($_POST['access_add_' . $_idC]) && !empty((int)$_POST['access_add_' . $_idC]) ? '1' : '0';
                $_eC = isset($_POST['access_edit_' . $_idC]) && !empty((int)$_POST['access_edit_' . $_idC]) ? '1' : '0';
                $_dC = isset($_POST['access_delete_' . $_idC]) && !empty((int)$_POST['access_delete_' . $_idC]) ? '1' : '0';

                $iSqlC = "INSERT INTO usergroups_permission (usergroup_id, page_id, access_view, access_add, access_edit, access_delete) 
                          VALUES ('$roleId', '$_idC', '$_vC', '$_aC', '$_eC', '$_dC')";
                $conn->query($iSqlC);
            }
        }
    }
}

 	}
?>