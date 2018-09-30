<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal_info extends CI_Controller {
    public function index() {
        $this->load->model('user');
        @$user_id = $_SESSION['user_id'];
        $list = $this->user->show_user_info($user_id);
        $data['list'] = $list;
        $this->load->view('personal_center/personal_info', $data);
        unset($data['info']);
    }

    public function update_page() {
        $this->load->model('user');
        @$user_id = $_SESSION['user_id'];
        $list = $this->user->show_user_info($user_id);
        $data['list'] = $list;
        $this->load->view('personal_center/update_info_page', $data);
        unset($data['info']);
    }

    public function update() {
        $this->load->model('user');
        @$data['user_id'] = $_SESSION['user_id'];
        $data['name'] = $_REQUEST['name'];
        $data['sex'] = $_REQUEST['sex'];
        $data['age'] = $_REQUEST['age'];
        $data['phone'] = $_REQUEST['phone'];
        $data['email'] = $_REQUEST['email'];
        $result = $this->user->update($data);
        if ($result) {
            unset($data);
            $list = $this->user->show_user_info($_SESSION['user_id']);
            $data['list'] = $list;
            $data['info'] = "修改成功";
            $this->load->view('personal_center/update_info_page', $data);
            unset($data['info']);
        }else {
            unset($data);
            $list = $this->user->show_user_info($_SESSION['user_id']);
            $data['list'] = $list;
            $data['info'] = "修改失败";
            $this->load->view('personal_center/update_info_page', $data);
            unset($data['info']);
        }
    }

    public function user_address() {
        $this->load->model('address');
        @$user_id = $_SESSION['user_id'];
        $list = $this->address->show_address($user_id);
        $data['list'] = $list;
        $this->load->view('personal_center/user_address', $data);
        unset($data['info']);
    }

    public function add_address(){
        $this->load->model("address");
        @$user_id = $_SESSION['user_id'];
        $contactor = $_REQUEST['contactor'];
        $phone = $_REQUEST['phone'];
        $address = $_REQUEST['address'];
        $result = $this->address->add_address($user_id, $contactor, $phone, $address);
        if ($result) {
            $list = $this->address->show_address($user_id);
            $data['list'] = $list;
            $data['info'] = '添加成功';
            $this->load->view('personal_center/user_address', $data);
            unset($data['info']);
        }else {
            $list = $this->address->show_address($user_id);
            $data['list'] = $list;
            $data['info'] = '添加失败';
            $this->load->view('personal_center/user_address', $data);
            unset($data['info']);
        }
    }

    public function delete_address(){
        $this->load->model('address');
        $address_id = $_REQUEST['address_id'];
        $user_id = $_SESSION['user_id'];
        $result = $this->address->delete_address($user_id, $address_id);
        if($result) {
            $response = array(
                'errno' => 0,
                'errmsg' => 'success',
                'data' => true,
            );
        }else {
            $response = array(
                'errno' => 1,
                'errmsg' => 'fail',
                'data' => false,
            );
        }
        echo json_encode($response);
    }

    public function change_img_page() {
        $this->load->view('personal_center/change_img');
    }

    public function change_img() {
        if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
            $upfile=$_FILES["upfile"];
            //获取数组里面的值
            $name=$upfile["name"];//上传文件的文件名
            $type=$upfile["type"];//上传文件的类型
            $size=$upfile["size"];//上传文件的大小
            $tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径
            //判断是否为图片
            switch ($type){
                case 'image/pjpeg':
                    $okType=true;
                    break;
                case 'image/jpeg':
                    $okType=true;
                    break;
                case 'image/gif':
                    $okType=true;
                    break;
                case 'image/png':
                    $okType=true;
                    break;
                default:
                    $okType = false;
                    break;
            }

            if($okType){
                /**
                 * 0:文件上传成功<br/>
                 * 1：超过了文件大小，在php.ini文件中设置<br/>
                 * 2：超过了文件的大小MAX_FILE_SIZE选项指定的值<br/>
                 * 3：文件只有部分被上传<br/>
                 * 4：没有文件被上传<br/>
                 * 5：上传文件大小为0
                 */
                $error=$upfile["error"];//上传后系统返回的值
//                echo "================<br/>";
//                echo "上传文件名称是：".$name."<br/>";
//                echo "上传文件类型是：".$type."<br/>";
//                echo "上传文件大小是：".$size."<br/>";
//                echo "上传后系统返回的值是：".$error."<br/>";
//                echo "上传文件的临时存放路径是：".$tmp_name."<br/>";
//
//                echo "开始移动上传文件<br/>";
                //把上传的临时文件移动到up目录下面
                $type = strrchr($name, '.');
                $name = $_SESSION['user_id'];
                $destination='/Users/hpf/web/gouwu/public/image/'.$name.$type;
                move_uploaded_file($tmp_name, $destination);


                if($error==0){
                    $_SESSION['info'] = "文件上传成功啦！" . $destination;
                }elseif ($error==1){
                    $_SESSION['info'] = "超过了文件大小，在php.ini文件中设置";
                }elseif ($error==2){
                    $_SESSION['info'] = "超过了文件的大小MAX_FILE_SIZE选项指定的值";
                }elseif ($error==3){
                    $_SESSION['info'] = "文件只有部分被上传";
                }elseif ($error==4){
                    $_SESSION['info'] = "没有文件被上传";
                }else{
                    $_SESSION['info'] = "上传文件大小为0";
                }
            }else{
                $_SESSION['info'] = "请上传jpg,gif,png等格式的图片！";
            }
        }
        $this->load->view('personal_center/change_img');
    }
}
