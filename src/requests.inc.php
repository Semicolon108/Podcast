<?php
    if(isset($_POST['submit']))
    {
        $obj = new Podcast;
        $title = $_POST['title'];
        $tag = $_POST['tag'];
        $description = $_POST['description'];
        $required_fields = ['title','tag','description'];

        $fields = [
            'title'=>$title,
            'tag'=>$tag,
            'description'=>$description,
            'pod_photo'=>'',
            'pod_file'=>''
        ];
        
       foreach ($required_fields as $key) 
        {
            if(isset($_POST[$key]) && empty($_POST[$key]) || empty($_FILES['photo']['name'])   || empty($_FILES['pod_file']['name']))
            {
                $obj->error[] = "All feilds are required";
            break;
            }
        }
        if(!empty($obj->error))
        {
            echo $obj->display_errors();
        }else{
            $obj->setData($fields);
            $obj->setImg($_FILES['photo']);
            $obj->upload_cover_image();
            if(empty($obj->error)){
                $obj->setPod($_FILES['pod_file']);
                $obj->upload_podcast();
            }
            if(!empty($obj->error)){
                echo display_errors();
            }else{
                $obj->insert_post();
            }
        }
    }
   if(isset($_GET['edit']))
    {
        $edit_id = $_GET['edit'];
        $edit_data = new Podcast;
        $data = $edit_data->select_this($edit_id);

        if(isset($_POST['edit']))
        {
            $title = $_POST['title'];
            $tag = $_POST['tag'];
            $description = $_POST['description'];
            $required_fields = ['title','tag','description'];

            $fields = [
            'title'=>$title,
            'tag'=>$tag,
            'description'=>$description,
            'pod_photo'=>$data['pod_photo'],
            'pod_file'=>$data['pod_file']
        ];
        foreach ($required_fields as $key) 
        {
            if(isset($_POST[$key]) && empty($_POST[$key]))
            {
                $edit_data->error[] = "All feilds are required";
            break;
            }
        }
            if(!empty($edit_data->error))
            {
                echo $edit_data->display_errors();
            }else
            {
                $edit_data->setData($fields);
                if(!empty($_FILES['pod_file']['name'])){
                    $edit_data->setPod($_FILES['pod_file']);
                    $edit_data->upload_podcast();
                }
                if(!empty($_FILES['photo']['name'])){
                    $edit_data->setImg($_FILES['photo']);
                    $edit_data->upload_cover_image();
                }
                if(empty($edit_data->error)){
                    $edit_data->update($edit_id);
                }else{
                    echo $edit_data->display_errors();
                }
            }
        }           
    }
    if(isset($_GET['delete']))
    {
        $delete_id = $_GET['delete'];
        $obj = new Podcast;
        $obj->delete_this($delete_id);
    }
    if(isset($_POST['signup']))
    {
        $email = $_POST['email'];
        $pword = $_POST['pword'];
        $rPword = $_POST['r-pword'];
        $obj = new Podcast;
        if($pword != $rPword)
        {
            $obj->error[] = "Password does not match";
        }
        $fields = [
            'email'=>$email,
            'pword'=>password_hash($pword,PASSWORD_DEFAULT)
        ];
        if(!empty($obj->error))
        {
            echo $obj->display_errors();
        }else
        {
            $obj->setData($fields);
            $obj->addUser();
        }
    }
    if(isset($_POST['login']))
    {
        $email = $_POST['email'];
        $pword = $_POST['pword'];
        $obj = new Podcast;
        $obj->setData(['email'=>$email,'pword'=>$pword]);
        $obj->login();

    }
    if(isset($_GET['logout'])){
        $obj = new Podcast;
        $obj::logOut();
    }
?>