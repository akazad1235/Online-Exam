<?php
$filepath=realpath(dirname(__FILE__));
include_once($filepath.'/../lib/Session.php');
include_once($filepath.'/../lib/Database.php');
include_once($filepath.'/../helpers/Format.php');

?>
<?php
class Admin{
    private $db;
    private $fm;
    public function __construct(){
        $this->db=new Database();
        $this->fm=new Format();
    }
  
    public function getAdminData($data){
        $adminUser=$this->fm->validation($data['admin_user']);
        $adminPass=$this->fm->validation($data['admin_pass']);
        $adminUser=mysqli_real_escape_string($this->db->link, $adminUser);
        $adminPass=mysqli_real_escape_string($this->db->link, md5($adminPass));

        $query="SELECT * FROM tbl_admin where admin_user='$adminUser' and admin_pass='$adminPass'";
         $result=$this->db->select($query);
         if ($result !=false) {
             $value=$result->fetch_assoc();
             Session::init();
             Session::set("adminLogin", Ture);
             Session::set("adminUser", $value['adminUser']);
             Session::set("adminLogin", $value['adminPass']);
             header("Location:index.php");
             
         }else{
             $msg="<span class='error'>usernaem or password not match</span>";
             return $msg;
         }


    }
}
?>