<?php
   class Podcast extends Database
   {
       public $data;
       public $image;
       public $pod;
       public $error = [];

       public function setData($data)
       {
           $this->data = $data;
       }
       public function setImg($file)
       {
           $this->image = $file;
       }
       public function setPod($file)
       {
           $this->pod = $file;
       }
       public function selectAll()
        {
            $select_query = "SELECT * FROM podcasts WHERE deleted=0";
            $stmt = $this->DBHandler->query($select_query);
            if($stmt->rowCount() > 0)
            {
                while($row = $stmt->fetch())
                {
                    $sequel = "SELECT * FROM tags WHERE id = ?";
                    $prep_stmt = $this->DBHandler->prepare($sequel);
                    $prep_stmt->execute([$row['tag']]);
                    $res = $prep_stmt->fetch();
                    $row['tag'] = $res['tag'];
                    $data[] = $row;
                }
                return $data;
            }
        }
       public function validate_tag(){
           $sequel = "SELECT * FROM tags WHERE tag=?";
           $prep_stmt = $this->DBHandler->prepare($sequel);
           $prep_stmt->execute([$this->data['tag']]);
           $result = $prep_stmt->fetch();
           if($prep_stmt->rowCount() == 0){
               $query = "INSERT INTO tags(tag) VALUE(?)";
               $prep_stmt = $this->DBHandler->prepare($query);
               $prep_stmt->execute([$this->data['tag']]);
               $sequel = "SELECT * FROM tags WHERE tag=?";
               $prep_stm = $this->DBHandler->prepare($sequel);
               $prep_stm->execute([$this->data['tag']]);
               $result = $prep_stm->fetch();
           }
           $this->data['tag'] = $result['id'];
       }
       public function insert_post()
       {
           $this->validate_tag();
           $keys = implode(',',array_keys($this->data));
           $values = implode(', :',array_keys($this->data));
           $sequel = "INSERT INTO podcasts ($keys) VALUES(:".$values.")";
           $prep_stmt = $this->DBHandler->prepare($sequel);
           foreach($this->data as $key => $value)
           {
               $prep_stmt->bindValue(':'.$key,$value);
           }
           $exec = $prep_stmt->execute();
           if($exec){
               header('Location: pages/data-tables.php');
           }
       }
       public function select_this($id)
       {
           $sequel = "SELECT * FROM podcasts WHERE id = ?";
           $stmt = $this->DBHandler->prepare($sequel);
           $stmt->execute([$id]);
           $result = $stmt->fetch();
           /////
           $sql = "SELECT * FROM tags WHERE id = ?";
           $prep_stmt = $this->DBHandler->prepare($sql);
           $prep_stmt->execute([$result['tag']]);
           $tag_result = $prep_stmt->fetch();
           $result['tag'] = $tag_result['tag'];
           return $result;
       }
       public function display_errors()
       {
           $display = "<ul class='bg-info text-center m-b-18'>";
           foreach ($this->error as $key) 
           {
               # code...
               $display .= "<li class='text-danger'>".$key."</li>";
           }
           $display .= "</ul>";
           return $display;
       }
       public function upload_cover_image()
       {
           $name = $this->image['name'];
           $type = $this->image['type'];
           $size = $this->image['size'];
           $format = ['jpg','jpeg','png'];
           $tmp = $this->image['tmp_name'];
           $ext = explode('.',$name);
           $actExt = strtolower(end($ext));
           $file_name = sha1(microtime()).".".$actExt;
           $upload_name = '/Podcast/View/Admin/Uploads/'.$file_name;
           $dir = $_SERVER['DOCUMENT_ROOT']."/Podcast/View/Admin/Uploads/".$file_name;
           if($size > 101010101)
           {
               $this->error[] = "File too large";
           }
           if(!in_array($actExt,$format)){
               $this->error[] = "Image Format not allowed";
           }
           if(empty($this->error)){
               move_uploaded_file($tmp,$dir);
               $this->data['pod_photo'] = $upload_name;
           }
       }
       public function upload_podcast()
       {
           $name = $this->pod['name'];
           $type = $this->pod['type'];
           //$size = $this->image['size'];
           $tmp = $this->pod['tmp_name'];
           $ext = explode('.',$name);
           $actExt = strtolower(end($ext));
           $file_name = sha1(microtime()).".".$actExt;
           $upload_name = '/Podcast/View/Admin/Podcast-files/'.$file_name;
           $dir = $_SERVER['DOCUMENT_ROOT']."/Podcast/View/Admin/Podcast-files/".$file_name;
           if($actExt !== "mp3"){
               $this->error[] = "File Format not allowed";
           }
           if(empty($this->error)){
               move_uploaded_file($tmp,$dir);
               $this->data['pod_file'] = $upload_name;
           }
       }
       public function update($id)
        {
            $this->validate_tag();
            $st = "";
            foreach ($this->data  as $key => $value) 
            {
                $st .= "$key = :".$key.", ";
            }
            $sql = "";
            $sql.= "UPDATE podcasts SET ".rtrim($st,', ');
            $sql.= " WHERE id = ".$id;
            $stmt = $this->DBHandler->prepare($sql);
            foreach ($this->data as $key => $value) 
            {
                # code...
                $stmt->bindValue(":".$key,$value);
            }
            $exec = $stmt->execute();
            if($exec)
            {
                header('Location: pages/data-tables.php');
            }
        }
        public function delete_this($id)
        {
            $sequel = "UPDATE podcasts SET deleted = 1 WHERE id=?";
            $stmt = $this->DBHandler->prepare($sequel);
            $exec = $stmt->execute([$id]);
            if($exec)
            {
                header('Location: pages/data-tables.php');
            }
        }
        public function addUser()
        {
            $keys = implode(',',array_keys($this->data));
            $values = implode(', :',array_keys($this->data));
            $sequel = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->DBHandler->prepare($sequel);
            $stmt->execute([$this->data['email']]);
            if($stmt->rowCount() > 0)
            {
                $this->error[] = "User with this email already exist!";
            }

            if(!empty($this->error))
            {
                echo $this->display_errors();
            }else
            {
                $sequel = "INSERT INTO users ($keys) VALUES (:".$values.")";
                $stmt = $this->DBHandler->prepare($sequel);
                foreach ($this->data as $key => $value)
                {
                    # code...
                    $stmt->bindValue(":".$key,$value);
                }
                $exec = $stmt->execute();
                if($exec)
                {
                    header('Location: ../../../index.php');
                }
            }
        }
        public function login()
        {
            $sequel = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->DBHandler->prepare($sequel);
            $stmt->execute([$this->data['email']]);
            $result = $stmt->fetch();
            if($stmt->rowCount() == 0)
            {
                $this->error[] = "User not found";
            }
            if(!empty($this->error))
            {
                echo $this->display_errors();    
            }else
            {
                if(!password_verify($this->data['pword'],$result['pword']))
                {
                    $this->error[] = "Password does not match our record.Try again";
                }
                if(!empty($this->error))
                {
                    echo $this->display_errors();
                }else
                {
                    SessionWrapper::start();
                    SessionWrapper::set('user_id',$result);
                    if(self::has_persmission()){
                        header('Location: ../pages/data-tables.php');
                    }else{
                        header('Location: ../../../index.php');
                    }
                }
            }
        }
        public static function is_logged_in()
        {
            if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
            {
                return true;
            }
            return false;
        }
        public static function login_error_redirect($url)
        {
            SessionWrapper::set('error_flash','You have no permission to this page');
            if(isset($_SESSION['user_id']))
            {
                unset($_SESSION['error_flash']);
            }
            header('Location: '.$url);
        }
        public static function logOut()
        {
            if(isset($_SESSION))
            {
                SessionWrapper::destroy();
            }
            if(strpos($_SERVER['REQUEST_URI'],'pages') !== false){
                header("Location: ../Login/login.php");
            }elseif(strpos($_SERVER['REQUEST_URI'],'concept-master') !== false){
                header("Location: Login/login.php");
            }elseif(strpos($_SERVER['REQUEST_URI'],'View') !== false){
                header('Location: index.php');
            }
        }
        public function select_tags()
        {
            $sequel = "SELECT * FROM tags";
            $stmt = $this->DBHandler->query($sequel);
            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch())
                {
                    $data[] = $row;
                }
                return $data;
            }
        }
        public static function has_persmission()
        {
            if(isset($_SESSION['user_id']) && $_SESSION['user_id']['permission'] == 1){
                return true;
            }
            return false;
        }
        public function select_users()
        {
            $sequel = "SELECT * FROM users";
            $stmt = $this->DBHandler->query($sequel);
            if($stmt->rowCount() > 0){
                while($user = $stmt->fetch()){
                    $userData[] = $user;
                }
                return $userData;
            }
        }

        public function selectThis($tag){
            $sql = "SELECT * FROM tags WHERE tag = ?";
            $stmt = $this->DBHandler->prepare($sql);
            $stmt->execute([$tag]);
            $result = $stmt->fetch();
            $sequel = "SELECT * FROM podcasts WHERE tag = ?";
            $stmt = $this->DBHandler->prepare($sequel);
            $stmt->execute([$result['id']]);
            if($stmt->rowCount() > 0){
                while($data = $stmt->fetch()){
                    $row[] = $data;
                }
                return $row;
            }
        }
        public function select_deleted_post(){
            $sequel = "SELECT * FROM podcasts WHERE deleted = 1";
            $stmt= $this->DBHandler->query($sequel);
            if($stmt->rowCount() > 0){
                while($res = $stmt->fetch()){
                    $data[] = $res;
                }
                return $data;
            }
        }
        public function undo_delete($id){
            $sequel = "UPDATE podcasts SET deleted = 0 WHERE id = ?";
            $prep_stmt = $this->DBHandler->prepare($sequel);
            $undo = $prep_stmt->execute([$id]);
            if($undo){
                header('Location: pages/deleted.php');
            }

        }
   }
?>